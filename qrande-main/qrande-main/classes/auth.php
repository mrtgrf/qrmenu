<?php
class Auth {
    private $db;
    private $sessionKey = 'user_id';
    private $licenseKey = 'license_key';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    public function login($username, $password, $licenseKey = null) {
        try {
            if ($licenseKey) {
                $license = checkLicense($licenseKey);
                if (!$license) {
                    return ['success' => false, 'message' => 'Geçersiz lisans anahtarı'];
                }
                $licenseId = $license['id'];
            } else {
                return ['success' => false, 'message' => 'Lisans anahtarı gerekli'];
            }
            $user = $this->db->fetchOne(
                "SELECT * FROM admin_users WHERE (username = ? OR email = ?) AND license_id = ? AND is_active = 1",
                [$username, $username, $licenseId]
            );
            
            if (!$user) {
                writeLog("Failed login attempt for username: {$username}", 'warning', $licenseId);
                return ['success' => false, 'message' => 'Kullanıcı adı veya şifre hatalı'];
            }
            if (!verifyPassword($password, $user['password_hash'])) {
                writeLog("Failed login attempt for user: {$user['username']}", 'warning', $licenseId, $user['id']);
                return ['success' => false, 'message' => 'Kullanıcı adı veya şifre hatalı'];
            }
            $this->db->update(
                'admin_users',
                ['last_login' => date('Y-m-d H:i:s')],
                'id = ?',
                [$user['id']]
            );
            $_SESSION[$this->sessionKey] = $user['id'];
            $_SESSION[$this->licenseKey] = $licenseKey;
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['full_name'];
            writeLog("Successful login", 'info', $licenseId, $user['id']);
            
            return ['success' => true, 'message' => 'Giriş başarılı', 'user' => $user];
            
        } catch (Exception $e) {
            writeLog("Login error: " . $e->getMessage(), 'error');
            return ['success' => false, 'message' => 'Bir hata oluştu'];
        }
    }
    public function logout() {
        $userId = $_SESSION[$this->sessionKey] ?? null;
        $licenseKey = $_SESSION[$this->licenseKey] ?? null;
        
        if ($userId && $licenseKey) {
            $license = checkLicense($licenseKey);
            if ($license) {
                writeLog("User logged out", 'info', $license['id'], $userId);
            }
        }
        unset($_SESSION[$this->sessionKey]);
        unset($_SESSION[$this->licenseKey]);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_name']);
        
        return true;
    }
    public function isLoggedIn() {
        return isset($_SESSION[$this->sessionKey]) && isset($_SESSION[$this->licenseKey]);
    }
    public function getUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        $userId = $_SESSION[$this->sessionKey];
        $licenseKey = $_SESSION[$this->licenseKey];
        $license = checkLicense($licenseKey);
        if (!$license) {
            $this->logout();
            return null;
        }
        
        $user = $this->db->fetchOne(
            "SELECT * FROM admin_users WHERE id = ? AND license_id = ? AND is_active = 1",
            [$userId, $license['id']]
        );
        
        if (!$user) {
            $this->logout();
            return null;
        }
        
        return $user;
    }
    public function hasRole($role) {
        $user = $this->getUser();
        if (!$user) {
            return false;
        }
        
        if (is_array($role)) {
            return in_array($user['role'], $role);
        }
        
        return $user['role'] === $role;
    }
    public function isAdmin() {
        return $this->hasRole(['super_admin', 'admin']);
    }
    public function isSuperAdmin() {
        return $this->hasRole('super_admin');
    }
    public function changePassword($userId, $oldPassword, $newPassword) {
        $user = $this->db->fetchOne(
            "SELECT * FROM admin_users WHERE id = ?",
            [$userId]
        );
        
        if (!$user) {
            return ['success' => false, 'message' => 'Kullanıcı bulunamadı'];
        }
        
        if (!verifyPassword($oldPassword, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Mevcut şifre hatalı'];
        }
        
        $newPasswordHash = hashPassword($newPassword);
        
        $updated = $this->db->update(
            'admin_users',
            ['password_hash' => $newPasswordHash],
            'id = ?',
            [$userId]
        );
        
        if ($updated) {
            writeLog("Password changed", 'info', $user['license_id'], $userId);
            return ['success' => true, 'message' => 'Şifre başarıyla değiştirildi'];
        }
        
        return ['success' => false, 'message' => 'Şifre değiştirilemedi'];
    }
    public function createUser($data) {
        try {
            if (!validateEmail($data['email'])) {
                return ['success' => false, 'message' => 'Geçersiz email adresi'];
            }
            $existingUser = $this->db->fetchOne(
                "SELECT id FROM admin_users WHERE (username = ? OR email = ?) AND license_id = ?",
                [$data['username'], $data['email'], $data['license_id']]
            );
            
            if ($existingUser) {
                return ['success' => false, 'message' => 'Bu kullanıcı adı veya email zaten mevcut'];
            }
            $userData = [
                'license_id' => $data['license_id'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password_hash' => hashPassword($data['password']),
                'full_name' => $data['full_name'],
                'role' => $data['role'] ?? 'admin',
                'is_active' => 1
            ];
            
            $userId = $this->db->insert('admin_users', $userData);
            
            if ($userId) {
                writeLog("New user created: {$data['username']}", 'info', $data['license_id']);
                return ['success' => true, 'message' => 'Kullanıcı başarıyla oluşturuldu', 'user_id' => $userId];
            }
            
            return ['success' => false, 'message' => 'Kullanıcı oluşturulamadı'];
            
        } catch (Exception $e) {
            writeLog("User creation error: " . $e->getMessage(), 'error');
            return ['success' => false, 'message' => 'Bir hata oluştu'];
        }
    }
    public function updateUser($userId, $data) {
        try {
            $updateData = [];
            
            if (isset($data['full_name'])) {
                $updateData['full_name'] = $data['full_name'];
            }
            
            if (isset($data['email'])) {
                if (!validateEmail($data['email'])) {
                    return ['success' => false, 'message' => 'Geçersiz email adresi'];
                }
                $updateData['email'] = $data['email'];
            }
            
            if (isset($data['role'])) {
                $updateData['role'] = $data['role'];
            }
            
            if (isset($data['is_active'])) {
                $updateData['is_active'] = $data['is_active'];
            }
            
            if (empty($updateData)) {
                return ['success' => false, 'message' => 'Güncellenecek veri bulunamadı'];
            }
            
            $updated = $this->db->update(
                'admin_users',
                $updateData,
                'id = ?',
                [$userId]
            );
            
            if ($updated) {
                writeLog("User updated: {$userId}", 'info');
                return ['success' => true, 'message' => 'Kullanıcı başarıyla güncellendi'];
            }
            
            return ['success' => false, 'message' => 'Kullanıcı güncellenemedi'];
            
        } catch (Exception $e) {
            writeLog("User update error: " . $e->getMessage(), 'error');
            return ['success' => false, 'message' => 'Bir hata oluştu'];
        }
    }
    public function deleteUser($userId) {
        try {
            $deleted = $this->db->delete(
                'admin_users',
                'id = ?',
                [$userId]
            );
            
            if ($deleted) {
                writeLog("User deleted: {$userId}", 'info');
                return ['success' => true, 'message' => 'Kullanıcı başarıyla silindi'];
            }
            
            return ['success' => false, 'message' => 'Kullanıcı silinemedi'];
            
        } catch (Exception $e) {
            writeLog("User deletion error: " . $e->getMessage(), 'error');
            return ['success' => false, 'message' => 'Bir hata oluştu'];
        }
    }
    public function createPasswordResetToken($email) {
        $user = $this->db->fetchOne(
            "SELECT * FROM admin_users WHERE email = ? AND is_active = 1",
            [$email]
        );
        
        if (!$user) {
            return ['success' => false, 'message' => 'Email adresi bulunamadı'];
        }
        
        $token = generateToken();
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->db->insert('settings', [
            'license_id' => $user['license_id'],
            'setting_key' => 'password_reset_token_' . $user['id'],
            'setting_value' => json_encode([
                'token' => $token,
                'expiry' => $expiry
            ]),
            'setting_type' => 'json'
        ]);
        
        return ['success' => true, 'token' => $token, 'user' => $user];
    }
    public function validatePasswordResetToken($token) {
        $settings = $this->db->fetchAll(
            "SELECT * FROM settings WHERE setting_key LIKE 'password_reset_token_%'"
        );
        
        foreach ($settings as $setting) {
            $data = json_decode($setting['setting_value'], true);
            if ($data['token'] === $token && $data['expiry'] > date('Y-m-d H:i:s')) {
                $userId = str_replace('password_reset_token_', '', $setting['setting_key']);
                return ['success' => true, 'user_id' => $userId];
            }
        }
        
        return ['success' => false, 'message' => 'Geçersiz veya süresi dolmuş token'];
    }
    public function resetPasswordWithToken($token, $newPassword) {
        $validation = $this->validatePasswordResetToken($token);
        
        if (!$validation['success']) {
            return $validation;
        }
        
        $userId = $validation['user_id'];
        $newPasswordHash = hashPassword($newPassword);
        
        $updated = $this->db->update(
            'admin_users',
            ['password_hash' => $newPasswordHash],
            'id = ?',
            [$userId]
        );
        
        if ($updated) {
            $this->db->delete(
                'settings',
                'setting_key = ?',
                ['password_reset_token_' . $userId]
            );
            
            writeLog("Password reset via token", 'info', null, $userId);
            return ['success' => true, 'message' => 'Şifre başarıyla sıfırlandı'];
        }
        
        return ['success' => false, 'message' => 'Şifre sıfırlanamadı'];
    }
}
?>