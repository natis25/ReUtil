<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/controller/CriterioController.php');

$controller = new CriterioController();
$controller->handleRequest($_SERVER['REQUEST_METHOD'], $_GET);
