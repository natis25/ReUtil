<?php
require_once(__DIR__ . '/../controller/dispositivoController.php');

// Responder con JSON
header('Content-Type: application/json');

// Verificar que los parámetros llegaron correctamente
if (!isset($_POST['tipo_dispositivo_id']) ) {
    //error_log("Error: Faltan parámetros 'tipo_dispositivo_id'.");
    echo json_encode(['error' => 'Faltan datos de tipos', 'dispositivos' => []]);
    exit;
} else if (!isset($_POST['marca_dispositivo_id'])) {
    //error_log("Error: Faltan parámetros 'marca_dispositivo_id'.");
    echo json_encode(['error' => 'Faltan datos de marcas', 'dispositivos' => []]);
    exit;
}

// Obtener los valores de los parámetros
$tipo_id = $_POST['tipo_dispositivo_id'];
$marca_id = $_POST['marca_dispositivo_id'];

// Registrar los parámetros recibidos para depuración
error_log("Parametros recibidos - tipo_dispositivo_id: $tipo_id, marca_dispositivo_id: $marca_id");

// Usar el controlador directamente para obtener los dispositivos
try {
    $dispositivos = dispositivoController::obtenerModelosPorMarcaYTipo($marca_id, $tipo_id);

    // Registrar el resultado de la consulta
    if (empty($dispositivos)) {
        error_log("No se encontraron dispositivos para tipo_id: $tipo_id y marca_id: $marca_id.");
    } else {
        error_log("Dispositivos encontrados: " . count($dispositivos));
    }

    // Enviar la respuesta con los dispositivos
    echo json_encode(['dispositivos' => $dispositivos]);
} catch (Exception $e) {
    // Captura de errores y muestra detalles
    error_log("Error al obtener dispositivos: " . $e->getMessage());
    echo json_encode(['error' => 'Error al obtener dispositivos', 'dispositivos' => []]);
}
