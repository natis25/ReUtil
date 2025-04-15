<?php
header('Content-Type: application/json');

$id_marca = $_POST['id_marca'] ?? null;
$marca = $_POST['marca'];

$data = [
    'id_marca' => $id_marca,
    'marca' => $marca
];

// Ruta corregida
$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/marca/marcaApi.php';
$method = empty($id_marca) ? 'POST' : 'PUT';

// Configurar la solicitud
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => $method,
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Redirigir de vuelta al listado
header('Location: marcas.php');
exit;
?>