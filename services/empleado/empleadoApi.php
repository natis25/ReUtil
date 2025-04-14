<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/EmpleadoController.php');

$controller = new ClienteController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);
