<?php
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = generateToken();
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
function startSecureSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function destroySession() {
    session_destroy();
    session_start();
}
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
function checkLicense($licenseKey) {
    $db = Database::getInstance();
    $license = $db->fetchOne(
        "SELECT * FROM licenses WHERE license_key = ? AND is_active = 1",
        [$licenseKey]
    );
    
    if (!$license) {
        return false;
    }
    $currentDate = date('Y-m-d');
    if ($currentDate > $license['end_date']) {
        return false;
    }
    
    return $license;
}
function uploadFile($file, $uploadDir = 'uploads/') {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    $fileType = $file['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if ($fileSize > APP_CONFIG['max_file_size']) {
        return false;
    }
    if (!in_array($fileExtension, APP_CONFIG['allowed_extensions'])) {
        return false;
    }
    $newFileName = uniqid() . '.' . $fileExtension;
    $uploadPath = $uploadDir . $newFileName;
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        return $newFileName;
    }
    
    return false;
}
function url($path = '') {
    return APP_CONFIG['url'] . '/' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}
function formatDate($date, $format = 'd.m.Y H:i') {
    return date($format, strtotime($date));
}
function formatPrice($price) {
    return number_format($price, 2, ',', '.') . ' ₺';
}
function writeLog($message, $type = 'info', $licenseId = null, $userId = null) {
    $db = Database::getInstance();
    $data = [
        'license_id' => $licenseId,
        'user_id' => $userId,
        'log_type' => $type,
        'action' => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
    ];
    
    $db->insert('system_logs', $data);
}
function generateOrderNumber() {
    return 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
}
function generateQRCodeUrl($tableId, $licenseKey) {
    return url("table/{$tableId}?license={$licenseKey}");
}

?>