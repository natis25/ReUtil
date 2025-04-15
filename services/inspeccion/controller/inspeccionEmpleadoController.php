<?php

require_once(__DIR__ . '/../../../model/inspeccionEmpleado.php');
header('Content-Type: application/json');

class inspeccionEmpleadoController
{
    public function obtenerDatos($cliente_id)
    {
        $datos = Inspeccion::obtenerDatosCliente($cliente_id);

        echo json_encode(['datos' => $datos]);
    }

    public function actualizarDatos($cliente_id, $reciclaje, $monto_final, $fecha_inspeccion)
    {
        $resultado = Inspeccion::actualizarDatosCliente($cliente_id, $reciclaje, $monto_final, $fecha_inspeccion);

        if (isset($resultado['error'])) {
            echo json_encode(['ok' => false, 'error' => $resultado['error']]);
        } else {
            echo json_encode(['ok' => true]);
        }
    }
}
