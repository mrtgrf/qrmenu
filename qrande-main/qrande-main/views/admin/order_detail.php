<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Detayı - Restaurant QR System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --success-50: #ecfdf5;
            --success-100: #d1fae5;
            --success-500: #10b981;
            --success-600: #059669;
            --success-700: #047857;
            
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            
            --error-50: #fef2f2;
            --error-100: #fee2e2;
            --error-500: #ef4444;
            --error-600: #dc2626;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--primary-50) 100%);
            min-height: 100vh;
            color: var(--gray-900);
            line-height: 1.6;
            font-size: 14px;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 2rem;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-500), var(--primary-600), var(--primary-700));
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-header h1::before {
            content: '';
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-100), var(--primary-200));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            content: '\f570';
            color: var(--primary-600);
            font-size: 1.25rem;
        }

        .page-header p {
            color: var(--gray-600);
            font-size: 1rem;
        }

        .page-header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .status-pending {
            background: var(--warning-100);
            color: var(--warning-600);
            border: 1px solid var(--warning-200);
        }

        .status-completed {
            background: var(--success-100);
            color: var(--success-600);
            border: 1px solid var(--success-200);
        }

        .status-cancelled {
            background: var(--error-100);
            color: var(--error-600);
            border: 1px solid var(--error-200);
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--gray-50);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header h2::before {
            content: '';
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-100), var(--primary-200));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--primary-600);
            font-size: 0.875rem;
        }

        .card-header h2.order-info::before {
            content: '\f05a';
        }

        .card-header h2.order-items::before {
            content: '\f0ca';
        }

        .card-body {
            padding: 2rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: var(--primary-50);
            border-color: var(--primary-200);
        }

        .info-item-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .info-item-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .info-item-value.highlight {
            color: var(--primary-600);
            font-size: 1.25rem;
        }

        .info-item-value.amount {
            color: var(--success-600);
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Special Notes */
        .special-notes {
            background: linear-gradient(135deg, var(--warning-50), var(--warning-100));
            border: 2px solid var(--warning-200);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin: 1.5rem 0;
            position: relative;
        }

        .special-notes::before {
            content: '\f06a';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: -12px;
            left: 1.5rem;
            background: var(--warning-100);
            color: var(--warning-600);
            padding: 0.5rem;
            border-radius: 50%;
            font-size: 1rem;
            border: 2px solid var(--warning-200);
        }

        .special-notes-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--warning-700);
            margin-bottom: 0.5rem;
            margin-left: 1rem;
        }

        .special-notes-content {
            font-size: 1rem;
            font-weight: 600;
            color: var(--warning-800);
            margin-left: 1rem;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead {
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
        }

        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 2px solid var(--gray-200);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-700);
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.3s ease;
            position: relative;
        }

        tbody tr:hover {
            background: var(--primary-50);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Product name styling */
        td:first-child {
            font-weight: 600;
            color: var(--gray-900);
        }

        /* Quantity styling */
        td:nth-child(2) {
            font-weight: 700;
            color: var(--primary-600);
            text-align: center;
        }

        /* Price styling */
        td:nth-child(3), td:nth-child(4) {
            font-weight: 600;
            color: var(--success-600);
            text-align: right;
            font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-500);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-400);
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--gray-700);
        }

        .empty-state p {
            font-size: 0.875rem;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--gray-600), var(--gray-700));
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-600), var(--success-700));
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 0 1.5rem 2rem;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .page-header h1 {
                font-size: 1.75rem;
            }
            
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem 1rem;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .page-header h1 {
                font-size: 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .page-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .card-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                margin: 0 -1.5rem;
            }
            
            th, td {
                padding: 0.75rem 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
        }

        /* Loading state */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-200);
            border-top: 4px solid var(--primary-500);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Focus states for accessibility */
        .btn:focus,
        a:focus {
            outline: 2px solid var(--primary-500);
            outline-offset: 2px;
        }

        /* Ripple effect */
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

        /* Animation for cards */
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

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        .card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .card:nth-child(3) {
            animation-delay: 0.2s;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . "/layout/admin_header.php"; ?>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div>
                    <h1>Sipariş Detayı</h1>
                    <p>Sipariş bilgilerini görüntüleyin ve yönetin. Tüm detaylar aşağıda listelenmiştir.</p>
                </div>
                <div class="status-badge <?php 
                    echo $order["status"] === 'completed' ? 'status-completed' : 
                        ($order["status"] === 'cancelled' ? 'status-cancelled' : 'status-pending'); 
                ?>">
                    <i class="fas <?php 
                        echo $order["status"] === 'completed' ? 'fa-check-circle' : 
                            ($order["status"] === 'cancelled' ? 'fa-times-circle' : 'fa-clock'); 
                    ?>"></i>
                    <?php echo htmlspecialchars($order["status"]); ?>
                </div>
            </div>
        </div>

        <!-- Order Information Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="order-info">Sipariş Bilgileri</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-item-label">Sipariş ID</div>
                        <div class="info-item-value"><?php echo htmlspecialchars($order["id"]); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Sipariş No</div>
                        <div class="info-item-value highlight"><?php echo htmlspecialchars($order["order_number"]); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Masa No</div>
                        <div class="info-item-value highlight"><?php echo htmlspecialchars($order["table_number"]); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Durum</div>
                        <div class="info-item-value"><?php echo htmlspecialchars($order["status"]); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Toplam Tutar</div>
                        <div class="info-item-value amount"><?php echo htmlspecialchars(number_format($order["total_amount"], 2)); ?> TL</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-label">Sipariş Tarihi</div>
                        <div class="info-item-value"><?php echo htmlspecialchars($order["created_at"]); ?></div>
                    </div>
                </div>

                <!-- Special Notes -->
                <?php if (!empty($order["special_notes"])): ?>
                <div class="special-notes">
                    <div class="special-notes-label">Özel Notlar:</div>
                    <div class="special-notes-content">
                        <?php echo htmlspecialchars($order["special_notes"]); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Completion Date -->
                <?php if (isset($order["completed_at"]) && $order["completed_at"]): ?>
                <div class="info-grid" style="margin-top: 1.5rem;">
                    <div class="info-item">
                        <div class="info-item-label">Tamamlanma Tarihi</div>
                        <div class="info-item-value"><?php echo htmlspecialchars($order["completed_at"]); ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Items Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="order-items">Sipariş Öğeleri</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Adet</th>
                                <th>Birim Fiyat</th>
                                <th>Toplam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orderItems)): ?>
                                <?php foreach ($orderItems as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item["menu_item_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($item["quantity"]); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($item["unit_price"], 2)); ?> TL</td>
                                        <td><?php echo htmlspecialchars(number_format($item["unit_price"] * $item["quantity"], 2)); ?> TL</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-shopping-cart"></i>
                                        <h3>Sipariş öğesi bulunamadı</h3>
                                        <p>Bu siparişe ait herhangi bir ürün bulunmamaktadır.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="/admin/orders" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Geri Dön
            </a>
            <?php if ($order["status"] !== "completed"): ?>
                <a href="/admin/orders/complete/<?php echo $order["id"]; ?>" class="btn btn-success" onclick="return confirm('Siparişi tamamlamak istediğinizden emin misiniz?');">
                    <i class="fas fa-check"></i>
                    Siparişi Tamamla
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>

    <script>
        document.querySelectorAll('.btn-success').forEach(button => {
            button.addEventListener('click', function(e) {
                setTimeout(() => {
                    document.getElementById('loadingOverlay').classList.add('show');
                }, 100);
            });
        });
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    pointer-events: none;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    transform: scale(0);
                    animation: rippleEffect 0.6s ease-out;
                    z-index: 1;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('loadingOverlay').classList.remove('show');
            }
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        document.querySelectorAll('.info-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = 'var(--shadow-md)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>

