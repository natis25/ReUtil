<?php
require_once(__DIR__ . '/../controller/tipoDispositivoController.php');

$tipos = tipoDispositivoController::obtenerTipos();

echo json_encode(['tipos' => $tipos]);
