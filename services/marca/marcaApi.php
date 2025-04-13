<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/MarcaController.php');

$controller = new MarcaController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);
