<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Kod - Masa <?php echo htmlspecialchars($table['table_number']); ?> - Restaurant QR System</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
</head>
<body>
    <?php include __DIR__ . "/layout/admin_header.php"; ?>

    <div class="container">
        <h1>QR Kod - Masa <?php echo htmlspecialchars($table['table_number']); ?></h1>

        <div class="card text-center">
            <h2>Masa <?php echo htmlspecialchars($table['table_number']); ?> QR Kodu</h2>
            <div id="qrcode" style="margin: 20px auto;"></div>
            <p><strong>URL:</strong> <?php echo htmlspecialchars($qrUrl); ?></p>
            <div class="mt-4">
                <button onclick="printQR()" class="btn btn-primary">Yazdır</button>
                <button onclick="downloadQR()" class="btn btn-secondary">İndir</button>
                <a href="/admin/tables" class="btn btn-secondary">Geri Dön</a>
            </div>
        </div>
    </div>

    <script>
        const qrUrl = "<?php echo htmlspecialchars($qrUrl); ?>";
        const tableNumber = "<?php echo htmlspecialchars($table['table_number']); ?>";
        QRCode.toCanvas(document.getElementById('qrcode'), qrUrl, {
            width: 256,
            height: 256,
            margin: 2
        }, function (error) {
            if (error) console.error(error);
            console.log('QR kod oluşturuldu!');
        });

        function printQR() {
            const printWindow = window.open('', '_blank');
            const canvas = document.querySelector('#qrcode canvas');
            const dataURL = canvas.toDataURL();
            
            printWindow.document.write(`
                <html>
                <head>
                    <title>QR Kod - Masa ${tableNumber}</title>
                    <style>
                        body { text-align: center; font-family: Arial, sans-serif; }
                        h1 { margin-bottom: 20px; }
                        img { margin: 20px 0; }
                    </style>
                </head>
                <body>
                    <h1>Masa ${tableNumber}</h1>
                    <img src="${dataURL}" alt="QR Kod">
                    <p>Menüyü görüntülemek için QR kodu okutun</p>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function downloadQR() {
            const canvas = document.querySelector('#qrcode canvas');
            const link = document.createElement('a');
            link.download = `masa-${tableNumber}-qr.png`;
            link.href = canvas.toDataURL();
            link.click();
        }
    </script>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>
</body>
</html>

