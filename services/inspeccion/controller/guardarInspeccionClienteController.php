<?php
require_once(__DIR__ . '/../model/inspeccionCliente.php');

class guardarInspeccionClienteController
{
    public static function ejecutar($data)
    {
        $resultado = inspeccionCliente::guardar($data);

        if (isset($resultado['ok']) && $resultado['ok']) {
            $dispositivo_info = inspeccionCliente::obtenerNombreDispositivo($data['id_dispositivo']);
            return [
                'exito' => true,
                'nombre_dispositivo' => $dispositivo_info['nombre'],
                'tipo_dispositivo' => $dispositivo_info['tipo']
            ];
        }

        return ['exito' => false, 'error' => $resultado['error'] ?? 'No se pudo guardar la inspección'];
    }
}

