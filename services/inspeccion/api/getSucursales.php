<?php
require_once(__DIR__ . '/../controller/sucursalController.php');

$sucursales = sucursalController::obtenerSucursales();

echo json_encode(['sucursales' => $sucursales]);
