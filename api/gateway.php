<?php
$service = $_GET['service'] ?? null;

// Habilitar CORS para desarrollo
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

switch ($service) {
    case "marca":
        include __DIR__ . "/../services/marca/api.php";
        break;
    case 'usuarios':
        include __DIR__ . '/../services/usuarios/api.php';
        break;
    case 'productos':
        include __DIR__ . '/../services/productos/api.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Servicio no encontrado']);
}