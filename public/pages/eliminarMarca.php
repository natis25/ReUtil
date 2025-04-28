<?php
header('Content-Type: application/json');

// Ruta corregida
$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/marca/marcaApi.php';

$id_marca = $_POST['id_marca'];

$data = ['id_marca' => $id_marca];

// Ruta corregida
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'DELETE',
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

header('Location: marcas.php');
exit;
?>