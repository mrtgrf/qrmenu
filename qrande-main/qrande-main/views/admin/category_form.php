<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($category) ? "Kategori Düzenle" : "Yeni Kategori Ekle"; ?> - Restaurant QR System</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . "/layout/admin_header.php"; ?>

    <div class="container">
        <h1><?php echo isset($category) ? "Kategori Düzenle" : "Yeni Kategori Ekle"; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="<?php echo isset($category) ? "/admin/categories/edit/" . $category["id"] : "/admin/categories/add"; ?>" method="POST">
            <div class="form-group">
                <label for="name">Kategori Adı:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($category) ? htmlspecialchars($category["name"]) : ""; ?>" required>
            </div>
            <div class="form-group">
                <label for="display_order">Sıra:</label>
                <input type="number" id="display_order" name="display_order" value="<?php echo isset($category) ? htmlspecialchars($category["display_order"]) : ""; ?>">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo isset($category) && $category["is_active"] ? "checked" : ""; ?>>
                <label for="is_active">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="/admin/menu" class="btn btn-secondary">İptal</a>
        </form>
    </div>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>
</body>
</html>