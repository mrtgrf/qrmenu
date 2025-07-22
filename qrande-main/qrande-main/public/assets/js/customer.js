document.addEventListener("DOMContentLoaded", function() {
    let cart = JSON.parse(localStorage.getItem("qr_menu_cart")) || {};
    let quantities = {};

    const cartItemsElement = document.getElementById("cart-items");
    const cartTotalElement = document.getElementById("cart-total");
    const placeOrderButton = document.getElementById("place-order");
    const callWaiterButton = document.getElementById("call-waiter");

    updateCartDisplay();
    updateQuantityDisplays();

    function saveCart() {
        localStorage.setItem("qr_menu_cart", JSON.stringify(cart));
    }

    function updateCartDisplay() {
        if (!cartItemsElement || !cartTotalElement) return;
        
        cartItemsElement.innerHTML = "";
        let total = 0;
        
        for (const itemId in cart) {
            const item = cart[itemId];
            const listItem = document.createElement("li");
            listItem.innerHTML = `
                ${item.name} (x${item.quantity}) - ${(item.price * item.quantity).toFixed(2)} TL
                <button class="remove-from-cart" data-item-id="${itemId}">Kaldır</button>
            `;
            cartItemsElement.appendChild(listItem);
            total += item.price * item.quantity;
        }
        
        cartTotalElement.textContent = total.toFixed(2);
    }

    function showMessage(message, type = 'info') {
        const existingMessages = document.querySelectorAll('.message');
        existingMessages.forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = `message message-${type}`;
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 3000;
            max-width: 300px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            animation: slideIn 0.3s ease;
        `;
        
        if (type === 'success') {
            messageDiv.style.background = 'rgba(46, 204, 113, 0.9)';
            messageDiv.style.border = '1px solid rgba(46, 204, 113, 0.3)';
        } else if (type === 'error') {
            messageDiv.style.background = 'rgba(231, 76, 60, 0.9)';
            messageDiv.style.border = '1px solid rgba(231, 76, 60, 0.3)';
        } else {
            messageDiv.style.background = 'rgba(52, 152, 219, 0.9)';
            messageDiv.style.border = '1px solid rgba(52, 152, 219, 0.3)';
        }
        
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);

        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }

    function setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.textContent;
            button.textContent = 'İşleniyor...';
        } else {
            button.disabled = false;
            button.textContent = button.dataset.originalText;
        }
    }

    function getTableIdFromUrl() {
        const pathParts = window.location.pathname.split('/');
        const menuIndex = pathParts.indexOf('menu');
        if (menuIndex !== -1 && pathParts[menuIndex + 1]) {
            return pathParts[menuIndex + 1];
        }
        return null;
    }

    if (cartItemsElement) {
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function() {
                const itemId = this.dataset.itemId;
                const itemName = this.dataset.itemName;
                const itemPrice = parseFloat(this.dataset.itemPrice);

                if (cart[itemId]) {
                    cart[itemId].quantity++;
                } else {
                    cart[itemId] = { id: itemId, name: itemName, price: itemPrice, quantity: 1 };
                }
                saveCart();
                updateCartDisplay();
                showMessage(`${itemName} sepete eklendi!`, 'success');
            });
        });

        cartItemsElement.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-from-cart")) {
                const itemId = event.target.dataset.itemId;
                if (cart[itemId]) {
                    const itemName = cart[itemId].name;
                    cart[itemId].quantity--;
                    if (cart[itemId].quantity <= 0) {
                        delete cart[itemId];
                    }
                    saveCart();
                    updateCartDisplay();
                    showMessage(`${itemName} sepetten kaldırıldı!`, 'info');
                }
            }
        });
    }

    if (placeOrderButton) {
        placeOrderButton.addEventListener("click", async function() {
            if (Object.keys(cart).length === 0) {
                showMessage("Sepetiniz boş! Lütfen önce ürün ekleyin.", 'error');
                return;
            }

            const tableId = getTableIdFromUrl();
            
            if (!tableId) {
                showMessage("Masa numarası bulunamadı. Lütfen QR kodunu kullanarak erişin.", 'error');
                return;
            }

            const orderItems = Object.values(cart).map(item => ({
                id: item.id,
                quantity: item.quantity,
                price: item.price
            }));
            const totalAmount = parseFloat(cartTotalElement.textContent);

            setButtonLoading(this, true);

            try {
                const response = await fetch("/api/place-order", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        table_id: tableId,
                        order_items: orderItems,
                        total_amount: totalAmount
                    })
                });

                const result = await response.json();

                if (result.status === "success") {
                    showMessage(result.message, 'success');
                    cart = {};
                    saveCart();
                    updateCartDisplay();
                } else {
                    showMessage("Sipariş verilirken hata: " + result.message, 'error');
                }
            } catch (error) {
                console.error("Sipariş hatası:", error);
                showMessage("Sipariş verilirken bir hata oluştu.", 'error');
            } finally {
                setButtonLoading(this, false);
            }
        });
    }

    if (callWaiterButton) {
        callWaiterButton.addEventListener("click", async function() {
            const tableId = getTableIdFromUrl();
            
            if (!tableId) {
                showMessage("Masa numarası bulunamadı. Lütfen QR kodunu kullanarak erişin.", 'error');
                return;
            }

            setButtonLoading(this, true);

            try {
                const response = await fetch("/api/call-waiter", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        table_id: tableId
                    })
                });

                const result = await response.json();

                if (result.status === "success") {
                    showMessage(result.message, 'success');
                } else {
                    showMessage("Garson çağrılırken hata: " + result.message, 'error');
                }
            } catch (error) {
                console.error("Garson çağırma hatası:", error);
                showMessage("Garson çağrılırken bir hata oluştu.", 'error');
            } finally {
                setButtonLoading(this, false);
            }
        });
    }

    window.increaseQuantity = function(itemId) {
        quantities[itemId] = (quantities[itemId] || 0) + 1;
        updateQuantityDisplay(itemId);
    };

    window.decreaseQuantity = function(itemId) {
        if (quantities[itemId] > 0) {
            quantities[itemId]--;
            updateQuantityDisplay(itemId);
        }
    };

    window.updateQuantityDisplay = function(itemId) {
        const display = document.getElementById(`quantity-${itemId}`);
        if (display) {
            display.textContent = quantities[itemId] || 0;
        }
    };

    window.updateQuantityDisplays = function() {
        Object.keys(quantities).forEach(itemId => {
            updateQuantityDisplay(itemId);
        });
    };

    window.addToCart = function(itemId) {
        let quantity = quantities[itemId] || 0;
        if (quantity === 0) {
            quantity = 1; // Eğer miktar seçilmemişse varsayılan olarak 1 ekle
        }

        const button = document.querySelector(`[data-item-id="${itemId}"]`);
        const itemName = button.dataset.itemName;
        const itemPrice = parseFloat(button.dataset.itemPrice);

        if (cart[itemId]) {
            cart[itemId].quantity += quantity;
        } else {
            cart[itemId] = { 
                id: itemId, 
                name: itemName, 
                price: itemPrice, 
                quantity: quantity 
            };
        }

        quantities[itemId] = 0;
        updateQuantityDisplay(itemId);

        saveCart();
        updateCartDisplayV2();
        showMessage(`${itemName} sepete eklendi!`, 'success');
    };

    window.removeFromCart = function(itemId) {
        if (cart[itemId]) {
            const itemName = cart[itemId].name;
            delete cart[itemId];
            saveCart();
            updateCartDisplayV2();
            showMessage(`${itemName} sepetten kaldırıldı!`, 'info');
        }
    };

    window.updateCartItemQuantity = function(itemId, newQuantity) {
        if (newQuantity <= 0) {
            removeFromCart(itemId);
        } else {
            cart[itemId].quantity = newQuantity;
            saveCart();
            updateCartDisplayV2();
        }
    };

    window.updateCartDisplayV2 = function() {
        const cartContent = document.getElementById('cartContent');
        const emptyCart = document.getElementById('emptyCart');
        const cartCount = document.getElementById('cartCount');
        const cartTotal = document.getElementById('cartTotal');
        
        if (!cartContent || !cartCount || !cartTotal) return;
        
        const itemCount = Object.keys(cart).length;
        const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        if (itemCount > 0) {
            cartCount.style.display = 'flex';
            cartCount.textContent = itemCount;
        } else {
            cartCount.style.display = 'none';
        }
        
        cartTotal.textContent = `₺${totalAmount.toFixed(0)}`;
        
        if (itemCount === 0) {
            if (emptyCart) emptyCart.style.display = 'block';
            cartContent.innerHTML = '<div class="empty-cart" id="emptyCart"><p>Sepetiniz boş</p><p style="font-size: 0.9rem; margin-top: 8px;">Lezzetli ürünlerimizi keşfedin!</p></div>';
        } else {
            if (emptyCart) emptyCart.style.display = 'none';
            cartContent.innerHTML = '';
            
            Object.values(cart).forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">₺${item.price.toFixed(0)} x ${item.quantity}</div>
                    </div>
                    <div class="cart-item-controls">
                        <button class="quantity-btn" onclick="updateCartItemQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateCartItemQuantity(${item.id}, ${item.quantity + 1})">+</button>
                        <button class="quantity-btn" onclick="removeFromCart(${item.id})" style="margin-left: 8px; background: rgba(231, 76, 60, 0.2); border-color: rgba(231, 76, 60, 0.3);">×</button>
                    </div>
                `;
                cartContent.appendChild(cartItem);
            });
        }
    };

    window.toggleCart = function() {
        const cartSidebar = document.getElementById('cartSidebar');
        if (cartSidebar) {
            cartSidebar.classList.toggle('open');
        }
    };

    window.placeOrder = async function() {
        if (Object.keys(cart).length === 0) {
            showMessage("Sepetiniz boş! Lütfen önce ürün ekleyin.", 'error');
            return;
        }

        const { tableId, license } = getTableIdAndLicense();
        
        if (!tableId || !license) {
            showMessage("Masa numarası veya lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin.", 'error');
            return;
        }

        const orderItems = Object.values(cart).map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
        }));
        const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);

        const button = document.getElementById('placeOrderBtn');
        setButtonLoading(button, true);

        try {
            const response = await fetch("/api/place-order", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    table_id: tableId,
                    license: license,
                    order_items: orderItems,
                    total_amount: totalAmount
                })
            });

            const result = await response.json();

            if (result.status === "success") {
                showMessage(result.message, 'success');
                cart = {};
                quantities = {};
                saveCart();
                updateCartDisplayV2();
                updateQuantityDisplays();
                toggleCart();
            } else {
                showMessage("Sipariş verilirken hata: " + result.message, 'error');
            }
        } catch (error) {
            console.error("Sipariş hatası:", error);
            showMessage("Sipariş verilirken bir hata oluştu.", 'error');
        } finally {
            setButtonLoading(button, false);
        }
    };

    window.callWaiter = async function() {
        const { tableId, license } = getTableIdAndLicense();
        
        if (!tableId || !license) {
            showMessage("Masa numarası veya lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin.", 'error');
            return;
        }

        const button = document.getElementById('callWaiterBtn');
        setButtonLoading(button, true);

        try {
            const response = await fetch("/api/call-waiter", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    table_id: tableId,
                    license: license
                })
            });

            const result = await response.json();

            if (result.status === "success") {
                showMessage(result.message, 'success');
            } else {
                showMessage("Garson çağrılırken hata: " + result.message, 'error');
            }
        } catch (error) {
            console.error("Garson çağırma hatası:", error);
            showMessage("Garson çağrılırken bir hata oluştu.", 'error');
        } finally {
            setButtonLoading(button, false);
        }
    };

    window.scrollToTop = function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    if (typeof updateCartDisplayV2 === 'function') {
        updateCartDisplayV2();
    }
});

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
