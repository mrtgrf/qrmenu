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
        }

        .floating-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
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
            <button class="category-btn active" onclick="filterByCategory('all')">All</button>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <?php if ($category["is_active"]): ?>
                        <button class="category-btn" onclick="filterByCategory('<?php echo $category["id"]; ?>')">
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
                                <?php if (!empty($menuItems)): ?>
                                    <?php foreach ($menuItems as $item): ?>
                                        <?php if ($item["category_id"] == $category["id"]): ?>
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
                                                    <?php if (rand(0, 1)): ?>
                                                        <span class="tag vegetarian">Doyurucu</span>
                                                    <?php endif; ?>
                                                    <?php if (rand(0, 1)): ?>
                                                        <span class="tag spicy">Baharatlı</span>
                                                    <?php endif; ?>
                                                    <?php if (rand(0, 2) == 0): ?>
                                                        <span class="tag new">Yeni Ürün</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="category-section fade-in">
                    <h2 class="category-title">Menu Coming Soon</h2>
                    <p style="text-align: center; color: #666; font-size: 1.1rem; margin-top: 40px;">
                        Our culinary team is preparing something special for you.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="floating-elements">
        <button class="floating-btn" onclick="scrollToTop()" title="Back to top">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 15l-6-6-6 6"/>
            </svg>
        </button>
    </div>

    <script>
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            document.getElementById('scrollIndicator').style.width = scrollPercent + '%';
        });
        function filterByCategory(categoryId) {
            const sections = document.querySelectorAll('.category-section');
            const buttons = document.querySelectorAll('.category-btn');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
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
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.animationDelay = `${index * 0.1}s`;
                }, index * 50);
            });
        });
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.grain-overlay');
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        });
    </script>
</body>
</html>