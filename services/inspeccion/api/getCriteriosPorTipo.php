<?php

require_once(__DIR__ . '/../controller/criterioController.php');

// Responder siempre en JSON
header('Content-Type: application/json');

// Usar try-catch global
try {
    if (!isset($_POST['tipo_dispositivo_id'])) {
        echo json_encode(['error' => 'Falta tipo_dispositivo_id', 'criterios' => []]);
        exit;
    }

    $tipo_id = $_POST['tipo_dispositivo_id'];

    // Validar que no esté vacío
    if (empty($tipo_id)) {
        echo json_encode(['error' => 'tipo_dispositivo_id vacío', 'criterios' => []]);
        exit;
    }

    // Obtener criterios desde el controlador
    $criterios = criterioController::obtenerCriteriosPorTipo($tipo_id);

    // Devolver datos con el campo correcto
    echo json_encode(['criterios' => $criterios]);

} catch (Throwable $e) {
    echo json_encode(['error' => 'Error interno en el servidor', 'detalle' => $e->getMessage()]);
}
