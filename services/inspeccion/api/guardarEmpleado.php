<?php

require_once(__DIR__ . '/../../../controller/inspeccionEmpleadoController.php');

// Obtener los datos de reciclaje, monto final y fecha inspección
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cliente_id'])) {
        $cliente_id = $_GET['cliente_id'];
        $controller = new inspeccionEmpleadoController();
        $controller->obtenerDatos($cliente_id);
    } else {
        echo json_encode(['error' => 'Falta el ID del cliente']);
    }
}

// Actualizar los datos de reciclaje, monto final y fecha inspección
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cliente_id'], $_POST['reciclaje'], $_POST['monto_final'], $_POST['fecha_inspeccion'])) {
        $cliente_id = $_POST['cliente_id'];
        $reciclaje = $_POST['reciclaje']  === 'true' ? 1 : 0;
        $monto_final = $_POST['monto_final'];
        $fecha_inspeccion = $_POST['fecha_inspeccion'];
        
        $controller = new inspeccionEmpleadoController();
        $controller->actualizarDatos($cliente_id, $reciclaje, $monto_final, $fecha_inspeccion);
    } else {
        echo json_encode(['error' => 'Faltan parámetros']);
    }
}
