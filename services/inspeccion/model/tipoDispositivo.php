<?php

require_once(__DIR__ . '/../../../core/Conexion.php');

class tipoDispositivo
{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();

        $sql = "SELECT id_tipo as id, nombre_tipo as nombre, aceptado FROM tipo_dispositivo";
        $result = $conn->query($sql);

        $tipos = [];
        while ($row = $result->fetch_assoc()) {
            $tipos[] = $row;
        }

        $conn->close();
        return $tipos;
    }
}

