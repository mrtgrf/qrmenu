<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garson Çağrıları - Restaurant QR System</title>
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

        /* Notification Banner */
        .notification-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, var(--error-500), var(--error-600));
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            z-index: 1000;
            display: none;
            animation: slideDown 0.5s ease, pulse 2s infinite;
            box-shadow: var(--shadow-lg);
        }
        
        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.8; }
            100% { opacity: 1; }
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
            content: '\f0f3';
            color: var(--primary-600);
            font-size: 1.25rem;
        }

        .page-header p {
            color: var(--gray-600);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            border: 1px solid;
        }

        .alert-info {
            background: var(--primary-50);
            color: var(--primary-800);
            border-color: var(--primary-200);
        }

        .alert-info::before {
            content: '\f05a';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--primary-600);
            font-size: 1.25rem;
        }

        .alert strong {
            font-weight: 600;
        }

        #last-check {
            margin-left: auto;
            font-size: 0.75rem;
            color: var(--primary-600);
            font-weight: 500;
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

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-600), #047857);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
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
            transition: all 0.3s ease;
            position: relative;
        }


        /* Call Status Styles */
        .new-call {
            background: linear-gradient(135deg, var(--warning-50), var(--warning-100)) !important;
            border-left: 4px solid var(--warning-500) !important;
            animation: newCallGlow 2s ease-in-out;
        }

        @keyframes newCallGlow {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0.1); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        
        .pending-call {
            background: linear-gradient(135deg, var(--error-50), var(--error-100)) !important;
            border-left: 4px solid var(--error-500) !important;
        }
        
        .completed-call {
            background: linear-gradient(135deg, var(--success-50), var(--success-100)) !important;
            border-left: 4px solid var(--success-500) !important;
        }

        /* Table ID styling */
        td:first-child {
            font-weight: 600;
            color: var(--gray-900);
            font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
        }

        /* Table number styling */
        td:nth-child(2) {
            font-weight: 700;
            color: var(--primary-600);
            font-size: 1.1rem;
        }

        /* Status styling */
        td:nth-child(4) {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .pending-call td:nth-child(4) {
            color: var(--error-700);
        }

        .completed-call td:nth-child(4) {
            color: var(--success-700);
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

        /* Text muted */
        .text-muted {
            color: var(--gray-500);
            font-style: italic;
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
            
            .alert {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            #last-check {
                margin-left: 0;
            }
            
            .table-container {
                margin: 0 -1rem;
            }
            
            th, td {
                padding: 0.75rem 1rem;
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
    </style>
</head>
<body>
    <div id="notification-banner" class="notification-banner">
        <i class="fas fa-bell"></i>
        YENİ GARSON ÇAĞRISI! Masa <span id="notification-table"></span> garson çağırıyor!
    </div>

    <?php include __DIR__ . "/layout/admin_header.php"; ?>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Garson Çağrıları</h1>
            <p>Müşteri garson çağrılarını takip edin ve yönetin. Yeni çağrılar otomatik olarak bildirilir.</p>
        </div>

        <div class="alert alert-info">
            <strong>Bildirimler Aktif:</strong> Yeni garson çağrıları otomatik olarak bildirilecektir.
            <span id="last-check">Son kontrol: Henüz kontrol edilmedi</span>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-bell"></i>
                    Çağrı Listesi
                </h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table id="calls-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Masa Numarası</th>
                                <th>Çağrı Zamanı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($calls)): ?>
                                <?php foreach ($calls as $call): ?>
                                    <tr class="<?php echo $call['status'] === 'pending' ? 'pending-call' : 'completed-call'; ?>" data-call-id="<?php echo $call['id']; ?>">
                                        <td><?php echo htmlspecialchars($call["id"]); ?></td>
                                        <td><?php echo htmlspecialchars($call["table_number"]); ?></td>
                                        <td><?php echo htmlspecialchars($call["created_at"]); ?></td>
                                        <td><?php echo htmlspecialchars($call["status"]); ?></td>
                                        <td>
                                            <?php if ($call['status'] === 'pending'): ?>
                                                <a href="/admin/calls/complete/<?php echo $call["id"]; ?>" class="btn btn-sm btn-success" onclick="return confirm('Garson çağrısını tamamlamak istediğinizden emin misiniz?');">
                                                    <i class="fas fa-check"></i>
                                                    Tamamla
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-check-circle"></i>
                                                    Tamamlandı
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr id="no-calls-row">
                                    <td colspan="5" class="empty-state">
                                        <i class="fas fa-bell-slash"></i>
                                        <h3>Henüz garson çağrısı bulunmamaktadır</h3>
                                        <p>Müşteriler garson çağırdığında burada görünecektir.</p>
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

    <audio id="notification-sound" preload="auto">
        <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT" type="audio/wav">
    </audio>

    <script>
        let lastCallId = <?php echo !empty($calls) ? max(array_column($calls, 'id')) : 0; ?>;
        let notificationSound = document.getElementById('notification-sound');
        let notificationBanner = document.getElementById('notification-banner');
        let notificationTable = document.getElementById('notification-table');
        let lastCheckElement = document.getElementById('last-check');
        function createNotificationSound() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime + 0.2);
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }
        
        function showNotification(tableNumber) {
            notificationTable.textContent = tableNumber;
            notificationBanner.style.display = 'block';
            try {
                createNotificationSound();
            } catch (e) {
                console.log('Ses çalınamadı:', e);
            }
            setTimeout(() => {
                notificationBanner.style.display = 'none';
            }, 5000);
        }
        
        function updateLastCheck() {
            const now = new Date();
            lastCheckElement.textContent = `Son kontrol: ${now.toLocaleTimeString('tr-TR')}`;
        }
        
        function checkForNewCalls() {
            fetch('/api/waiter-calls/pending')
                .then(response => response.json())
                .then(data => {
                    updateLastCheck();
                    
                  if (data.success && data.calls) {
    let maxId = lastCallId;

    data.calls.forEach(call => {
        if (call.id > lastCallId) {
            showNotification(call.table_number);
            addCallToTable(call);
            if (call.id > maxId) maxId = call.id;
        }
    });

    lastCallId = maxId;
}
                })
                .catch(error => {
                    console.error('Garson çağrıları kontrol edilirken hata:', error);
                });
        }
        
        function addCallToTable(call) {
            const tableBody = document.querySelector('#calls-table tbody');
            const noCallsRow = document.getElementById('no-calls-row');
            
            if (noCallsRow) {
                noCallsRow.remove();
            }
            
            const newRow = document.createElement('tr');
            newRow.className = 'new-call pending-call';
            newRow.setAttribute('data-call-id', call.id);
            newRow.innerHTML = `
                <td>${call.id}</td>
                <td>${call.table_number}</td>
                <td>${call.created_at}</td>
                <td>pending</td>
                <td>
                    <a href="/admin/calls/complete/${call.id}" class="btn btn-sm btn-success" onclick="return confirm('Garson çağrısını tamamlamak istediğinizden emin misiniz?');">
                        <i class="fas fa-check"></i>
                        Tamamla
                    </a>
                </td>
            `;
            tableBody.insertBefore(newRow, tableBody.firstChild);
            setTimeout(() => {
                newRow.classList.remove('new-call');
            }, 3000);
        }
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
                notificationBanner.style.display = 'none';
            }
        });
        setInterval(checkForNewCalls, 5000);
        setTimeout(checkForNewCalls, 1000);
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                checkForNewCalls();
            }
        });
    </script>
</body>
</html>