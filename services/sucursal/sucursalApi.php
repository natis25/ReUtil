<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/SucursalController.php');

$controller = new SucursalController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);
