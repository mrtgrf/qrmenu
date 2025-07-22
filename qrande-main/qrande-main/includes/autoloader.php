<?php

spl_autoload_register(function($className) {
    $classFile = __DIR__ . '/../classes/' . strtolower($className) . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
        return;
    }
    
    $classFile = __DIR__ . '/../classes/' . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
        return;
    }
});
?>