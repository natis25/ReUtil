<?php
header('Content-Type: application/json');

$id_criterio = $_POST['id_criterio'] ?? null;
$nombre_criterio = $_POST['nombre_criterio'];

$data = [
    'id_criterio' => $id_criterio,
    'nombre_criterio' => $nombre_criterio
];

$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterio/api.php';
$method = empty($id_criterio) ? 'POST' : 'PUT';

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => $method,
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

header('Location: criterios.php');
exit;
?>