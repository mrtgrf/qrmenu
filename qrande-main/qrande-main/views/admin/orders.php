<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Yönetimi - Restaurant QR System</title>
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
            
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            
            --error-50: #fef2f2;
            --error-100: #fee2e2;
            --error-500: #ef4444;
            --error-600: #dc2626;

            --info-50: #eff6ff;
            --info-100: #dbeafe;
            --info-500: #3b82f6;
            --info-600: #2563eb;
            
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

        /* Header Styles - Placeholder for admin_header.php */
        .admin-header {
            background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-600) 50%, var(--primary-700) 100%);
            color: white;
            padding: 1.5rem 0;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .admin-header .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
            content: '\f4c0';
            color: var(--primary-600);
            font-size: 1.25rem;
        }

        .page-header p {
            color: var(--gray-600);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .page-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            overflow: hidden;
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
            gap: 0.5rem;
        }

        .card-body {
            padding: 0;
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

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-500), var(--warning-600));
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-600), #b45309);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--error-500), var(--error-600));
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--error-600), #b91c1c);
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-600), #047857);
            transform: translateY(-1px);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-500), var(--info-600));
            color: white;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, var(--info-600), var(--primary-700));
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead {
            background: var(--gray-50);
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
            transition: all 0.2s ease;
            position: relative;
        }

     
        /* Table ID styling */
        td:first-child {
            font-weight: 600;
            color: var(--gray-900);
            font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
        }

        /* Table number styling */
        td:nth-child(2) {
            font-weight: 600;
            color: var(--primary-600);
            font-size: 1rem;
        }

        /* Total amount styling */
        td:nth-child(3) {
            font-weight: 600;
            color: var(--success-600);
            font-size: 1rem;
        }

        /* Status styling */
        td:nth-child(4) {
            font-weight: 500;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background: var(--warning-100);
            color: var(--warning-600);
        }

        .status-preparing {
            background: var(--info-100);
            color: var(--info-600);
        }

        .status-completed {
            background: var(--success-100);
            color: var(--success-600);
        }

        .status-cancelled {
            background: var(--error-100);
            color: var(--error-600);
        }

        /* Actions column */
        td:last-child {
            display: flex;
            gap: 0.5rem;
            align-items: center;
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
            margin-bottom: 1.5rem;
        }

        /* Stats bar */
        .stats-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: var(--gray-50);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .stat-item i {
            color: var(--primary-500);
        }

        .stat-value {
            font-weight: 600;
            color: var(--gray-900);
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
            
            .stats-bar {
                flex-wrap: wrap;
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
            
            .page-header-actions {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }
            
            .btn {
                justify-content: center;
                width: 100%;
            }
            
            .stats-bar {
                flex-direction: column;
            }
            
            .table-container {
                margin: 0 -1rem;
            }
            
            th, td {
                padding: 0.75rem 1rem;
            }
            
            td:last-child {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .btn-sm {
                width: 100%;
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

        /* Table row selection */
        tbody tr:focus-within {
            background: var(--primary-50);
            outline: 2px solid var(--primary-200);
            outline-offset: -2px;
        }

        /* Tooltip for actions */
        .tooltip {
            position: relative;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-800);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
        }

        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-0.25rem);
        }
    </style>
</head>
<body>
    <!-- Admin Header Include -->
    <?php include __DIR__ . "/layout/admin_header.php"; ?>
    
    <!-- Admin Header Fallback -->
 
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Sipariş Yönetimi</h1>
            <p>Müşteri siparişlerini yönetin, siparişleri görüntüleyin ve durumlarını güncelleyin.</p>
            
         
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-list"></i>
                    Sipariş Listesi
                </h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sipariş ID</th>
                                <th>Masa No</th>
                                <th>Toplam Tutar</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>Not</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order["id"]); ?></td>
                                        <td><?php echo htmlspecialchars($order["table_number"]); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($order["total_amount"], 2)); ?> TL</td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order["status"])); ?>">
                                                <?php echo htmlspecialchars($order["status"]); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($order["created_at"]); ?></td>
                                        <td>
                                            <?php if (!empty($order["special_notes"])): ?>
                                                <span class="tooltip" data-tooltip="<?php echo htmlspecialchars($order["special_notes"]); ?>">
                                                    <i class="fas fa-sticky-note" style="color: #f59e0b;"></i>
                                                </span>
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/admin/orders/view/<?php echo $order["id"]; ?>" 
                                               class="btn btn-sm btn-info tooltip" 
                                               data-tooltip="Sipariş Detayları">
                                                <i class="fas fa-eye"></i>
                                                Görüntüle
                                            </a>
                                            <a href="/admin/orders/complete/<?php echo $order["id"]; ?>" 
                                               class="btn btn-sm btn-success tooltip" 
                                               data-tooltip="Siparişi Tamamla">
                                                <i class="fas fa-check"></i>
                                                Tamamla
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <i class="fas fa-receipt"></i>
                                        <h3>Henüz sipariş bulunmamaktadır</h3>
                                        <p>Müşteriler sipariş vermeye başladığında burada görüntülenecektir.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>

    <script>
        document.querySelectorAll('a[href*="/admin/orders/"]').forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    document.getElementById('loadingOverlay').classList.add('show');
                }, 100);
            });
        });
        document.querySelectorAll('a[href*="/complete/"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const orderId = this.closest('tr').querySelector('td:first-child').textContent;
                const tableNumber = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                const confirmMessage = `Sipariş #${orderId} (Masa ${tableNumber}) tamamlandı olarak işaretlensin mi?`;
                
                if (confirm(confirmMessage)) {
                    document.getElementById('loadingOverlay').classList.add('show');
                    window.location.href = this.href;
                }
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
        const style = document.createElement('style');
        style.textContent = `
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
        `;
        document.head.appendChild(style);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('loadingOverlay').classList.remove('show');
            }
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            row.style.transition = 'all 0.3s ease';
            observer.observe(row);
        });
        setInterval(() => {
            if (!document.getElementById('loadingOverlay').classList.contains('show')) {
                location.reload();
            }
        }, 30000);
    </script>
</body>
</html>