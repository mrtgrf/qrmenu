<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRande Admin Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Genel Stil Ayarları */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f9fafb 0%, #eff6ff 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Header Navbar Düzenlemeleri */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        header .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .logo {
            flex-shrink: 0;
            z-index: 1001;
        }

        .logo a {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4a5568;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo a::before {
            content: "\f2e7";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #667eea;
        }

        /* Desktop Navigation */
        nav {
            flex: 1;
            display: flex;
            justify-content: center;
            margin: 0 2rem;
        }

        nav ul {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        nav ul li a {
            color: #718096;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        nav ul li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s;
        }

        nav ul li a:hover::before {
            left: 100%;
        }

        nav ul li a:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        nav ul li a i {
            font-size: 0.9rem;
            width: 18px;
            text-align: center;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .mobile-menu-toggle:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: #667eea;
            margin: 3px 0;
            transition: 0.3s;
            border-radius: 3px;
        }

        /* Mobile Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding-top: 80px;
            overflow-y: auto;
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav ul {
            flex-direction: column;
            padding: 2rem;
            gap: 1rem;
            max-width: 400px;
            margin: 0 auto;
        }

        .mobile-nav ul li a {
            padding: 1rem 1.5rem;
            justify-content: flex-start;
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .mobile-nav ul li a:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(5px);
        }

        .mobile-nav ul li a i {
            width: 24px;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            nav ul li a {
                padding: 0.6rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 1024px) {
            header .container {
                padding: 0 1rem;
            }
            
            nav {
                margin: 0 1rem;
            }
            
            nav ul {
                gap: 0.25rem;
            }
            
            nav ul li a {
                padding: 0.5rem 0.7rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }
            
            nav {
                display: none;
            }
            
            .mobile-menu-toggle.active span:nth-child(1) {
                transform: rotate(-45deg) translate(-5px, 6px);
            }
            
            .mobile-menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            
            .mobile-menu-toggle.active span:nth-child(3) {
                transform: rotate(45deg) translate(-5px, -6px);
            }
        }

        /* Ana içerik için padding */
        main {
            padding-top: 1rem;
        }

        /* Overlay for mobile menu */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-menu-overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="/admin">QRande</a>
            </div>
            
            <nav>
                <ul>
                    <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="/admin/menu"><i class="fas fa-utensils"></i> Menü Yönetimi</a></li>
                    <li><a href="/admin/tables"><i class="fas fa-chair"></i> Masa Yönetimi</a></li>
                    <li><a href="/admin/orders"><i class="fas fa-clipboard-list"></i> Sipariş Yönetimi</a></li>
                    <li><a href="/admin/waiter-calls"><i class="fas fa-bell"></i> Garson Çağrıları</a></li>
                    <li><a href="/admin/reports"><i class="fas fa-chart-line"></i> Raporlar</a></li>
                    <li><a href="/admin/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
                </ul>
            </nav>
            
            <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <div class="mobile-nav" id="mobileNav">
            <ul>
                <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="/admin/menu"><i class="fas fa-utensils"></i> Menü Yönetimi</a></li>
                <li><a href="/admin/tables"><i class="fas fa-chair"></i> Masa Yönetimi</a></li>
                <li><a href="/admin/orders"><i class="fas fa-clipboard-list"></i> Sipariş Yönetimi</a></li>
                <li><a href="/admin/waiter-calls"><i class="fas fa-bell"></i> Garson Çağrıları</a></li>
                <li><a href="/admin/reports"><i class="fas fa-chart-line"></i> Raporlar</a></li>
                <li><a href="/admin/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
            </ul>
        </div>
    </header>

    <script>
        function toggleMobileMenu() {
            const mobileNav = document.getElementById("mobileNav");
            const toggle = document.querySelector(".mobile-menu-toggle");
            
            mobileNav.classList.toggle("active");
            toggle.classList.toggle("active");
        }
        document.addEventListener("click", function(event) {
            const mobileNav = document.getElementById("mobileNav");
            const toggle = document.querySelector(".mobile-menu-toggle");
            
            if (!mobileNav.contains(event.target) && !toggle.contains(event.target)) {
                mobileNav.classList.remove("active");
                toggle.classList.remove("active");
            }
        });
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                const mobileNav = document.getElementById("mobileNav");
                const toggle = document.querySelector(".mobile-menu-toggle");
                
                mobileNav.classList.remove("active");
                toggle.classList.remove("active");
            }
        });
    </script>
</body>
</html>
