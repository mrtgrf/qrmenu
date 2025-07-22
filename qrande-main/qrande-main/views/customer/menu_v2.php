<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RİSEPUB MENU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .grain-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="0.5" fill="%23ffffff" opacity="0.02"/><circle cx="80" cy="40" r="0.3" fill="%23ffffff" opacity="0.03"/><circle cx="40" cy="80" r="0.4" fill="%23ffffff" opacity="0.02"/><circle cx="60" cy="10" r="0.2" fill="%23ffffff" opacity="0.03"/><circle cx="10" cy="60" r="0.3" fill="%23ffffff" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            pointer-events: none;
            z-index: -1;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            text-align: center;
            padding: 80px 0 60px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 60px;
        }

        .header h1 {
            font-size: 3.5rem;
            font-weight: 300;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.1rem;
            color: #888;
            font-weight: 400;
            letter-spacing: 0.02em;
        }

        .category-nav {
            display: flex;
            justify-content: center;
            gap: 0;
            margin-bottom: 80px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 8px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .category-btn {
            padding: 16px 32px;
            background: transparent;
            border: none;
            color: #888;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
            font-size: 0.95rem;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
        }

        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-btn:hover::before {
            opacity: 1;
        }

        .category-btn.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 60px;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 18px 24px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 400;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
        }

        .search-input::placeholder {
            color: #666;
        }

        .search-input:focus {
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .category-section {
            margin-bottom: 80px;
        }

        .category-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 40px;
            text-align: center;
            letter-spacing: -0.01em;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 32px;
        }

        .menu-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.02);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .menu-item:hover::before {
            opacity: 1;
        }

        .menu-item:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .menu-item-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .menu-item-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            margin-left: 20px;
        }

        .menu-item-description {
            color: #aaa;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .menu-item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .tag {
            background: rgba(255, 255, 255, 0.1);
            color: #ccc;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.1);
            letter-spacing: 0.01em;
        }

        .tag.vegetarian {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            border-color: rgba(46, 204, 113, 0.3);
        }

        .tag.spicy {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border-color: rgba(231, 76, 60, 0.3);
        }

        .tag.new {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
            border-color: rgba(241, 196, 15, 0.3);
        }

        .menu-item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
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
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-display {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
            min-width: 30px;
            text-align: center;
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .add-to-cart-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .unavailable {
            opacity: 0.4;
            position: relative;
        }

        .unavailable::after {
            content: 'Geçici olarak mevcut değil';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(20, 20, 20, 0.95);
            color: #e74c3c;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .floating-elements {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: #ffffff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .floating-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .cart-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 64px;
            height: 64px;
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
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .place-order-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .call-waiter-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .call-waiter-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .empty-cart {
            text-align: center;
            color: #888;
            padding: 40px 0;
        }

        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffffff 0%, #666666 100%);
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .message {
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
        }

        .message-success {
            background: rgba(46, 204, 113, 0.9);
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .message-error {
            background: rgba(231, 76, 60, 0.9);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .message-info {
            background: rgba(52, 152, 219, 0.9);
            border: 1px solid rgba(52, 152, 219, 0.3);
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

        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .header {
                padding: 60px 0 40px;
                margin-bottom: 40px;
            }

            .header h1 {
                font-size: 2.5rem;
            }

            .category-nav {
                flex-direction: column;
                gap: 8px;
                margin-bottom: 40px;
            }

            .category-btn {
                width: 100%;
                text-align: center;
            }

            .menu-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .menu-item {
                padding: 24px;
            }

            .menu-item-header {
                flex-direction: column;
                gap: 8px;
            }

            .menu-item-price {
                margin-left: 0;
                align-self: flex-end;
            }

            .floating-elements {
                bottom: 20px;
                right: 20px;
            }

            .cart-sidebar {
                width: 100vw;
                right: -100vw;
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="grain-overlay"></div>
    <div class="scroll-indicator" id="scrollIndicator"></div>
    
    <div class="container">
        <div class="header fade-in">
            <h1>RISE PUB</h1>
            <p>MERT GURUF</p>
        </div>

        <div class="search-container fade-in">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Ürün ara..." id="searchInput">
            </div>
        </div>

        <div class="category-nav fade-in" id="categoryNav">
            <button class="category-btn active" onclick="filterByCategory('all', this)">Tümü</button>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <?php if ($category["is_active"]): ?>
                        <button class="category-btn" onclick="filterByCategory('<?php echo $category["id"]; ?>', this)">
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
            <span class="cart-count" id="cartCount" style="display: none;">0</span>
        </button>
        <button class="floating-btn" onclick="scrollToTop()" title="Yukarı">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 15l-6-6-6 6"/>
            </svg>
        </button>
    </div>

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
        let cart = JSON.parse(localStorage.getItem("qr_menu_cart")) || {};
        let quantities = {};
        document.addEventListener("DOMContentLoaded", function() {
            updateCartDisplay();
            updateQuantityDisplays();
            const elements = document.querySelectorAll(".fade-in");
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.animationDelay = `${index * 0.1}s`;
                }, index * 50);
            });
        });
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            document.getElementById('scrollIndicator').style.width = scrollPercent + '%';
        });
        function filterByCategory(categoryId, clickedButton) {
            const sections = document.querySelectorAll('.category-section');
            const buttons = document.querySelectorAll('.category-btn');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            clickedButton.classList.add('active');
            
            sections.forEach(section => {
                if (categoryId === 'all' || section.dataset.category === categoryId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                const name = item.dataset.name;
                const description = item.dataset.description;
                
                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        function increaseQuantity(itemId) {
            quantities[itemId] = (quantities[itemId] || 0) + 1;
            updateQuantityDisplay(itemId);
        }

        function decreaseQuantity(itemId) {
            if (quantities[itemId] > 0) {
                quantities[itemId]--;
                updateQuantityDisplay(itemId);
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
            const quantity = quantities[itemId] || 0;
            if (quantity === 0) {
                showMessage("Lütfen önce miktar seçin!", 'error');
                return;
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
            updateCartDisplay();
            showMessage(`${itemName} sepete eklendi!`, 'success');
        }

        function removeFromCart(itemId) {
            if (cart[itemId]) {
                const itemName = cart[itemId].name;
                delete cart[itemId];
                saveCart();
                updateCartDisplay();
                showMessage(`${itemName} sepetten kaldırıldı!`, 'info');
            }
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

        function saveCart() {
            localStorage.setItem("qr_menu_cart", JSON.stringify(cart));
        }

        function updateCartDisplay() {
            const cartContent = document.getElementById('cartContent');
            const emptyCart = document.getElementById('emptyCart');
            const cartCount = document.getElementById('cartCount');
            const cartTotal = document.getElementById('cartTotal');
            
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
                emptyCart.style.display = 'block';
                cartContent.innerHTML = '<div class="empty-cart" id="emptyCart"><p>Sepetiniz boş</p><p style="font-size: 0.9rem; margin-top: 8px;">Lezzetli ürünlerimizi keşfedin!</p></div>';
            } else {
                emptyCart.style.display = 'none';
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
        }

        function toggleCart() {
            const cartSidebar = document.getElementById('cartSidebar');
            cartSidebar.classList.toggle('open');
        }
        async function placeOrder() {
            if (Object.keys(cart).length === 0) {
                showMessage("Sepetiniz boş! Lütfen önce ürün ekleyin.", 'error');
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
                    updateCartDisplay();
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
