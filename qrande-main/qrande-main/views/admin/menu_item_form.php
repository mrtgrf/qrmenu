<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($menuItem) ? "Menü Öğesi Düzenle" : "Yeni Menü Öğesi Ekle"; ?> - Restaurant QR System</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . "/layout/admin_header.php"; ?>

    <div class="container">
        <h1><?php echo isset($menuItem) ? "Menü Öğesi Düzenle" : "Yeni Menü Öğesi Ekle"; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="<?php echo isset($menuItem) ? "/admin/menu/edit/" . $menuItem["id"] : "/admin/menu/add"; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Ad:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($menuItem) ? htmlspecialchars($menuItem["name"]) : ""; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Açıklama:</label>
                <textarea id="description" name="description"><?php echo isset($menuItem) ? htmlspecialchars($menuItem["description"]) : ""; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Kategori Seçin</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category["id"]); ?>" <?php echo isset($menuItem) && $menuItem["category_id"] == $category["id"] ? "selected" : ""; ?>><?php echo htmlspecialchars($category["name"]); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Fiyat:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo isset($menuItem) ? htmlspecialchars($menuItem["price"]) : ""; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Ürün Resmi:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if (isset($menuItem) && !empty($menuItem["image_url"])): ?>
                    <div class="current-image" style="margin-top: 10px;">
                        <p>Mevcut resim:</p>
                        <img src="<?php echo htmlspecialchars($menuItem["image_url"]); ?>" alt="<?php echo htmlspecialchars($menuItem["name"]); ?>" style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px;">
                        <p><small>Yeni resim seçerseniz mevcut resim değiştirilecektir.</small></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="display_order">Sıra:</label>
                <input type="number" id="display_order" name="display_order" value="<?php echo isset($menuItem) ? htmlspecialchars($menuItem["display_order"]) : ""; ?>">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" id="is_available" name="is_available" value="1" <?php echo isset($menuItem) && $menuItem["is_available"] ? "checked" : ""; ?>>
                <label for="is_available">Mevcut</label>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="/admin/menu" class="btn btn-secondary">İptal</a>
        </form>
    </div>

    <?php include __DIR__ . "/layout/admin_footer.php"; ?>
</body>
</html>