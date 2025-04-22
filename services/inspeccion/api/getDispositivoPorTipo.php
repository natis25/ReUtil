<?php
require_once(__DIR__ . '/../controller/dispositivoController.php');

// Responder con JSON
header('Content-Type: application/json');

// Validar si se recibió el ID del tipo
if (!isset($_POST['tipo_dispositivo_id'])) {
    echo json_encode(['error' => 'Falta tipo_dispositivo_id', 'dispositivos' => []]);
    exit;
}

$tipo = $_POST['tipo_dispositivo_id'];

// Usar el controlador directamente (ya se encarga de acceder a la BD)
$dispositivos = dispositivoController::obtenerPorTipo($tipo);

// Enviar respuesta
echo json_encode(['dispositivos' => $dispositivos]);
