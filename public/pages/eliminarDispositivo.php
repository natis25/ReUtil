<?php
header('Content-Type: application/json');

$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/dispositivo/dispositivoApi.php';
$id_dispositivo = $_POST['id_dispositivo'];

$data = ['id_dispositivo' => $id_dispositivo];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'DELETE',
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

header('Location: dispositivos.php');
exit;
?>