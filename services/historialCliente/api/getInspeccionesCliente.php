<?php

require_once(__DIR__ . '/../model/inspeccion.php');

// Forzar cliente_id a 1
$cliente_id = 1;

if (!$cliente_id) {
    echo json_encode(['error' => 'Falta el ID del cliente']);
    exit;
}

$datos = inspeccion::obtenerPorCliente($cliente_id);
echo json_encode(['inspecciones' => $datos]);
