<?php

require_once(__DIR__ . '/../../../core/Conexion1.php');

class Criterio
{
    public static function obtenerCriteriosPorTipo($tipo_dispositivo_id)
    {
        $conn = Conexion::conectar();

        // AQUI hacemos el JOIN correcto según tu base real
        $stmt = $conn->prepare("
            SELECT c.id_criterio, c.nombre_criterio
            FROM criterio c
            INNER JOIN criterio_tipo_dispositivo ctd 
                ON c.id_criterio = ctd.Criterio_id_criterio
            WHERE ctd.Tipo_dispositivo_id_tipo = ?
        ");
        $stmt->bind_param("i", $tipo_dispositivo_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $criterios = [];

        while ($row = $result->fetch_assoc()) {
            $criterios[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $criterios;
    }
}
