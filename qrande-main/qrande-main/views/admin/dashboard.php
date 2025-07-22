<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - QRande</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Header Styles */
        .header {
            background: white;
            color: #1f2937;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header .logo-icon {
            width: 48px;
            height: 48px;
            background: #3b82f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .header .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #1f2937;
        }

        .header .logo-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
        }

        .header .user-section {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .header .user-avatar {
            width: 36px;
            height: 36px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
        }

        .header .user-details {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .header .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1f2937;
        }

        .header .user-role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .current-time {
            background: #f9fafb;
            padding: 0.625rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid #e5e7eb;
            min-width: 100px;
            text-align: center;
            color: #1f2937;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            color: #059669;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-indicator::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #059669;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .logout-btn {
            color: #6b7280;
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            background: #f9fafb;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* Stats Grid */
        .stats-section {
            margin-bottom: 3rem;
        }

        .stats-header {
            margin-bottom: 1.5rem;
        }

        .stats-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .stats-header p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #3b82f6;
        }

        .stat-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
            border-color: #3b82f6;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-trend.positive {
            background: #059669;
            color: white;
        }

        .stat-trend.negative {
            background: #dc2626;
            color: white;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
            letter-spacing: -0.05em;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .stat-description {
            color: #9ca3af;
            font-size: 0.75rem;
            line-height: 1.4;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #f59e0b;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
            border: 2px solid white;
            animation: bounce 2s infinite;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
        }

        .quick-actions-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quick-actions-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.5rem;
            background: #f9fafb;
            color: #6b7280;
            text-decoration: none;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #3b82f6;
            background: white;
        }

        .action-btn:hover .action-icon {
            color: #3b82f6;
            transform: scale(1.1);
            background: #eff6ff;
        }

        .action-btn:hover .action-text {
            color: #3b82f6;
        }

        .action-icon {
            width: 64px;
            height: 64px;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .action-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -5px, 0);
            }
            70% {
                transform: translate3d(0, -2px, 0);
            }
            90% {
                transform: translate3d(0, -1px, 0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                padding: 2rem 1.5rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            }
            
            .actions-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .header .user-section {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }
            
            .header .user-info {
                justify-content: center;
            }
            
            .main-content {
                padding: 1.5rem 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .stat-card {
                padding: 1.5rem;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                padding: 1.5rem;
            }
            
            .action-btn {
                padding: 1.5rem;
            }
        }

        /* Focus states for accessibility */
        .action-btn:focus,
        .logout-btn:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Loading state */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <div>
                    <div class="logo-text">QRande</div>
                    <div class="logo-subtitle">QR Management System</div>
                </div>
            </div>
            
            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar"><?= htmlspecialchars(substr($currentUser["full_name"] ?? "A", 0, 1)) ?></div>
                    <div class="user-details">
                        <div class="user-name"><?= htmlspecialchars($currentUser["full_name"] ?? "Admin User") ?></div>
                        <div class="user-role">Sistem Yöneticisi</div>
                    </div>
                </div>
                <div class="current-time" id="currentTime"></div>
                <div class="status-indicator">
                    <span>Online</span>
                </div>
                <a href="<?= url("admin/logout") ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Çıkış</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <div class="stats-section">
            <div class="stats-header">
                <h2>Günlük Özet</h2>
                <p>Bugünün performans göstergeleri ve önemli metrikleri</p>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            +12%
                        </div>
                    </div>
                    <div class="stat-value"><?= $stats["total_orders"] ?? 0 ?></div>
                    <div class="stat-label">Bugünkü Siparişler</div>
                    <div class="stat-description">Dünkü siparişlere kıyasla %12 artış gösterdi</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon">
                            <i class="fas fa-lira-sign"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            +8%
                        </div>
                    </div>
                    <div class="stat-value"><?= formatPrice($stats["total_revenue"] ?? 0.0) ?></div>
                    <div class="stat-label">Bugünkü Gelir</div>
                    <div class="stat-description">Hedeflenen günlük gelirin %95'ine ulaşıldı</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            +5%
                        </div>
                    </div>
                    <div class="stat-value"><?= $stats["active_tables"] ?? 0 ?></div>
                    <div class="stat-label">Aktif Masalar</div>
                    <div class="stat-description">Toplam 25 masadan 18'i aktif kulımda</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?= $stats["pending_calls"] ?? 0 ?></div>
                    <div class="stat-label">Bekleyen Çağrılar</div>
                    <div class="stat-description">Garson çağrıları hemen yanıtlanmalı</div>
                    <?php if (($stats["pending_calls"] ?? 0) > 0): ?>
                        <div class="notification-badge"><?= $stats["pending_calls"] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="quick-actions">
            <div class="quick-actions-header">
                <h2>Hızlı İşlemler</h2>
            </div>
            <div class="actions-grid">
                <a href="<?= url("admin/menu") ?>" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="action-text">Menü Yönetimi</div>
                </a>
                
                <a href="<?= url("admin/tables") ?>" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="action-text">Masa Yönetimi</div>
                </a>
                
                <a href="<?= url("admin/orders") ?>" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="action-text">Sipariş Yönetimi</div>
                </a>
                
                <a href="<?= url("admin/waiter-calls") ?>" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="action-text">Garson Çağrıları</div>
                    <?php if (($stats["pending_calls"] ?? 0) > 0): ?>
                        <div class="notification-badge"><?= $stats["pending_calls"] ?></div>
                    <?php endif; ?>
                </a>
                
                <a href="<?= url("admin/reports") ?>" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="action-text">Raporlar</div>
                </a>
                
              
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('tr-TR', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        
        updateTime();
        setInterval(updateTime, 1000);
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
        document.querySelectorAll('a.action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const originalContent = this.innerHTML;
                this.style.pointerEvents = 'none';
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.pointerEvents = 'auto';
                    this.style.opacity = '1';
                }, 500);
            });
        });
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        document.querySelectorAll('.stat-card, .action-btn').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    </script>
</body>
</html>

