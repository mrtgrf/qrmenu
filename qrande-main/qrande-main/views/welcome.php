<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant QR System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background-size: 400% 400% !important;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background-size: 400% 400% !important;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .card-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }
        
        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        .feature-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .feature-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-glow:hover::before {
            left: 100%;
        }
        
        .pulse-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .restaurant-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 2px, transparent 2px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="gradient-bg restaurant-pattern min-h-screen">
    <!-- Navigation Bar -->
    <nav class="absolute top-0 left-0 right-0 z-50 p-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-xl">
                <i class="fas fa-utensils mr-2"></i>
                QR Restaurant
            </div>
            <div class="text-white text-sm opacity-80">
                <i class="far fa-clock mr-1"></i>
                7/24 Hizmet
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4 pt-20">
        <div class="container mx-auto max-w-6xl">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <div class="bounce-in mb-8">
                    <div class="inline-block bg-white/20 backdrop-blur-lg rounded-full p-6 mb-6">
                        <i class="fas fa-qrcode text-6xl text-white pulse-icon"></i>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-4">
                        🍽️ Restaurant QR System
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                        Modern restoran yönetim sistemi ile müşterilerinize dijital menü deneyimi sunun.
                        QR kod ile kolay sipariş, masa yönetimi ve daha fazlası!
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="slide-up flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
                    <a href="admin" class="btn-glow group bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-8 py-4 rounded-full font-semibold text-lg shadow-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                        <i class="fas fa-user-shield mr-3 group-hover:rotate-12 transition-transform"></i>
                        👨‍💼 Admin Paneli
                    </a>
                    <a href="admin/tables" class="btn-glow group bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white border-2 border-white/30 hover:border-white/50 px-8 py-4 rounded-full font-semibold text-lg shadow-2xl transform transition-all duration-300 hover:scale-105">
                        <i class="fas fa-mobile-alt mr-3 group-hover:bounce"></i>
                        📱 QR Kodlar
                    </a>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-20">
                <div class="feature-card card-float bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center text-white border border-white/20" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">📱 QR Kod Menü</h3>
                    <p class="text-white/80 leading-relaxed">
                        Müşteriler QR kod ile menüye kolayca erişebilir ve sipariş verebilir
                    </p>
                </div>

                <div class="feature-card card-float bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center text-white border border-white/20" style="animation-delay: 0.4s;">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">🛎️ Garson Çağırma</h3>
                    <p class="text-white/80 leading-relaxed">
                        Tek tıkla garson çağırma sistemi ile hızlı ve etkili hizmet
                    </p>
                </div>

                <div class="feature-card card-float bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center text-white border border-white/20" style="animation-delay: 0.6s;">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">📊 Sipariş Takibi</h3>
                    <p class="text-white/80 leading-relaxed">
                        Gerçek zamanlı sipariş durumu ve mutfak koordinasyonu
                    </p>
                </div>

                <div class="feature-card card-float bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center text-white border border-white/20" style="animation-delay: 0.8s;">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-pie text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">💰 Raporlama</h3>
                    <p class="text-white/80 leading-relaxed">
                        Detaylı satış ve popüler ürün raporları ile analiz
                    </p>
                </div>
            </div>

            <!-- Additional Features -->
            <div class="mt-20 text-center">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
                    <h2 class="text-3xl font-bold text-white mb-6">
                        <i class="fas fa-star text-yellow-400 mr-3"></i>
                        Neden Bizim Sistemimiz?
                    </h2>
                    <div class="grid md:grid-cols-3 gap-6 text-white">
                        <div class="flex items-center justify-center flex-col">
                            <div class="bg-green-500 rounded-full w-12 h-12 flex items-center justify-center mb-3">
                                <i class="fas fa-bolt text-xl"></i>
                            </div>
                            <h4 class="font-semibold mb-2">Hızlı Kurulum</h4>
                            <p class="text-sm text-white/80">5 dakikada kurulum ve kullanıma hazır</p>
                        </div>
                        <div class="flex items-center justify-center flex-col">
                            <div class="bg-blue-500 rounded-full w-12 h-12 flex items-center justify-center mb-3">
                                <i class="fas fa-shield-alt text-xl"></i>
                            </div>
                            <h4 class="font-semibold mb-2">Güvenli</h4>
                            <p class="text-sm text-white/80">SSL sertifikası ile güvenli veri transferi</p>
                        </div>
                        <div class="flex items-center justify-center flex-col">
                            <div class="bg-purple-500 rounded-full w-12 h-12 flex items-center justify-center mb-3">
                                <i class="fas fa-headset text-xl"></i>
                            </div>
                            <h4 class="font-semibold mb-2">7/24 Destek</h4>
                            <p class="text-sm text-white/80">Kesintisiz teknik destek hizmeti</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white/60 pb-8">
        <div class="container mx-auto px-4">
            <p class="text-sm">
                <i class="fas fa-code mr-2"></i>
                Modern Restaurant QR System © 2025
            </p>
        </div>
    </footer>

    <script>
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('slide-up');
                }
            });
        }, observerOptions);
        document.querySelectorAll('.feature-card').forEach(card => {
            observer.observe(card);
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        document.querySelectorAll('a').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.gradient-bg');
            const speed = scrolled * 0.5;
            
            parallax.style.transform = `translateY(${speed}px)`;
        });
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: rippleEffect 0.6s ease-out;
        }

        @keyframes rippleEffect {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .loaded {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</body>
</html>
