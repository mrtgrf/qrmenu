<?php

class CustomerController extends Controller {
    
    public function table($id) {
        error_log("Table ID: " . $id);
        $table = $this->db->fetchOne(
            "SELECT t.*, l.license_key FROM tables t 
             JOIN licenses l ON t.license_id = l.id 
             WHERE t.id = ? AND t.is_active = 1",
            [$id]
        );
        
        if (!$table) {
            $this->view('error', ['message' => 'Masa bulunamadı']);
            return;
        }
        $license = checkLicense($table['license_key']);
        if (!$license) {
            $this->view('license-expired');
            return;
        }
        $_SESSION['table_id'] = $table['id'];
        $_SESSION['license_id'] = $license['id'];
        redirect("/menu/{$id}");
    }

    public function menu($tableId) {
        $sessionTableId = $_SESSION['table_id'] ?? null;
        $licenseId = $_SESSION['license_id'] ?? null;
        if (!$sessionTableId || $sessionTableId != $tableId || !$licenseId) {
            $table = $this->db->fetchOne(
                "SELECT t.*, l.license_key FROM tables t 
                 JOIN licenses l ON t.license_id = l.id 
                 WHERE t.id = ? AND t.is_active = 1",
                [$tableId]
            );
            
            if (!$table) {
                $this->view('error', ['message' => 'Masa bulunamadı']);
                return;
            }
            
            $license = checkLicense($table['license_key']);
            if (!$license) {
                $this->view('license-expired');
                return;
            }
            $_SESSION['table_id'] = $table['id'];
            $_SESSION['license_id'] = $license['id'];
            $licenseId = $license['id'];
        }
        
        $table = $this->db->fetchOne(
            "SELECT * FROM tables WHERE id = ? AND license_id = ?",
            [$tableId, $licenseId]
        );
        
        $categories = $this->db->fetchAll(
            "SELECT * FROM categories WHERE license_id = ? AND is_active = 1 ORDER BY display_order",
            [$licenseId]
        );
        
        $menuItems = $this->db->fetchAll(
            "SELECT mi.*, c.name as category_name 
             FROM menu_items mi 
             JOIN categories c ON mi.category_id = c.id 
             WHERE mi.license_id = ? AND mi.is_available = 1 
             ORDER BY c.display_order, mi.display_order",
            [$licenseId]
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
        $tableId = $_SESSION['table_id'] ?? null;
        $licenseId = $_SESSION['license_id'] ?? null;
        $orderItems = $input["order_items"] ?? [];
        $totalAmount = $input["total_amount"] ?? 0;
        $specialNotes = $input["special_notes"] ?? "";

        error_log("Place Order - Table ID: " . $tableId . ", License ID: " . $licenseId);
        error_log("Order Items: " . json_encode($orderItems));
        error_log("Order Items Count: " . count($orderItems));
        error_log("Special Notes: " . $specialNotes);

        if (!$tableId || !$licenseId) {
            echo json_encode(["status" => "error", "message" => "Oturum süresi dolmuş. Lütfen sayfayı yenileyin."]);
            return;
        }
        
        if (empty($orderItems)) {
            echo json_encode(["status" => "error", "message" => "Sipariş öğeleri eksik."]);
            return;
        }

        $this->db->beginTransaction();
        try {
            $orderNumber = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderId = $this->db->insert("orders", [
                "license_id" => $licenseId,
                "session_id" => null,
                "table_id" => $tableId,
                "order_number" => $orderNumber,
                "payment_method" => "cash",
                "subtotal" => $totalAmount,
                "total_amount" => $totalAmount,
                "status" => "pending",
                "special_notes" => $specialNotes,
                "created_at" => date("Y-m-d H:i:s")
            ]);

            error_log("Order created with ID: " . $orderId);

            foreach ($orderItems as $item) {
                error_log("Processing order item: " . json_encode($item));
                
                $insertResult = $this->db->insert("order_items", [
                    "order_id" => $orderId,
                    "menu_item_id" => $item["id"],
                    "quantity" => $item["quantity"],
                    "unit_price" => $item["price"]
                ]);
                
                error_log("Order item insert result: " . $insertResult);
            }

            $this->db->commit();
            error_log("Order placed successfully - Order ID: " . $orderId);
            echo json_encode(["status" => "success", "message" => "Siparişiniz alındı. Sipariş No: " . $orderNumber, "order_id" => $orderId]);
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Order placement error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sipariş verilirken bir hata oluştu: " . $e->getMessage()]);
        }
    }
    
   public function callWaiter()
{
    header('Content-Type: application/json');
    error_log("==> callWaiter() methodu çalıştı"); // 1

    $tableId = $_SESSION['table_id'] ?? null;
    $licenseId = $_SESSION['license_id'] ?? null;

    error_log("Session Table ID: " . var_export($tableId, true));  // 2
    error_log("Session License ID: " . var_export($licenseId, true)); // 3

    if (!$tableId || !$licenseId) {
        error_log("==> Session yok veya eksik"); // 4
        echo json_encode(["status" => "error", "message" => "Oturum süresi dolmuş. Lütfen sayfayı yenileyin."]);
        return;
    }

    try {
        error_log("==> Insert işlemine girildi"); // 5
        $callId = $this->db->insert("waiter_calls", [
            "license_id" => $licenseId,
            "table_id" => $tableId,
            "status" => "pending",
            "created_at" => date("Y-m-d H:i:s")
        ]);
        error_log("Garson çağrısı oluşturuldu - ID: " . $callId); // 6
        echo json_encode(["status" => "success", "message" => "Garson çağrınız alındı."]);
    } catch (Exception $e) {
        error_log("Garson çağrısı hatası: " . $e->getMessage()); // 7
        echo json_encode(["status" => "error", "message" => "Garson çağrılırken bir hata oluştu."]);
    }
}

    public function orderStatus($orderId) {
        $licenseId = $_SESSION['license_id'] ?? null;
        
        if (!$licenseId) {
            $this->json(['error' => 'Oturum süresi dolmuş'], 400);
            return;
        }
        
        $order = $this->db->fetchOne(
            "SELECT * FROM orders WHERE id = ? AND license_id = ?",
            [$orderId, $licenseId]
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