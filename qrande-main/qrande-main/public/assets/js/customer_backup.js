document.addEventListener("DOMContentLoaded", function() {
    const cartItemsElement = document.getElementById("cart-items");
    const cartTotalElement = document.getElementById("cart-total");
    const placeOrderButton = document.getElementById("place-order");
    const callWaiterButton = document.getElementById("call-waiter");

    let cart = JSON.parse(localStorage.getItem("qr_menu_cart")) || {};

    function saveCart() {
        localStorage.setItem("qr_menu_cart", JSON.stringify(cart));
    }

    function renderCart() {
        cartItemsElement.innerHTML = "";
        let total = 0;
        for (const itemId in cart) {
            const item = cart[itemId];
            const listItem = document.createElement("li");
            listItem.innerHTML = `
                ${item.name} (x${item.quantity}) - ${item.price.toFixed(2)} TL
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
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            max-width: 300px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        `;
        
        if (type === 'success') {
            messageDiv.style.backgroundColor = '#4CAF50';
        } else if (type === 'error') {
            messageDiv.style.backgroundColor = '#f44336';
        } else {
            messageDiv.style.backgroundColor = '#2196F3';
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

    function getTableIdAndLicense() {
        const urlParams = new URLSearchParams(window.location.search);
        const tableId = window.location.pathname.split('/').pop().split('?')[0];
        const license = urlParams.get('license');
        
        return { tableId, license };
    }

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
            renderCart();
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
                renderCart();
                showMessage(`${itemName} sepetten kaldırıldı!`, 'info');
            }
        }
    });

    placeOrderButton.addEventListener("click", async function() {
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
                    license: license,
                    order_items: orderItems,
                    total_amount: totalAmount
                })
            });

            const result = await response.json();

            if (result.status === "success") {
                showMessage(result.message, 'success');
                cart = {};
                saveCart();
                renderCart();
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

    callWaiterButton.addEventListener("click", async function() {
        const { tableId, license } = getTableIdAndLicense();
        
        if (!tableId || !license) {
            showMessage("Masa numarası veya lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin.", 'error');
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
            setButtonLoading(this, false);
        }
    });

    renderCart();
});


