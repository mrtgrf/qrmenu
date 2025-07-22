<?php
define('DB_CONFIG', [
    'host' => 'localhost',
    'dbname' => 'u616870669_qr_system',
    'username' => 'u616870669_qrsystem',
    'password' => '514698aAa!',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
]);
?>