<?php
header('Content-Type: application/json');

// Verificación básica de datos
if(empty($_POST['modelo']) || empty($_POST['tipo_dispositivo_id']) || empty($_POST['marca_id'])) {
    die(json_encode(['error' => 'Datos incompletos']));
}

$data = [
    'id_dispositivo' => $_POST['id_dispositivo'] ?? null,
    'modelo' => $_POST['modelo'],
    'tipo_dispositivo_id' => $_POST['tipo_dispositivo_id'],
    'marca_id' => $_POST['marca_id']
];

$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/dispositivo/dispositivoApi.php';
$method = empty($data['id_dispositivo']) ? 'POST' : 'PUT';

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => $method,
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Redirigir con parámetro de éxito
header('Location: dispositivos.php?success=1');
exit;
?>