<?php

require_once(__DIR__ . '/../../../core/Conexion.php');

class sucursal
{
    public static function obtenerTodas()
    {
        $conn = Conexion::conectar();

        $sql = "SELECT id_sucursal as id, nombre_sucursal as nombre, direccion FROM sucursal";
        $result = $conn->query($sql);

        $sucursales = [];
        while ($row = $result->fetch_assoc()) {
            $sucursales[] = $row;
        }

        $conn->close();
        return $sucursales;
    }
}
