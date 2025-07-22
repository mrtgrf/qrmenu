<?php

class ApiController extends Controller {
    
    public function getPendingCalls() {
        header('Content-Type: application/json');
        
        try {
            $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? '';
            if (empty($licenseKey)) {
                echo json_encode(['success' => false, 'error' => 'License key required']);
                return;
            }
            
            $license = checkLicense($licenseKey);
            if (!$license) {
                echo json_encode(['success' => false, 'error' => 'Invalid license']);
                return;
            }
            $calls = $this->db->fetchAll(
                "SELECT c.*, t.table_number FROM calls c 
                 JOIN tables t ON c.table_id = t.id 
                 WHERE c.license_id = ? AND c.status = 'pending' 
                 ORDER BY c.created_at DESC",
                [$license['id']]
            );
            
            echo json_encode([
                'success' => true,
                'calls' => $calls,
                'count' => count($calls)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getMenu($tableId) {
        header('Content-Type: application/json');
        
        try {
            $licenseKey = $_GET['license'] ?? '';
            if (empty($licenseKey)) {
                echo json_encode(['success' => false, 'error' => 'License key required']);
                return;
            }
            
            $license = checkLicense($licenseKey);
            if (!$license) {
                echo json_encode(['success' => false, 'error' => 'Invalid license']);
                return;
            }
            $table = $this->db->fetchOne(
                "SELECT * FROM tables WHERE id = ? AND license_id = ? AND is_active = 1",
                [$tableId, $license['id']]
            );
            
            if (!$table) {
                echo json_encode(['success' => false, 'error' => 'Table not found']);
                return;
            }
            $categories = $this->db->fetchAll(
                "SELECT * FROM categories WHERE license_id = ? AND is_active = 1 ORDER BY display_order ASC",
                [$license['id']]
            );
            
            $menuItems = $this->db->fetchAll(
                "SELECT * FROM menu_items WHERE license_id = ? AND is_available = 1 ORDER BY display_order ASC",
                [$license['id']]
            );
            $menu = [];
            foreach ($categories as $category) {
                $category['items'] = array_filter($menuItems, function($item) use ($category) {
                    return $item['category_id'] == $category['id'];
                });
                $menu[] = $category;
            }
            
            echo json_encode([
                'success' => true,
                'table' => $table,
                'menu' => $menu
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getOrderStatus($id) {
        header('Content-Type: application/json');
        
        try {
            $licenseKey = $_GET['license'] ?? '';
            if (empty($licenseKey)) {
                echo json_encode(['success' => false, 'error' => 'License key required']);
                return;
            }
            
            $license = checkLicense($licenseKey);
            if (!$license) {
                echo json_encode(['success' => false, 'error' => 'Invalid license']);
                return;
            }
            $order = $this->db->fetchOne(
                "SELECT o.*, t.table_number FROM orders o 
                 JOIN tables t ON o.table_id = t.id 
                 WHERE o.id = ? AND o.license_id = ?",
                [$id, $license['id']]
            );
            
            if (!$order) {
                echo json_encode(['success' => false, 'error' => 'Order not found']);
                return;
            }
            
            echo json_encode([
                'success' => true,
                'order' => $order
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
}

?>

