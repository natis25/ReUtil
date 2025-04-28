<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/TipoController.php');

$controller = new TipoController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);