<?php

class ApiController extends Controller {
    
    public function getMenu($tableId) {
        header('Content-Type: application/json');
        
        $licenseKey = $_GET['license'] ?? null;
        
        if (!$licenseKey) {
            echo json_encode(['error' => 'License key required']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['error' => 'Invalid license key']);
            return;
        }
        
        $table = $this->db->fetchOne(
            "SELECT * FROM tables WHERE id = ? AND license_id = ?",
            [$tableId, $license['id']]
        );
        
        if (!$table) {
            echo json_encode(['error' => 'Table not found']);
            return;
        }
        
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
        
        echo json_encode([
            'table' => $table,
            'categories' => $categories,
            'menu_items' => $menuItems
        ]);
    }
    
    public function getOrderStatus($orderId) {
        header('Content-Type: application/json');
        
        $licenseKey = $_GET['license'] ?? null;
        
        if (!$licenseKey) {
            echo json_encode(['error' => 'License key required']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['error' => 'Invalid license key']);
            return;
        }
        
        $order = $this->db->fetchOne(
            "SELECT * FROM orders WHERE id = ? AND license_id = ?",
            [$orderId, $license['id']]
        );
        
        if (!$order) {
            echo json_encode(['error' => 'Order not found']);
            return;
        }
        
        echo json_encode([
            'order_id' => $order['id'],
            'order_number' => $order['order_number'],
            'status' => $order['status'],
            'estimated_time' => $order['estimated_time'],
            'total_amount' => $order['total_amount'],
            'created_at' => $order['created_at']
        ]);
    }
    
    public function getPendingCalls() {
        header('Content-Type: application/json');
        
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$licenseKey) {
            echo json_encode(['success' => false, 'error' => 'License key required']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['success' => false, 'error' => 'Invalid license key']);
            return;
        }
        
        try {
            $calls = $this->db->fetchAll(
                "SELECT wc.*, t.table_number 
                 FROM waiter_calls wc 
                 JOIN tables t ON wc.table_id = t.id 
                 WHERE wc.license_id = ? AND wc.status = 'pending' 
                 ORDER BY wc.created_at DESC",
                [$license['id']]
            );
            
            echo json_encode([
                'success' => true,
                'calls' => $calls,
                'count' => count($calls)
            ]);
        } catch (Exception $e) {
            error_log("Get pending calls error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
    
    public function getAllCalls() {
        header('Content-Type: application/json');
        
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$licenseKey) {
            echo json_encode(['success' => false, 'error' => 'License key required']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['success' => false, 'error' => 'Invalid license key']);
            return;
        }
        
        try {
            $calls = $this->db->fetchAll(
                "SELECT wc.*, t.table_number, au.full_name as acknowledged_by_name
                 FROM waiter_calls wc 
                 JOIN tables t ON wc.table_id = t.id 
                 LEFT JOIN admin_users au ON wc.acknowledged_by = au.id
                 WHERE wc.license_id = ? 
                 ORDER BY wc.created_at DESC 
                 LIMIT 50",
                [$license['id']]
            );
            
            echo json_encode([
                'success' => true,
                'calls' => $calls,
                'count' => count($calls)
            ]);
        } catch (Exception $e) {
            error_log("Get all calls error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
    
    public function acknowledgeCall() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $callId = $input['call_id'] ?? null;
        $licenseKey = $input['license'] ?? $_SESSION['license_key'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$callId || !$licenseKey || !$userId) {
            echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['success' => false, 'error' => 'Invalid license key']);
            return;
        }
        
        try {
            $call = $this->db->fetchOne(
                "SELECT * FROM waiter_calls WHERE id = ? AND license_id = ?",
                [$callId, $license['id']]
            );
            
            if (!$call) {
                echo json_encode(['success' => false, 'error' => 'Call not found']);
                return;
            }
            
            if ($call['status'] !== 'pending') {
                echo json_encode(['success' => false, 'error' => 'Call already processed']);
                return;
            }
            
            $this->db->update('waiter_calls', [
                'status' => 'acknowledged',
                'acknowledged_by' => $userId,
                'acknowledged_at' => date('Y-m-d H:i:s')
            ], 'id = ?', [$callId]);
            
            echo json_encode(['success' => true, 'message' => 'Call acknowledged']);
        } catch (Exception $e) {
            error_log("Acknowledge call error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
    
    public function completeCall() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents("php://input"), true);
        $callId = $input['call_id'] ?? null;
        $licenseKey = $input['license'] ?? $_SESSION['license_key'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;
        $responseMessage = $input['response_message'] ?? null;
        
        if (!$callId || !$licenseKey || !$userId) {
            echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['success' => false, 'error' => 'Invalid license key']);
            return;
        }
        
        try {
            $call = $this->db->fetchOne(
                "SELECT * FROM waiter_calls WHERE id = ? AND license_id = ?",
                [$callId, $license['id']]
            );
            
            if (!$call) {
                echo json_encode(['success' => false, 'error' => 'Call not found']);
                return;
            }
            
            if ($call['status'] === 'completed') {
                echo json_encode(['success' => false, 'error' => 'Call already completed']);
                return;
            }
            
            $updateData = [
                'status' => 'completed',
                'completed_at' => date('Y-m-d H:i:s')
            ];
            
            if ($call['status'] === 'pending') {
                $updateData['acknowledged_by'] = $userId;
                $updateData['acknowledged_at'] = date('Y-m-d H:i:s');
            }
            
            if ($responseMessage) {
                $updateData['response_message'] = $responseMessage;
            }
            
            $this->db->update('waiter_calls', $updateData, 'id = ?', [$callId]);
            
            echo json_encode(['success' => true, 'message' => 'Call completed']);
        } catch (Exception $e) {
            error_log("Complete call error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
    
    public function getStats() {
        header('Content-Type: application/json');
        
        $licenseKey = $_GET['license'] ?? $_SESSION['license_key'] ?? null;
        
        if (!$licenseKey) {
            echo json_encode(['success' => false, 'error' => 'License key required']);
            return;
        }
        
        $license = checkLicense($licenseKey);
        if (!$license) {
            echo json_encode(['success' => false, 'error' => 'Invalid license key']);
            return;
        }
        
        try {
            $stats = [
                'today_orders' => $this->db->fetchOne(
                    "SELECT COUNT(*) as count FROM orders WHERE license_id = ? AND DATE(created_at) = CURDATE()",
                    [$license['id']]
                )['count'],
                'today_revenue' => $this->db->fetchOne(
                    "SELECT SUM(total_amount) as total FROM orders WHERE license_id = ? AND DATE(created_at) = CURDATE()",
                    [$license['id']]
                )['total'] ?? 0,
                'pending_orders' => $this->db->fetchOne(
                    "SELECT COUNT(*) as count FROM orders WHERE license_id = ? AND status IN ('pending', 'preparing')",
                    [$license['id']]
                )['count'],
                'pending_calls' => $this->db->fetchOne(
                    "SELECT COUNT(*) as count FROM waiter_calls WHERE license_id = ? AND status = 'pending'",
                    [$license['id']]
                )['count'],
                'active_tables' => $this->db->fetchOne(
                    "SELECT COUNT(*) as count FROM tables WHERE license_id = ? AND status = 'occupied'",
                    [$license['id']]
                )['count'],
                'total_tables' => $this->db->fetchOne(
                    "SELECT COUNT(*) as count FROM tables WHERE license_id = ? AND is_active = 1",
                    [$license['id']]
                )['count']
            ];
            
            echo json_encode(['success' => true, 'stats' => $stats]);
        } catch (Exception $e) {
            error_log("Get stats error: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
}
?>

