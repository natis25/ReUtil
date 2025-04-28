<?php

require_once(__DIR__ . '/../../../core/Conexion1.php');

class Dispositivo
{
    public static function obtenerPorTipo($tipo_dispositivo_id)
    {
        $conn = Conexion::conectar();

        $stmt = $conn->prepare("SELECT id_dispositivo, modelo AS nombre FROM dispositivo WHERE Tipo_dispositivo_id_tipo = ?");
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

    public static function obtenerMarcasPorTipo($tipo_dispositivo_id)
    {
        $conn = Conexion::conectar();

        $stmt = $conn->prepare("SELECT marca.id_marca, marca.marca 
            FROM dispositivo
            INNER JOIN marca ON dispositivo.Marca_id_marca = marca.id_marca
            WHERE dispositivo.Tipo_dispositivo_id_tipo = ?");

        if (!$stmt) {
            throw new Exception("Error preparando la consulta obtenerMarcasPorTipo: " . $conn->error);
        }

        $stmt->bind_param("i", $tipo_dispositivo_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $marcas = [];

        while ($row = $result->fetch_assoc()) {
            $marcas[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $marcas;
    }


    public static function obtenerModelosPorMarcaYTipo($marca_id, $tipo_dispositivo_id)
    {
        $conn = Conexion::conectar();

        // Prepara la consulta
        $stmt = $conn->prepare("SELECT id_dispositivo, modelo AS nombre FROM dispositivo
            WHERE Marca_id_marca = ? AND Tipo_dispositivo_id_tipo = ?");

        if (!$stmt) {
            throw new Exception("Error preparando la consulta obtenerModelosPorMarcaYTipo: " . $conn->error);
        }

        // Asigna los parámetros
        $stmt->bind_param("ii", $marca_id, $tipo_dispositivo_id);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene los resultados
        $result = $stmt->get_result();
        $modelos = [];

        while ($row = $result->fetch_assoc()) {
            $modelos[] = $row;
        }

        // Cierra los recursos
        $stmt->close();
        $conn->close();

        // Devuelve los modelos encontrados
        return $modelos;
    }

}
