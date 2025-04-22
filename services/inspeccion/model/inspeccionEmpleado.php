<?php

require_once(__DIR__ . '/../../../core/Conexion1.php');

class Inspeccion
{
    public static function obtenerDatosCliente($cliente_id)
    {
        $conn = Conexion::conectar();

        $sql = "SELECT i.reciclaje, i.monto_final, i.fecha_inspeccion
                FROM inspeccion i
                WHERE i.Cliente_id_cliente = ?";

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
        $datos = [];

        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $datos;
    }

    public static function actualizarDatosCliente($cliente_id, $reciclaje, $monto_final, $fecha_inspeccion)
    {
        $conn = Conexion::conectar();

        $sql = "UPDATE inspeccion
                SET reciclaje = ?, monto_final = ?, fecha_inspeccion = ?
                WHERE Cliente_id_cliente = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return ['error' => 'Error al preparar consulta'];
        }

        $stmt->bind_param("dsdi", $reciclaje, $monto_final, $fecha_inspeccion, $cliente_id);

        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $conn->close();
            return ['error' => 'Error al ejecutar: ' . $error];
        }

        $stmt->close();
        $conn->close();

        return ['ok' =>true];
    }
}