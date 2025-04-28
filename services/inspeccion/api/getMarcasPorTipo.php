<?php

require_once(__DIR__ . '/../controller/dispositivoController.php');

// Responder siempre en JSON
header('Content-Type: application/json');

// Usar try-catch global
try {
    if (!isset($_POST['tipo_dispositivo_id'])) {
        echo json_encode(['error' => 'Falta tipo_dispositivo_id', 'marcas' => []]);
        exit;
    }

    $tipo_id = $_POST['tipo_dispositivo_id'];

    // Validar que no esté vacío
    if (empty($tipo_id)) {
        echo json_encode(['error' => 'tipo_dispositivo_id vacío', 'marcas' => []]);
        exit;
    }

    // Obtener marcas desde el controlador
    $marcas = dispositivoController::obtenerMarcasPorTipo($tipo_id);

    // Devolver datos
    echo json_encode(['marcas' => $marcas]);
    
} catch (Throwable $e) {
    echo json_encode(['error' => 'Error interno en el servidor', 'detalle' => $e->getMessage()]);
}
