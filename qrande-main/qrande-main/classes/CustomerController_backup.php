<?php

class CustomerController extends Controller {
    
    public function table($id) {
        error_log("Table ID: " . $id);
        $licenseKey = $_GET['license'] ?? null;
        
        if (!$licenseKey) {
            $this->view('error', ['message' => 'Geçersiz QR kod']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            $this->view('license-expired');
            return;
        }
        
        $table = $this->db->fetchOne(
            "SELECT * FROM tables WHERE id = ? AND license_id = ? AND is_active = 1",
            [$id, $license['id']]
        );
        
        if (!$table) {
            $this->view('error', ['message' => 'Masa bulunamadı']);
            return;
        }
        $sessionId = uniqid('session_');
        $_SESSION['customer_session_id'] = $sessionId;
        $_SESSION['table_id'] = $table['id'];
        $_SESSION['license_id'] = $license['id'];
        $_SESSION['license_key'] = $licenseKey;
        
        $this->db->insert('customer_sessions', [
            'license_id' => $license['id'],
            'session_id' => $sessionId,
            'table_id' => $table['id']
        ]);
        
        $this->redirect("/menu/{$id}?license={$licenseKey}");
    }

    public function menu($tableId) {
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$licenseKey) {
            $this->view('error', ['message' => 'Lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin.']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            $this->view('license-expired');
            return;
        }
        if (!isset($_SESSION['customer_session_id'])) {
            $sessionId = uniqid('session_');
            $_SESSION['customer_session_id'] = $sessionId;
            $_SESSION['table_id'] = $tableId;
            $_SESSION['license_id'] = $license['id'];
            $_SESSION['license_key'] = $licenseKey;
            
            $this->db->insert('customer_sessions', [
                'license_id' => $license['id'],
                'session_id' => $sessionId,
                'table_id' => $tableId
            ]);
        }
        
        $table = $this->db->fetchOne(
            "SELECT * FROM tables WHERE id = ? AND license_id = ?",
            [$tableId, $license['id']]
        );
        
        $categories = $this->db->fetchAll(
            "SELECT * FROM categories WHERE license_id = ? AND is_active = 1 ORDER BY display_order",
            [$license['id']]
        );
        
        $menuItems = $this->db->fetchAll(
            "SELECT mi.*, c.name as category_name 
             FROM menu_items mi 
             JOIN categories c ON mi.category_id = c.id 
             WHERE mi.license_id = ? AND mi.is_available = 1 
             ORDER BY c.display_order, mi.display_order",
            [$license['id']]
        );
        
        $this->view('customer/menu', [
            'table' => $table,
            'categories' => $categories,
            'menuItems' => $menuItems
        ]);
    }
    
    public function placeOrder()
    {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $tableId = $input["table_id"] ?? null;
        $licenseKey = $input["license"] ?? $_SESSION['license_key'] ?? null;
        $orderItems = $input["order_items"] ?? [];
        $totalAmount = $input["total_amount"] ?? 0;

        if (!$tableId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Masa numarası veya lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin."]);
            return;
        }
        
        if (empty($orderItems)) {
            echo json_encode(["status" => "error", "message" => "Sipariş öğeleri eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }

        $this->db->beginTransaction();
        try {
            $sessionData = null;
            if (isset($_SESSION['customer_session_id'])) {
                $sessionData = $this->db->fetchOne(
                    "SELECT * FROM customer_sessions WHERE session_id = ?",
                    [$_SESSION['customer_session_id']]
                );
            }
            
            if (!$sessionData) {
                $sessionId = uniqid('session_');
                $_SESSION['customer_session_id'] = $sessionId;
                $_SESSION['table_id'] = $tableId;
                $_SESSION['license_id'] = $license['id'];
                $_SESSION['license_key'] = $licenseKey;
                
                $sessionDataId = $this->db->insert('customer_sessions', [
                    'license_id' => $license['id'],
                    'session_id' => $sessionId,
                    'table_id' => $tableId
                ]);
                
                $sessionData = ['id' => $sessionDataId];
            }
            
            $orderNumber = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $orderId = $this->db->insert("orders", [
                "license_id" => $license['id'],
                "session_id" => $sessionData['id'],
                "table_id" => $tableId,
                "order_number" => $orderNumber,
                "payment_method" => "cash",
                "subtotal" => $totalAmount,
                "total_amount" => $totalAmount,
                "status" => "pending",
                "created_at" => date("Y-m-d H:i:s")
            ]);

            foreach ($orderItems as $item) {
                $this->db->insert("order_items", [
                    "order_id" => $orderId,
                    "menu_item_id" => $item["id"],
                    "quantity" => $item["quantity"],
                    "price" => $item["price"]
                ]);
            }

            $this->db->commit();
            echo json_encode(["status" => "success", "message" => "Siparişiniz alındı. Sipariş No: " . $orderNumber, "order_id" => $orderId]);
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Order placement error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sipariş verilirken bir hata oluştu."]);
        }
    }
    
    public function callWaiter()
    {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $tableId = $input["table_id"] ?? null;
        $licenseKey = $input["license"] ?? $_SESSION['license_key'] ?? null;

        if (!$tableId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Masa numarası veya lisans anahtarı eksik. Lütfen QR kodunu kullanarak erişin."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }

        try {
            $this->db->insert("calls", [
                "license_id" => $license['id'],
                "table_id" => $tableId,
                "status" => "pending",
                "created_at" => date("Y-m-d H:i:s")
            ]);
            echo json_encode(["status" => "success", "message" => "Garson çağrınız alındı."]);
        } catch (Exception $e) {
            error_log("Waiter call error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Garson çağrılırken bir hata oluştu."]);
        }
    }
    
    public function orderStatus($orderId) {
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$licenseKey) {
            $this->json(['error' => 'Lisans anahtarı eksik'], 400);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            $this->json(['error' => 'Geçersiz lisans anahtarı'], 400);
            return;
        }
        
        $order = $this->db->fetchOne(
            "SELECT * FROM orders WHERE id = ? AND license_id = ?",
            [$orderId, $license['id']]
        );
        
        if (!$order) {
            $this->json(['error' => 'Sipariş bulunamadı'], 404);
            return;
        }
        
        $this->json([
            'order_id' => $order['id'],
            'order_number' => $order['order_number'],
            'status' => $order['status'],
            'estimated_time' => $order['estimated_time'],
            'total_amount' => $order['total_amount']
        ]);
    }
}
?>

