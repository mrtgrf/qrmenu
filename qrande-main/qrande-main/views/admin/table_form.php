<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($table) ? 'Masa Düzenle' : 'Masa Ekle'; ?> - Restaurant QR System</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . "/layout/admin_header.php"; ?>

    <div class="container">
        <h1><?php echo isset($table) ? 'Masa Düzenle' : 'Masa Ekle'; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="table_number">Masa Numarası:</label>
                    <input type="text" id="table_number" name="table_number" value="<?php echo isset($table) ? htmlspecialchars($table['table_number']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Kapasite:</label>
                    <input type="number" id="capacity" name="capacity" value="<?php echo isset($table) ? htmlspecialchars($table['capacity']) : '4'; ?>" min="1" max="20" required>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" <?php echo (isset($table) && $table['is_active']) || !isset($table) ? 'checked' : ''; ?>>
                        Aktif
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?php echo isset($table) ? 'Güncelle' : 'Ekle'; ?></button>
                    <a href="/admin/tables" class="btn btn-secondary">İptal</a>
                </div>
            </form>
        </div>
    </div>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>
</body>
</html>