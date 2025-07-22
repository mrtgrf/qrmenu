<?php
require_once __DIR__ . '/../bootstrap.php';
$router = new Router();
require_once __DIR__ . '/../routes/web.php';
$router->run();
?>