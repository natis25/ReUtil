<?php
require_once(__DIR__ . '/../../../core/Conexion1.php');

class InspeccionCliente
{
    public static function guardar($data)
    {
        $conn = Conexion::conectar();

        // Establecer valores por defecto si no vienen en $data
        $data['caja_enviada'] = $data['caja_enviada'] ?? 0;
        $data['revision'] = $data['revision'] ?? 0;
        $data['reciclaje'] = $data['reciclaje'] ?? 0;
        $data['monto_final'] = $data['monto_final'] ?? 0;
        $data['fecha_inspeccion'] = $data['fecha_inspeccion'] ?? date('Y-m-d H:i:s');
        $data['id_empleado'] = $data['id_empleado'] ?? null; // Asegurate que se asigne si es obligatorio
        $data['id_cliente'] = $data['id_cliente'] ?? null;

        // Consulta SQL
        $sql = "INSERT INTO inspeccion 
            (descripcion,
            monto_ofrecido,
            trasferencia,
            caja_enviada,
            reciclaje, 
            monto_final,
            revision,
            fecha_inspeccion, 
            Empleado_id_empleado,  
            Dispositivo_id_dispositivo, 
            Cliente_id_cliente,
            Sucursal_id_sucursal) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['ok' => false, 'error' => 'Error al preparar: ' . $conn->error];
        }

        $stmt->bind_param(
            "sdiiiiissiii", // 12 parámetros
            $data['descripcion'],
            $data['monto_ofrecido'],
            $data['trasferencia'],
            $data['caja_enviada'],
            $data['reciclaje'],
            $data['monto_final'],
            $data['revision'],
            $data['fecha_inspeccion'],
            $data['id_empleado'],
            $data['id_dispositivo'],
            $data['id_cliente'],
            $data['id_sucursal']
        );

        file_put_contents('debug_data.log', print_r($data, true));

        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $conn->close();
            return ['ok' => false, 'error' => 'Error al ejecutar: ' . $error];
        }

        $idInsertado = $stmt->insert_id;
        $stmt->close();
        $conn->close();

        return [
            'ok' => true,
            'id_inspeccion' => $idInsertado
        ];
    }

    public static function obtenerNombreDispositivo($id_dispositivo)
    {
        $conn = Conexion::conectar();

        $sql = "SELECT d.modelo as nombre, m.marca as marca, t.nombre_tipo as tipo 
                FROM dispositivo d
                JOIN tipo_dispositivo t ON d.Tipo_dispositivo_id_tipo = t.id_tipo
                JOIN marca m ON d.Marca_id_marca = m.id_marca
                WHERE d.id_dispositivo = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['error' => 'Error al preparar consulta'];
        }

        $stmt->bind_param("i", $id_dispositivo);

        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $conn->close();
            return ['error' => 'Error al ejecutar: ' . $error];
        }

        $result = $stmt->get_result();
        $info = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        if (!$info) {
            return ['error' => 'Dispositivo no encontrado'];
        }

        return $info;
    }
}
