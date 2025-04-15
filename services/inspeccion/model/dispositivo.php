<?php

require_once(__DIR__ . '/../../../core/Conexion1.php');

class dispositivo
{
    public static function obtenerPorTipo($tipo_dispositivo_id)
    {
        $conn = Conexion::conectar();

        // Corregir nombre de tabla y campo
        $stmt = $conn->prepare("SELECT id_dispositivo, modelo as nombre FROM dispositivo WHERE Tipo_dispositivo_id_tipo = ?");
        $stmt->bind_param("i", $tipo_dispositivo_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $dispositivos = [];

        while ($row = $result->fetch_assoc()) {
            $dispositivos[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $dispositivos;
    }
}
