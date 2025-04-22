<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/DispositivoController.php');

$controller = new DispositivoController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);