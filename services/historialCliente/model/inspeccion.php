<?php

require_once(__DIR__ . '/../../../core/Conexion.php');

class Inspeccion
{
    public static function obtenerPorCliente($cliente_id)
    {
        $conn = Conexion::conectar();

        $sql = "SELECT * FROM inspeccion WHERE Cliente_id_cliente = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return ['error' => 'Error al preparar consulta'];
        }

        $stmt->bind_param("i", $cliente_id);

        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $conn->close();
            return ['error' => 'Error al ejecutar: ' . $error];
        }

        $result = $stmt->get_result();
        $inspecciones = [];

        while ($row = $result->fetch_assoc()) {
            $inspecciones[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $inspecciones;
    }
}
