<?php
header('Content-Type: application/json');

$id_dispositivo = $_POST['id_dispositivo'] ?? null;
$modelo = $_POST['modelo'];
$tipo_dispositivo_id = $_POST['tipo_dispositivo_id'];
$marca_id = $_POST['marca_id'];

$data = [
    'id_dispositivo' => $id_dispositivo,
    'modelo' => $modelo,
    'tipo_dispositivo_id' => $tipo_dispositivo_id,
    'marca_id' => $marca_id
];

$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/dispositivo/dispositivoApi.php';
$method = empty($id_dispositivo) ? 'POST' : 'PUT';

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => $method,
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

header('Location: dispositivos.php');
exit;
?>