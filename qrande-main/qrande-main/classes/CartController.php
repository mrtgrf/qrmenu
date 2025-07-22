<?php

class CartController extends Controller {
    
    public function addItem() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $sessionId = $_SESSION['customer_session_id'] ?? null;
        $menuItemId = $input['menu_item_id'] ?? null;
        $quantity = $input['quantity'] ?? 1;
        $licenseKey = $input['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$sessionId || !$menuItemId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Gerekli parametreler eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }
        $menuItem = $this->db->fetchOne(
            "SELECT * FROM menu_items WHERE id = ? AND license_id = ? AND is_available = 1",
            [$menuItemId, $license['id']]
        );
        
        if (!$menuItem) {
            echo json_encode(["status" => "error", "message" => "Menü öğesi bulunamadı veya mevcut değil."]);
            return;
        }
        
        try {
            $existingItem = $this->db->fetchOne(
                "SELECT * FROM cart_items WHERE session_id = ? AND menu_item_id = ?",
                [$sessionId, $menuItemId]
            );
            
            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                $newTotalPrice = $newQuantity * $menuItem['price'];
                
                $this->db->update('cart_items', [
                    'quantity' => $newQuantity,
                    'total_price' => $newTotalPrice,
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $existingItem['id']]);
            } else {
                $totalPrice = $quantity * $menuItem['price'];
                
                $this->db->insert('cart_items', [
                    'session_id' => $sessionId,
                    'menu_item_id' => $menuItemId,
                    'quantity' => $quantity,
                    'unit_price' => $menuItem['price'],
                    'total_price' => $totalPrice
                ]);
            }
            
            echo json_encode(["status" => "success", "message" => "Ürün sepete eklendi."]);
        } catch (Exception $e) {
            error_log("Cart add item error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sepete eklenirken bir hata oluştu."]);
        }
    }
    
    public function removeItem() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $sessionId = $_SESSION['customer_session_id'] ?? null;
        $menuItemId = $input['menu_item_id'] ?? null;
        $licenseKey = $input['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$sessionId || !$menuItemId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Gerekli parametreler eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }
        
        try {
            $this->db->delete('cart_items', [
                'session_id' => $sessionId,
                'menu_item_id' => $menuItemId
            ]);
            
            echo json_encode(["status" => "success", "message" => "Ürün sepetten kaldırıldı."]);
        } catch (Exception $e) {
            error_log("Cart remove item error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sepetten kaldırılırken bir hata oluştu."]);
        }
    }
    
    public function updateQuantity() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $sessionId = $_SESSION['customer_session_id'] ?? null;
        $menuItemId = $input['menu_item_id'] ?? null;
        $quantity = $input['quantity'] ?? 0;
        $licenseKey = $input['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$sessionId || !$menuItemId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Gerekli parametreler eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }
        
        try {
            if ($quantity <= 0) {
                $this->db->delete('cart_items', [
                    'session_id' => $sessionId,
                    'menu_item_id' => $menuItemId
                ]);
                echo json_encode(["status" => "success", "message" => "Ürün sepetten kaldırıldı."]);
            } else {
                $menuItem = $this->db->fetchOne(
                    "SELECT price FROM menu_items WHERE id = ? AND license_id = ?",
                    [$menuItemId, $license['id']]
                );
                
                if (!$menuItem) {
                    echo json_encode(["status" => "error", "message" => "Menü öğesi bulunamadı."]);
                    return;
                }
                
                $totalPrice = $quantity * $menuItem['price'];
                
                $this->db->update('cart_items', [
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'session_id' => $sessionId,
                    'menu_item_id' => $menuItemId
                ]);
                
                echo json_encode(["status" => "success", "message" => "Miktar güncellendi."]);
            }
        } catch (Exception $e) {
            error_log("Cart update quantity error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Miktar güncellenirken bir hata oluştu."]);
        }
    }
    
    public function getItems() {
        header('Content-Type: application/json');
        
        $sessionId = $_SESSION['customer_session_id'] ?? null;
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$sessionId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Gerekli parametreler eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }
        
        try {
            $cartItems = $this->db->fetchAll(
                "SELECT ci.*, mi.name, mi.description, mi.image_url 
                 FROM cart_items ci 
                 JOIN menu_items mi ON ci.menu_item_id = mi.id 
                 WHERE ci.session_id = ? 
                 ORDER BY ci.created_at",
                [$sessionId]
            );
            
            $totalAmount = array_sum(array_column($cartItems, 'total_price'));
            
            echo json_encode([
                "status" => "success",
                "items" => $cartItems,
                "total_amount" => $totalAmount,
                "item_count" => count($cartItems)
            ]);
        } catch (Exception $e) {
            error_log("Cart get items error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sepet öğeleri alınırken bir hata oluştu."]);
        }
    }
    
    public function clearCart() {
        header('Content-Type: application/json');
        
        $sessionId = $_SESSION['customer_session_id'] ?? null;
        $licenseKey = $_POST['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$sessionId || !$licenseKey) {
            echo json_encode(["status" => "error", "message" => "Gerekli parametreler eksik."]);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(["status" => "error", "message" => "Geçersiz lisans anahtarı."]);
            return;
        }
        
        try {
            $this->db->delete('cart_items', ['session_id' => $sessionId]);
            echo json_encode(["status" => "success", "message" => "Sepet temizlendi."]);
        } catch (Exception $e) {
            error_log("Cart clear error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Sepet temizlenirken bir hata oluştu."]);
        }
    }
}
?>

