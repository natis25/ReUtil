<?php
header('Content-Type: application/json');
require_once __DIR__.'/controller/CriterioTipoController.php';

$controller = new CriterioTipoController();
$controller->handleRequest($_SERVER['REQUEST_METHOD']);
?>