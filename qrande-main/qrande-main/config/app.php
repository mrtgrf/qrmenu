<?php
define('APP_CONFIG', [
    'name' => 'Restaurant QR System',
    'version' => '1.0.0',
    'url' => 'https://qrmenu.yimamedia.com',
    'timezone' => 'Europe/Istanbul',
    'debug' => true,
    'session_name' => 'restaurant_qr_session',
    'upload_path' => 'uploads/',
    'max_file_size' => 2048000, // 2MB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif']
]);
date_default_timezone_set(APP_CONFIG['timezone']);
if (APP_CONFIG['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
ini_set('session.name', APP_CONFIG['session_name']);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // HTTPS için 1 yapın
ini_set('session.use_strict_mode', 1);
?>