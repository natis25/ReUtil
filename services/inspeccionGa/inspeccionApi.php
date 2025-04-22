<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/inspeccionController.php');

$controller = new InspeccionController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);