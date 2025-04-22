<?php
header('Content-Type: application/json');

$url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterio/api.php';

$id_criterio = $_POST['id_criterio'];

$data = ['id_criterio' => $id_criterio];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'DELETE',
        'content' => json_encode($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

header('Location: criterios.php');
exit;
?>