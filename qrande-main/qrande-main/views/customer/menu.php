<?php
$title = "BOSS LOUNGE MENU";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
            cursor: default;
        }

        /* İmleç stilleri - güçlendirilmiş */
        button, .clickable, .menu-item-actions button, .quantity-btn, .add-to-cart-btn, .floating-btn, 
        .category-btn, .close-cart, .cart-action-btn, .place-order-btn, .call-waiter-btn, .scroll-to-top {
            cursor: pointer !important;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        button:hover, .clickable:hover, .menu-item-actions button:hover, .quantity-btn:hover, 
        .add-to-cart-btn:hover, .floating-btn:hover, .category-btn:hover, .close-cart:hover, 
        .cart-action-btn:hover, .place-order-btn:hover, .call-waiter-btn:hover, .scroll-to-top:hover {
            cursor: pointer !important;
        }

        /* Tüm interaktif elementler için pointer cursor */
        [onclick], [data-item-id], [data-category] {
            cursor: pointer !important;
        }

        .grain-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 226, 0.3) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            text-align: center;
            padding: 60px 0 40px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            top: 0;
            z-index: 100;
        }

        .restaurant-name {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .restaurant-subtitle {
            font-size: 1.1rem;
            color: #888;
            font-weight: 400;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .search-container {
            margin: 40px 0;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
            cursor: text;
        }

        .search-input:focus {
            outline: none;
            border-color: rgba(120, 119, 198, 0.5);
            box-shadow: 0 0 0 3px rgba(120, 119, 198, 0.1);
            cursor: text;
        }

        .search-input::placeholder {
            color: #666;
        }

        .categories {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
            overflow-x: auto;
            padding: 10px 0;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .categories::-webkit-scrollbar {
            display: none;
        }

        .category-btn {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            backdrop-filter: blur(20px);
        }

        .category-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .category-btn.active {
            background: linear-gradient(135deg, rgba(120, 119, 198, 0.3) 0%, rgba(255, 119, 198, 0.3) 100%);
            border-color: rgba(120, 119, 198, 0.5);
            color: #ffffff;
        }

        .category-section {
            margin-bottom: 60px;
        }

        .category-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .menu-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .menu-item-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .menu-item-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #7877c6;
            background: rgba(120, 119, 198, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(120, 119, 198, 0.2);
        }

        .menu-item-description {
            color: #aaa;
            font-size: 0.9rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .menu-item-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .tag.vegetarian {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .tag.spicy {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .tag.new {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .menu-item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quantity-btn {
            width: 36px;
            height: 36px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
        }

        .quantity-display {
            min-width: 24px;
            text-align: center;
            font-weight: 600;
            color: #ffffff;
        }

        .add-to-cart-btn {
            flex: 1;
            padding: 12px 24px;
            background: linear-gradient(135deg, rgba(120, 119, 198, 0.8) 0%, rgba(255, 119, 198, 0.8) 100%);
            border: 1px solid rgba(120, 119, 198, 0.5);
            border-radius: 10px;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
        }

        .add-to-cart-btn:hover {
            background: linear-gradient(135deg, rgba(120, 119, 198, 1) 0%, rgba(255, 119, 198, 1) 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(120, 119, 198, 0.3);
            cursor: pointer;
        }

        .floating-elements {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            z-index: 1000;
        }

        .floating-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, rgba(120, 119, 198, 0.9) 0%, rgba(255, 119, 198, 0.9) 100%);
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .floating-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(120, 119, 198, 0.4);
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 2000;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            padding: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
        }

        .close-cart {
            background: none;
            border: none;
            color: #888;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: color 0.3s ease;
        }

        .close-cart:hover {
            color: #ffffff;
            cursor: pointer;
        }

        .cart-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px 30px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .cart-item-price {
            color: #888;
            font-size: 0.9rem;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-footer {
            padding: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.3);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .cart-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-action-btn {
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .place-order-btn {
            background: linear-gradient(135deg, rgba(120, 119, 198, 0.8) 0%, rgba(255, 119, 198, 0.8) 100%);
            color: #ffffff;
        }

        .place-order-btn:hover {
            background: linear-gradient(135deg, rgba(120, 119, 198, 1) 0%, rgba(255, 119, 198, 1) 100%);
            cursor: pointer;
        }

        .call-waiter-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .call-waiter-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-cart p:first-child {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 3000;
            animation: slideIn 0.3s ease;
        }

        .message-success {
            background: rgba(46, 204, 113, 0.9);
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .message-error {
            background: rgba(231, 76, 60, 0.9);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

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

        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(20px);
        }

        .scroll-to-top:hover {
            background: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .restaurant-name {
                font-size: 2.5rem;
            }

            .menu-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .cart-sidebar {
                width: 100%;
                right: -100%;
            }

            .floating-elements {
                bottom: 20px;
                right: 20px;
            }

            .floating-btn {
                width: 56px;
                height: 56px;
            }
        }

        .menu-item.unavailable {
            opacity: 0.5;
            pointer-events: none;
        }

        .menu-item.unavailable .menu-item-name::after {
            content: " (Tükendi)";
            color: #e74c3c;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="grain-overlay"></div>
    
    <div class="container">
        <div class="header">
            <h1 class="restaurant-name">B.O.S.S LOUNGE</h1>
            <p class="restaurant-subtitle">Nargile & Restaurant</p>
        </div>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Ürün ara..." id="searchInput">
        </div>

        <div class="categories">
            <button class="category-btn active" data-category="all">Tümü</button>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <?php if ($category["is_active"]): ?>
                        <button class="category-btn" data-category="<?php echo $category["id"]; ?>">
                            <?php echo htmlspecialchars($category["name"]); ?>
                        </button>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="menuContainer">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <?php if ($category["is_active"]): ?>
                        <div class="category-section fade-in" data-category="<?php echo $category["id"]; ?>">
                            <h2 class="category-title"><?php echo htmlspecialchars($category["name"]); ?></h2>
                            <div class="menu-grid">
                                <?php 
                                $categoryHasItems = false;
                                if (!empty($menuItems)): 
                                    foreach ($menuItems as $item): 
                                        if ($item["category_id"] == $category["id"]): 
                                            $categoryHasItems = true;
                                ?>
                                            <div class="menu-item <?php echo !$item["is_available"] ? 'unavailable' : ''; ?>" 
                                                 data-name="<?php echo strtolower(htmlspecialchars($item["name"])); ?>"
                                                 data-description="<?php echo strtolower(htmlspecialchars($item["description"])); ?>">
                                                
                                                <?php if (!empty($item["image_url"])): ?>
                                                    <div class="menu-item-image">
                                                        <img src="<?php echo htmlspecialchars($item["image_url"]); ?>" 
                                                             alt="<?php echo htmlspecialchars($item["name"]); ?>"
                                                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;">
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="menu-item-header">
                                                    <div>
                                                        <div class="menu-item-name">
                                                            <?php echo htmlspecialchars($item["name"]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="menu-item-price">
                                                        ₺<?php echo number_format($item["price"], 0); ?>
                                                    </div>
                                                </div>
                                                
                                                <?php if (!empty($item["description"])): ?>
                                                    <div class="menu-item-description">
                                                        <?php echo htmlspecialchars($item["description"]); ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="menu-item-tags">
                                                    <?php if ($item["is_vegetarian"]): ?>
                                                        <span class="tag vegetarian">Vejetaryen</span>
                                                    <?php endif; ?>
                                                    <?php if ($item["is_spicy"]): ?>
                                                        <span class="tag spicy">Baharatlı</span>
                                                    <?php endif; ?>
                                                    <?php if ($item["is_featured"]): ?>
                                                        <span class="tag new">Öne Çıkan</span>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if ($item["is_available"]): ?>
                                                    <div class="menu-item-actions">
                                                        <div class="quantity-controls">
                                                            <button class="quantity-btn" onclick="decreaseQuantity(<?php echo $item['id']; ?>)">-</button>
                                                            <span class="quantity-display" id="quantity-<?php echo $item['id']; ?>">0</span>
                                                            <button class="quantity-btn" onclick="increaseQuantity(<?php echo $item['id']; ?>)">+</button>
                                                        </div>
                                                        <button class="add-to-cart-btn" 
                                                                data-item-id="<?php echo $item['id']; ?>"
                                                                data-item-name="<?php echo htmlspecialchars($item['name']); ?>"
                                                                data-item-price="<?php echo $item['price']; ?>"
                                                                onclick="addToCart(<?php echo $item['id']; ?>)">
                                                            Sepete Ekle
                                                        </button>
                                                        <textarea 
    class="item-note" 
    id="note-<?php echo $item['id']; ?>" 
    placeholder="Not ekle (örn: soğansız)" 
    style="width: 100%; margin-top: 10px; padding: 8px; border-radius: 8px; font-size: 0.9rem; background: rgba(255,255,255,0.03); color: #fff; border: 1px solid rgba(255,255,255,0.1);">
</textarea>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php 
                                        endif; 
                                    endforeach; 
                                endif; 
                                if (!$categoryHasItems): 
                                ?>
                                    <div class="empty-state" style="grid-column: 1 / -1;">
                                        <p>Bu kategoride henüz ürün bulunmamaktadır.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="category-section fade-in">
                    <h2 class="category-title">Menü Yakında</h2>
                    <p style="text-align: center; color: #666; font-size: 1.1rem; margin-top: 40px;">
                        Mutfak ekibimiz sizin için özel bir şeyler hazırlıyor.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <button class="floating-btn cart-btn" onclick="toggleCart()" title="Sepet">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="m1 1 4 4 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="cart-count" id="cartCount">0</span>
        </button>
    </div>

    <button class="scroll-to-top" onclick="scrollToTop()" title="Yukarı">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m18 15-6-6-6 6"/>
        </svg>
    </button>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3 class="cart-title">Sepetim</h3>
            <button class="close-cart" onclick="toggleCart()">×</button>
        </div>
        <div class="cart-content" id="cartContent">
            <div class="empty-cart" id="emptyCart">
                <p>Sepetiniz boş</p>
                <p style="font-size: 0.9rem; margin-top: 8px;">Lezzetli ürünlerimizi keşfedin!</p>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Toplam:</span>
                <span id="cartTotal">₺0</span>
            </div>
            <div class="cart-actions">
                <button class="cart-action-btn place-order-btn" id="placeOrderBtn" onclick="placeOrder()">
                    Sipariş Ver
                </button>
                <button class="cart-action-btn call-waiter-btn" id="callWaiterBtn" onclick="callWaiter()">
                    Garson Çağır
                </button>
            </div>
        </div>
    </div>

    <script>
        let cart = {};
        let quantities = {};
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOMContentLoaded fired");
            loadCart();
            updateCartDisplay();
            updateQuantityDisplays();
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');
                
                menuItems.forEach(item => {
                    const name = item.dataset.name || '';
                    const description = item.dataset.description || '';
                    
                    if (name.includes(searchTerm) || description.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
            const categoryBtns = document.querySelectorAll('.category-btn');
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.dataset.category;
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const sections = document.querySelectorAll('.category-section');
                    sections.forEach(section => {
                        if (category === 'all' || section.dataset.category === category) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        });
        function loadCart() {
            const savedCart = localStorage.getItem('cart');
            const savedQuantities = localStorage.getItem('quantities');
            
            if (savedCart) {
                cart = JSON.parse(savedCart);
            }
            if (savedQuantities) {
                quantities = JSON.parse(savedQuantities);
            }
        }
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            localStorage.setItem('quantities', JSON.stringify(quantities));
        }
        function increaseQuantity(itemId) {
            console.log("increaseQuantity çağrıldı:", itemId);
            quantities[itemId] = (quantities[itemId] || 0) + 1;
            updateQuantityDisplay(itemId);
            saveCart();
        }
        function decreaseQuantity(itemId) {
            console.log("decreaseQuantity çağrıldı:", itemId);
            if (quantities[itemId] > 0) {
                quantities[itemId]--;
                updateQuantityDisplay(itemId);
                saveCart();
            }
        }
        function updateQuantityDisplay(itemId) {
            const display = document.getElementById(`quantity-${itemId}`);
            if (display) {
                display.textContent = quantities[itemId] || 0;
            }
        }
        function updateQuantityDisplays() {
            Object.keys(quantities).forEach(itemId => {
                updateQuantityDisplay(itemId);
            });
        }
     function addToCart(itemId) {
    console.log("addToCart çağrıldı:", itemId);
    const quantity = quantities[itemId] || 0;
    if (quantity === 0) {
        showMessage("Lütfen önce miktar seçin!", 'error');
        return;
    }

    const button = document.querySelector(`[data-item-id="${itemId}"]`);
    const itemName = button.dataset.itemName;
    const itemPrice = parseFloat(button.dataset.itemPrice);
    const noteInput = document.getElementById(`note-${itemId}`);
    const itemNote = noteInput ? noteInput.value.trim() : "";
    if (cart[itemId]) {
        cart[itemId].quantity += quantity;
        if (itemNote !== "") {
            cart[itemId].note = itemNote;
        }
    } else {
        cart[itemId] = {
            id: itemId,
            name: itemName,
            price: itemPrice,
            quantity: quantity,
            note: itemNote
        };
    }
    quantities[itemId] = 0;
    updateQuantityDisplay(itemId);
    if (noteInput) noteInput.value = "";

    saveCart();
    updateCartDisplay();
    showMessage(`${itemName} sepete eklendi!`, 'success');

    console.log("Sepet durumu:", cart);
    console.log("Eklenen ürün:", itemName, "Miktar:", quantity, "Not:", itemNote);
}
        function removeFromCart(itemId) {
            delete cart[itemId];
            saveCart();
            updateCartDisplay();
        }
        function updateCartItemQuantity(itemId, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(itemId);
            } else {
                cart[itemId].quantity = newQuantity;
                saveCart();
                updateCartDisplay();
            }
        }
        function updateCartDisplay() {
            const cartCount = document.getElementById('cartCount');
            const cartTotal = document.getElementById('cartTotal');
            const cartContent = document.getElementById('cartContent');
            const emptyCart = document.getElementById('emptyCart');

                  console.log("updateCartDisplay çağrıldı, cart:", cart);
            const itemCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = itemCount;
            const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `₺${totalAmount.toFixed(0)}`;

            console.log("Sepetteki ürün sayısı:", itemCount, "Toplam tutar:", totalAmount);
            if (itemCount === 0) {
                cartContent.innerHTML = 
                    `<div class="empty-cart" id="emptyCart">
                        <p>Sepetiniz boş</p>
                        <p style="font-size: 0.9rem; margin-top: 8px;">Lezzetli ürünlerimizi keşfedin!</p>
                    </div>`;
            } else {
                cartContent.innerHTML = 
                    `<div class="empty-cart" id="emptyCart" style="display: none;">
                        <p>Sepetiniz boş</p>
                        <p style="font-size: 0.9rem; margin-top: 8px;">Lezzetli ürünlerimizi keşfedin!</p>
                    </div>`;
                
                console.log("Sepetteki ürünler:", Object.values(cart));
                
                Object.values(cart).forEach(item => {
    const cartItem = document.createElement('div');
    cartItem.className = 'cart-item';
    cartItem.innerHTML = `
        <div class="cart-item-info">
            <div class="cart-item-name">${item.name}</div>
            <div class="cart-item-price">₺${item.price.toFixed(0)} x ${item.quantity}</div>
            ${item.note ? `<div class="cart-item-note" style="font-size: 0.85rem; color: #ccc; margin-top: 4px;"><em>Not: ${item.note}</em></div>` : ''}
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
        }

        function toggleCart() {
            console.log("toggleCart çağrıldı");
            const cartSidebar = document.getElementById('cartSidebar');
            cartSidebar.classList.toggle('open');
        }
        async function placeOrder() {
            console.log("placeOrder fonksiyonu BAŞLANGIÇ.");
            if (Object.keys(cart).length === 0) {
                showMessage("Sepetiniz boş! Lütfen önce ürün ekleyin.", 'error');
                console.log("Sepet boş, sipariş iptal edildi.");
                return;
            }

            const orderItems = Object.values(cart).map(item => ({
                id: item.id,
                quantity: item.quantity,
                price: item.price,
                special_notes: item.note || ""
            }));
            const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const allNotes = Object.values(cart)
                .filter(item => item.note && item.note.trim() !== "")
                .map(item => `${item.name}: ${item.note}`)
                .join("; ");

            console.log("Gönderilecek sipariş öğeleri:", orderItems);
            console.log("Gönderilecek toplam tutar:", totalAmount);
            console.log("Birleştirilmiş notlar:", allNotes);

            const button = document.getElementById('placeOrderBtn');
            setButtonLoading(button, true);

            try {
                console.log("API çağrısı başlatılıyor: /api/place-order");
                const response = await fetch("/api/place-order", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        order_items: orderItems,
                        total_amount: totalAmount,
                        special_notes: allNotes
                    })
                });

                console.log("API yanıtı alındı, status:", response.status);
                console.log("API yanıtı alındı, ok:", response.ok);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error("HTTP hatası yanıtı:", errorText);
                    throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
                }

                const result = await response.json();
                console.log("Sipariş yanıtı (JSON):", result);

                if (result.status === "success") {
                    showMessage(result.message, 'success');
                    cart = {};
                    quantities = {};
                    saveCart();
                    updateCartDisplay();
                    updateQuantityDisplays();
                    toggleCart();
                } else {
                      showMessage(`Sipariş verilirken bir hata oluştu: ${result.message || 'Bilinmeyen Hata'}`, 'error');
                }
            } catch (error) {
                console.error("Sipariş hatası:", error);
                showMessage("Bağlantı hatası. Lütfen tekrar deneyin.", 'error');
            } finally {
                setButtonLoading(button, false);
            }
        }
        async function callWaiter() {
            const button = document.getElementById('callWaiterBtn');
            setButtonLoading(button, true);

            try {
                const response = await fetch("/api/call-waiter", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({})
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log("Garson çağırma yanıtı:", result);

                if (result.status === "success") {
                    showMessage(result.message, 'success');
                } else {
                    showMessage(result.message || "Garson çağrılırken bir hata oluştu.", 'error');
                }
            } catch (error) {
                console.error("Garson çağırma hatası:", error);
                showMessage("Bağlantı hatası. Lütfen tekrar deneyin.", 'error');
            } finally {
                setButtonLoading(button, false);
            }
        }
        function showMessage(message, type = 'info') {
            const existingMessages = document.querySelectorAll('.message');
            existingMessages.forEach(msg => msg.remove());

            const messageDiv = document.createElement('div');
            messageDiv.className = `message message-${type}`;
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

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.grain-overlay');
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        });
    </script>
</body>
</html>