<?php
header('Content-Type: application/json');

// Configuración manual para verificar conexión
$host = 'localhost';
$user = 'root';
$pass = ''; // Tu contraseña de MySQL (si tiene)
$dbname = 'reeutil';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT id_dispositivo, modelo FROM dispositivo LIMIT 10";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    exit;
}

$dispositivos = [];

while ($row = $result->fetch_assoc()) {
    $dispositivos[] = [
        'id' => $row['id_dispositivo'],
        'nombre' => $row['modelo']
    ];
}

echo json_encode(['dispositivos' => $dispositivos]);
