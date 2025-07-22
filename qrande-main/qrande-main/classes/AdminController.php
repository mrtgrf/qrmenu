<?php

class AdminController extends Controller {
    
    public function dashboard() {
        $this->requireAuth();
        $this->requireLicense();
        $stats = [
            'total_orders' => $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM orders WHERE license_id = ? AND DATE(created_at) = CURDATE()",
                [$this->currentLicense['id']]
            )['count'],
            'total_revenue' => $this->db->fetchOne(
                "SELECT SUM(total_amount) as total FROM orders WHERE license_id = ? AND DATE(created_at) = CURDATE() AND payment_status = 'paid'",
                [$this->currentLicense['id']]
            )['total'] ?? 0,
            'active_tables' => $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM tables WHERE license_id = ? AND status = 'occupied'",
                [$this->currentLicense['id']]
            )['count'],
            'pending_calls' => $this->db->fetchOne(
                "SELECT COUNT(*) as count FROM waiter_calls WHERE license_id = ? AND status = 'pending'",
                [$this->currentLicense['id']]
            )['count']
        ];
        
        $this->view('admin/dashboard', ['stats' => $stats]);
    }
    
    public function waiterCalls()
    {
        $this->requireAuth();
        $this->requireLicense();

        $calls = $this->db->fetchAll("SELECT c.*, t.table_number FROM calls c JOIN tables t ON c.table_id = t.id WHERE c.license_id = ? ORDER BY c.created_at DESC", [$this->currentLicense["id"]]);

        $this->view("admin/calls", ["calls" => $calls]);
    }

    public function reports()
    {
        $this->requireAuth();
        $this->requireLicense();
        $totalOrders = $this->db->fetchColumn("SELECT COUNT(*) FROM orders WHERE license_id = ?", [$this->currentLicense["id"]]);
        $totalRevenue = $this->db->fetchColumn("SELECT SUM(total_amount) FROM orders WHERE license_id = ? AND status = 'completed'", [$this->currentLicense["id"]]);
        $activeTables = $this->db->fetchColumn("SELECT COUNT(*) FROM tables WHERE license_id = ? AND is_active = 1", [$this->currentLicense["id"]]);

        $this->view("admin/reports", [
            "totalOrders" => $totalOrders,
            "totalRevenue" => $totalRevenue,
            "activeTables" => $activeTables
        ]);
    }
    
    public function orders()
    {
        $this->requireAuth();
        $this->requireLicense();

        $orders = $this->db->fetchAll("SELECT o.*, t.table_number FROM orders o JOIN tables t ON o.table_id = t.id WHERE o.license_id = ? ORDER BY o.created_at DESC", [$this->currentLicense["id"]]);

        $this->view("admin/orders", ["orders" => $orders]);
    }

    
    public function menu()
    {
        $this->requireAuth();
        $this->requireLicense();

        $categories = $this->db->fetchAll("SELECT * FROM categories WHERE license_id = ? ORDER BY display_order ASC", [$this->currentLicense["id"]]);
        $menuItems = $this->db->fetchAll("SELECT mi.*, c.name as category_name FROM menu_items mi JOIN categories c ON mi.category_id = c.id WHERE mi.license_id = ? ORDER BY c.display_order ASC, mi.display_order ASC", [$this->currentLicense["id"]]);

        $this->view("admin/menu", ["categories" => $categories, "menuItems" => $menuItems]);
    }

    
    public function tables()
    {
        $this->requireAuth();
        $this->requireLicense();

        $tables = $this->db->fetchAll("SELECT * FROM tables WHERE license_id = ? ORDER BY table_number ASC", [$this->currentLicense["id"]]);

        $this->view("admin/tables", ["tables" => $tables]);
    }

    
    public function loginForm() {
        if ($this->currentUser) {
            redirect('admin');
        }
        $this->view('admin/login');
    }
    
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $licenseKey = $_POST['license_key'] ?? '';
        
        if (empty($username) || empty($password) || empty($licenseKey)) {
            $this->view('admin/login', ['error' => 'Tüm alanları doldurun']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            $this->view('admin/login', ['error' => 'Geçersiz lisans anahtarı']);
            return;
        }
        
        $user = $this->db->fetchOne(
            "SELECT * FROM admin_users WHERE username = ? AND license_id = ? AND is_active = 1",
            [$username, $license['id']]
        );
        
        if (!$user || !verifyPassword($password, $user['password_hash'])) {
            $this->view('admin/login', ['error' => 'Geçersiz kullanıcı adı veya şifre']);
            return;
        }
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['license_key'] = $licenseKey;
        $this->db->update('admin_users', 
            ['last_login' => date('Y-m-d H:i:s')], 
            'id = ?', 
            [$user['id']]
        );
        
        redirect('admin');
    }
    
    public function logout() {
        destroySession();
        redirect('admin/login');
    }

    public function addCategory()
    {
        $this->requireAuth();
        $this->requireLicense();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"] ?? "";
            $displayOrder = $_POST["display_order"] ?? 0;
            $isActive = isset($_POST["is_active"]) ? 1 : 0;

            if (empty($name)) {
                $this->view("admin/category_form", ["error" => "Kategori adı boş olamaz."]);
                return;
            }

            $this->db->insert("categories", [
                "name" => $name,
                "display_order" => $displayOrder,
                "is_active" => $isActive,
                "license_id" => $this->currentLicense["id"]
            ]);
            redirect("admin/menu");
        }

        $this->view("admin/category_form");
    }

    public function editCategory($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $category = $this->db->fetchOne("SELECT * FROM categories WHERE id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);

        if (!$category) {
            redirect("admin/menu");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"] ?? "";
            $displayOrder = $_POST["display_order"] ?? 0;
            $isActive = isset($_POST["is_active"]) ? 1 : 0;

            if (empty($name)) {
                $this->view("admin/category_form", ["category" => $category, "error" => "Kategori adı boş olamaz."]);
                return;
            }

            $this->db->update("categories", [
                "name" => $name,
                "display_order" => $displayOrder,
                "is_active" => $isActive
            ], "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
            redirect("admin/menu");
        }

        $this->view("admin/category_form", ["category" => $category]);
    }

    public function deleteCategory($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $this->db->delete("categories", "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
        redirect("admin/menu");
    }

    public function addMenuItem()
    {
        $this->requireAuth();
        $this->requireLicense();

        $categories = $this->db->fetchAll("SELECT * FROM categories WHERE license_id = ? AND is_active = 1 ORDER BY display_order ASC", [$this->currentLicense["id"]]);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"] ?? "";
            $description = $_POST["description"] ?? "";
            $categoryId = $_POST["category_id"] ?? 0;
            $price = $_POST["price"] ?? 0.0;
            $displayOrder = $_POST["display_order"] ?? 0;
            $isAvailable = isset($_POST["is_available"]) ? 1 : 0;

            if (empty($name) || empty($categoryId) || empty($price)) {
                $this->view("admin/menu_item_form", ["categories" => $categories, "error" => "Tüm gerekli alanları doldurun."]);
                return;
            }
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->uploadMenuImage($_FILES["image"]);
                if (strpos($imageUrl, "Dosya yüklenemedi:") === 0) {
                    $this->view("admin/menu_item_form", ["categories" => $categories, "error" => $imageUrl]);
                    return;
                } else if (!$imageUrl) {
                    $this->view("admin/menu_item_form", ["categories" => $categories, "error" => "Resim yüklenirken bilinmeyen bir hata oluştu."]);
                    return;
                }
            }

            $this->db->insert("menu_items", [
                "name" => $name,
                "description" => $description,
                "category_id" => $categoryId,
                "price" => $price,
                "image_url" => $imageUrl,
                "display_order" => $displayOrder,
                "is_available" => $isAvailable,
                "license_id" => $this->currentLicense["id"]
            ]);
            redirect("admin/menu");
        }

        $this->view("admin/menu_item_form", ["categories" => $categories]);
    }

    public function editMenuItem($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $menuItem = $this->db->fetchOne("SELECT * FROM menu_items WHERE id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
        $categories = $this->db->fetchAll("SELECT * FROM categories WHERE license_id = ? AND is_active = 1 ORDER BY display_order ASC", [$this->currentLicense["id"]]);

        if (!$menuItem) {
            redirect("admin/menu");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"] ?? "";
            $description = $_POST["description"] ?? "";
            $categoryId = $_POST["category_id"] ?? 0;
            $price = $_POST["price"] ?? 0.0;
            $displayOrder = $_POST["display_order"] ?? 0;
            $isAvailable = isset($_POST["is_available"]) ? 1 : 0;

            if (empty($name) || empty($categoryId) || empty($price)) {
                $this->view("admin/menu_item_form", ["menuItem" => $menuItem, "categories" => $categories, "error" => "Tüm gerekli alanları doldurun."]);
                return;
            }
            $imageUrl = $menuItem["image_url"]; // Mevcut resmi koru
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $newImageUrl = $this->uploadMenuImage($_FILES["image"]);
                if (strpos($newImageUrl, "Dosya yüklenemedi:") === 0) {
                    $this->view("admin/menu_item_form", ["menuItem" => $menuItem, "categories" => $categories, "error" => $newImageUrl]);
                    return;
                } else if ($newImageUrl) {
                    if (!empty($menuItem["image_url"])) {
                        $this->deleteMenuImage($menuItem["image_url"]);
                    }
                    $imageUrl = $newImageUrl;
                } else {
                }
            } else if (isset($_POST["delete_image"]) && $_POST["delete_image"] == "1") {
                if (!empty($menuItem["image_url"])) {
                    $this->deleteMenuImage($menuItem["image_url"]);
                }
                $imageUrl = null; // Veritabanındaki image_url'i null yap
            } else if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
                $this->view("admin/menu_item_form", ["menuItem" => $menuItem, "categories" => $categories, "error" => "Resim yüklenirken bir hata oluştu. Hata Kodu: " . $_FILES["image"]["error"]]);
                return;
            }

            $this->db->update("menu_items", [
                "name" => $name,
                "description" => $description,
                "category_id" => $categoryId,
                "price" => $price,
                "image_url" => $imageUrl,
                "display_order" => $displayOrder,
                "is_available" => $isAvailable
            ], "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
            redirect("admin/menu");
        }

        $this->view("admin/menu_item_form", ["menuItem" => $menuItem, "categories" => $categories]);
    }

    public function deleteMenuItem($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $this->db->delete("menu_items", "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
        redirect("admin/menu");
    }

    public function viewOrder($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $order = $this->db->fetchOne("SELECT o.*, t.table_number FROM orders o JOIN tables t ON o.table_id = t.id WHERE o.id = ? AND o.license_id = ?", [$id, $this->currentLicense["id"]]);

        if (!$order) {
            $this->view("error", ["message" => "Sipariş bulunamadı."]);
            return;
        }

        $orderItems = $this->db->fetchAll("SELECT oi.*, mi.name as menu_item_name FROM order_items oi JOIN menu_items mi ON oi.menu_item_id = mi.id WHERE oi.order_id = ?", [$id]);

        $this->view("admin/order_detail", ["order" => $order, "orderItems" => $orderItems]);
    }

    public function completeOrder($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $order = $this->db->fetchOne("SELECT * FROM orders WHERE id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);

        if (!$order) {
            redirect("admin/orders");
            return;
        }

        $this->db->update("orders", [
            "status" => "completed",
            "completed_at" => date("Y-m-d H:i:s")
        ], "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);

        redirect("admin/orders");
    }

    public function addTable()
    {
        $this->requireAuth();
        $this->requireLicense();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tableNumber = $_POST["table_number"] ?? "";
            $capacity = $_POST["capacity"] ?? 4;
            $isActive = isset($_POST["is_active"]) ? 1 : 0;

            if (empty($tableNumber)) {
                $this->view("admin/table_form", ["error" => "Masa numarası boş olamaz."]);
                return;
            }

            $this->db->insert("tables", [
                "table_number" => $tableNumber,
                "capacity" => $capacity,
                "is_active" => $isActive,
                "license_id" => $this->currentLicense["id"]
            ]);
            redirect("admin/tables");
        }

        $this->view("admin/table_form");
    }

    public function editTable($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $table = $this->db->fetchOne("SELECT * FROM tables WHERE id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);

        if (!$table) {
            redirect("admin/tables");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tableNumber = $_POST["table_number"] ?? "";
            $capacity = $_POST["capacity"] ?? 4;
            $isActive = isset($_POST["is_active"]) ? 1 : 0;

            if (empty($tableNumber)) {
                $this->view("admin/table_form", ["table" => $table, "error" => "Masa numarası boş olamaz."]);
                return;
            }

            $this->db->update("tables", [
                "table_number" => $tableNumber,
                "capacity" => $capacity,
                "is_active" => $isActive
            ], "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
            redirect("admin/tables");
        }

        $this->view("admin/table_form", ["table" => $table]);
    }

    public function deleteTable($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $this->db->delete("tables", "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
        redirect("admin/tables");
    }

    public function qrCode($tableId)
    {
        $this->requireAuth();
        $this->requireLicense();

        $table = $this->db->fetchOne("SELECT * FROM tables WHERE id = ? AND license_id = ?", [$tableId, $this->currentLicense["id"]]);

        if (!$table) {
            $this->view("error", ["message" => "Masa bulunamadı."]);
            return;
        }

        $qrUrl = APP_URL . "/table/{$tableId}?license=" . $this->currentLicense["license_key"];

        $this->view("admin/qr_code", ["table" => $table, "qrUrl" => $qrUrl]);
    }

    public function completeWaiterCall($id)
    {
        $this->requireAuth();
        $this->requireLicense();

        $call = $this->db->fetchOne("SELECT * FROM calls WHERE id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);

        if (!$call) {
            redirect("admin/waiter-calls");
            return;
        }

      $this->db->update("calls", [
    "status" => "completed",
    "completed_at" => date("Y-m-d H:i:s")
], "id = ? AND license_id = ?", [$id, $this->currentLicense["id"]]);
}

    private function uploadMenuImage($file)
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        if (!in_array($file["type"], $allowedTypes)) {
            return "Dosya türü desteklenmiyor: " . $file["type"];
        }
        if ($file["size"] > $maxSize) {
            return "Dosya boyutu sınırı aşıldı: " . round($file["size"] / (1024 * 1024), 2) . "MB (Max 5MB)";
        }
        $uploadDir = __DIR__ . '/../public/uploads/menu_images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('menu_') . '.' . $extension;
        $filePath = $uploadDir . $fileName;        // Dosyayı yükle
        if (move_uploaded_file($file["tmp_name"], $filePath)) {
            return 
'/uploads/menu_images/' . $fileName;
        } else {
            return "Dosya yüklenemedi: " . $file["tmp_name"] . " -> " . $filePath . ". PHP Hata Kodu: " . $file["error"];
        }
    }

    private function deleteMenuImage($imageUrl)
    {
        if (empty($imageUrl)) {
            return;
        }

        $filePath = __DIR__ . '/../public' . $imageUrl;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

?>