<?php
// Configuración de CORS para desarrollo
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Obtener el servicio solicitado
$service = $_GET['service'] ?? null;

// Validar que se haya especificado un servicio
if (!$service) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'No se especificó el servicio',
        'available_services' => [
            'tipo_dispositivo',
            'marca',
            'usuarios',
            'productos'
        ]
    ]);
    exit;
}

// Directorio base de los servicios
$servicesDir = __DIR__ . '/../services/';

// Mapeo de servicios a sus archivos (todos con guión bajo)
$serviceMap = [
    'tipodispositivo' => 'tipoDispositivo/tipoDispositivoApi.php',
    'marca' => 'marca/api.php',
    'usuarios' => 'usuarios/api.php',
    'productos' => 'productos/api.php'
];

// Verificar si el servicio existe
if (!array_key_exists($service, $serviceMap)) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Servicio no encontrado',
        'available_services' => array_keys($serviceMap)
    ]);
    exit;
}

// Construir la ruta completa al archivo del servicio
$servicePath = $servicesDir . $serviceMap[$service];

// Verificar que el archivo del servicio exista
if (!file_exists($servicePath)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'El servicio existe pero no está implementado correctamente',
        'path' => $servicePath
    ]);
    exit;
}

// Incluir el archivo del servicio
try {
    require_once $servicePath;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al cargar el servicio',
        'details' => $e->getMessage()
    ]);
}