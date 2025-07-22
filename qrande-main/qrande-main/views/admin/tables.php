<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masa Yönetimi - QRande</title>
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
            background: linear-gradient(135deg, #f9fafb 0%, #eff6ff 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Modern Navbar */
        .navbar {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            text-decoration: none;
        }

        .navbar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .nav-link i {
            width: 16px;
            text-align: center;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-name {
            color: #d1d5db;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1f2937;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .mobile-menu.show {
            display: block;
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0 2rem;
        }

        .mobile-nav .nav-link {
            padding: 1rem;
            border-radius: 8px;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Page Title Section */
        .page-title-section {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .page-title-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 1.75rem;
        }

        .page-description {
            color: #6b7280;
            font-size: 1.125rem;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
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
            height: 3px;
            background: var(--accent-color, #3b82f6);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-card.primary { --accent-color: #3b82f6; }
        .stat-card.success { --accent-color: #10b981; }
        .stat-card.warning { --accent-color: #f59e0b; }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .stat-card.primary .stat-icon {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-card.success .stat-icon {
            background: #ecfdf5;
            color: #10b981;
        }

        .stat-card.warning .stat-icon {
            background: #fffbeb;
            color: #f59e0b;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.75rem;
            color: #10b981;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        /* Data Table Container */
        .data-table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-actions {
            display: flex;
            gap: 0.75rem;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            width: 250px;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        /* Modern Table */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.2s ease;
            position: relative;
        }

     

        /* Table Cell Styling */
        .table-id {
            font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
            font-weight: 600;
            color: #6b7280;
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        .table-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 1rem;
        }

        .table-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #3b82f6;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid #bfdbfe;
        }

        .table-link:hover {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }

        .table-actions-cell {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-sm {
            padding: 0.5rem 0.875rem;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #9ca3af;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .empty-state p {
            margin-bottom: 2rem;
            color: #6b7280;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .navbar-nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 2rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .page-title-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
            
            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .search-input {
                width: 100%;
            }
            
            .table-actions-cell {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .btn-sm {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <?php include 'layout/admin_header.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Page Title Section -->
            <div class="page-title-section animate-fade-in">
                <div class="page-title">
                    <div class="page-title-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    Masa Yönetimi
                </div>
                <p class="page-description">
                    Restoran masalarınızı profesyonel bir şekilde yönetin. Yeni masalar ekleyin, mevcut masaları düzenleyin ve masa durumlarını takip edin.
                </p>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="stat-label">Toplam Masa</div>
                        </div>
                        <div class="stat-value">12</div>
                        <div class="stat-change">+2 bu ay</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-label">Aktif Masalar</div>
                        </div>
                        <div class="stat-value">8</div>
                        <div class="stat-change">%67 doluluk</div>
                    </div>
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-label">Bekleyen</div>
                        </div>
                        <div class="stat-value">4</div>
                        <div class="stat-change">Müsait masalar</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="/admin/tables/add" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Yeni Masa Ekle
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <i class="fas fa-download"></i>
                        Rapor İndir
                    </a>
                </div>
            </div>

            <!-- Data Table -->
            <div class="data-table-container animate-fade-in">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-list"></i>
                        Masa Listesi
                    </div>
                    <div class="table-actions">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" placeholder="Masa ara...">
                        </div>
                    </div>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Masa Numarası</th>
                                <th>Masa Linki</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tables)): ?>
                                <?php foreach ($tables as $table): ?>
                                    <tr>
                                        <td>
                                            <span class="table-id">#<?php echo htmlspecialchars($table["id"]); ?></span>
                                        </td>
                                        <td>
                                            <span class="table-name"><?php echo htmlspecialchars($table["table_number"]); ?></span>
                                        </td>
                                        <td>
                                            <a href="/table/<?php echo $table["id"]; ?>?license=<?php echo $this->currentLicense["license_key"]; ?>" 
                                               target="_blank" class="table-link">
                                                <i class="fas fa-external-link-alt"></i>
                                                Masayı Görüntüle
                                            </a>
                                        </td>
                                        <td>
                                            <div class="table-actions-cell">
                                                <a href="/admin/tables/edit/<?php echo $table["id"]; ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                    Düzenle
                                                </a>
                                                <a href="/admin/tables/delete/<?php echo $table["id"]; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Emin misiniz?');">
                                                    <i class="fas fa-trash"></i>
                                                    Sil
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-table"></i>
                                        </div>
                                        <h3>Henüz masa bulunmamaktadır</h3>
                                        <p>Restoranınız için ilk masayı ekleyerek başlayın.</p>
                                        <a href="/admin/tables/add" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            İlk Masayı Ekle
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!mobileMenu.contains(e.target) && !toggle.contains(e.target)) {
                mobileMenu.classList.remove('show');
            }
        });
        document.querySelectorAll('a[href*="/admin/tables/"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href.includes('/delete/')) {
                    return;
                }
            });
        });
        document.querySelectorAll('a[href*="/delete/"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const tableNumber = this.closest('tr').querySelector('.table-name').textContent;
                const confirmMessage = `"${tableNumber}" masasını silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz ve masa ile ilgili tüm veriler silinecektir.`;
                
                if (confirm(confirmMessage)) {
                    window.location.href = this.href;
                }
            });
        });
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const tableName = row.querySelector('.table-name')?.textContent.toLowerCase() || '';
                const tableId = row.querySelector('.table-id')?.textContent.toLowerCase() || '';
                
                if (tableName.includes(searchTerm) || tableId.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
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
        document.querySelectorAll('tbody tr').forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            row.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(row);
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('mobileMenu').classList.remove('show');
            }
            
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                document.querySelector('.search-input').focus();
            }
        });
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                document.getElementById('mobileMenu').classList.remove('show');
            }
        });
    </script>
</body>
</html>

