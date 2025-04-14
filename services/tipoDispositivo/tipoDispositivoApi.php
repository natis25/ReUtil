<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/tipoDispositivoController.php');

$controller = new TipoDispositivoController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);
