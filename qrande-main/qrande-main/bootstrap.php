<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/includes/autoloader.php';

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';

require_once __DIR__ . '/includes/functions.php';

startSecureSession();

try {
    $db = Database::getInstance();
    $db->query("SELECT 1");
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

generateCSRFToken();

$currentLicense = null;
$currentUser = null;

if (isset($_SESSION['license_key'])) {
    $currentLicense = checkLicense($_SESSION['license_key']);
    if (!$currentLicense) {
        destroySession();
        redirect('login.php');
    }
}

if (isset($_SESSION['user_id']) && $currentLicense) {
    $currentUser = $db->fetchOne(
        "SELECT * FROM admin_users WHERE id = ? AND license_id = ?",
        [$_SESSION['user_id'], $currentLicense['id']]
    );
}
?>