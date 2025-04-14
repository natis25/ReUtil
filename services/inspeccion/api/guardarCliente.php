<?php
require_once(__DIR__ . '/../controller/guardarInspeccionClienteController.php');
header('Content-Type: application/json');

if (!isset( $_POST['descripcion'], $_POST['monto_ofrecido'], $_POST['trasferencia'], $_POST['id_dispositivo'], $_POST['id_sucursal'])) {
    echo json_encode(['exito' => false, 'error' => 'Datos incompletos']);
    exit;
}

$data = [
    'descripcion' => $_POST['descripcion'] ?? '',
    'monto_ofrecido' => $_POST['monto_ofrecido'],
    'trasferencia' => $_POST['trasferencia'] === 'true' ? 1 : 0,
    'id_dispositivo' => $_POST['id_dispositivo'],
    'id_sucursal' => $_POST['id_sucursal'],
    'caja_enviada' => 0,
    'revision' => 0
];

$exito = guardarInspeccionClienteController::ejecutar($data);
echo json_encode($exito);
