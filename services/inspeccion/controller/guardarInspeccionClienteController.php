<?php
require_once(__DIR__ . '/../model/inspeccionCliente.php');

class guardarInspeccionClienteController
{
    public static function ejecutar($data)
    {
        $resultado = InspeccionCliente::guardar($data);

        if (isset($resultado['ok']) && $resultado['ok']) {
            $dispositivo_info = InspeccionCliente::obtenerNombreDispositivo($data['id_dispositivo']);
            return [
                'exito' => true,
                'id_inspeccion' => $resultado['id_inspeccion'],
                'nombre_dispositivo' => $dispositivo_info['nombre'] ?? '',
                'tipo_dispositivo' => $dispositivo_info['tipo'] ?? '',
                'marca_dispositivo' => $dispositivo_info['marca'] ?? ''
            ];
        }

        return ['exito' => false, 'error' => $resultado['error'] ?? 'No se pudo guardar la inspección'];
    }
}
