<?php
require_once(__DIR__ . '/../controller/guardarInspeccionClienteController.php');
header('Content-Type: application/json');

// Validar que los campos esenciales lleguen
if (
    empty($_POST['descripcion']) ||
    empty($_POST['monto_ofrecido']) ||
    empty($_POST['trasferencia']) ||
    empty($_POST['id_dispositivo']) ||
    empty($_POST['id_sucursal'])
) {
    echo json_encode(['exito' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Preparar datos para guardar
$data = [
    'descripcion'    => $_POST['descripcion'],
    'monto_ofrecido' => $_POST['monto_ofrecido'],
    'trasferencia'   => ($_POST['trasferencia'] === 'true' || $_POST['trasferencia'] == 1) ? 1 : 0,
    'id_dispositivo' => $_POST['id_dispositivo'],
    'id_sucursal'    => $_POST['id_sucursal'],
    'caja_enviada'   => 0,
    'revision'       => 0
];

$resultado  = guardarInspeccionClienteController::ejecutar($data);

if ($resultado) {
    echo json_encode(['exito' => true]);
} else {
    echo json_encode(['exito' => false, 'error' => 'Error al guardar en la base de datos']);
}
