<?php
require_once(__DIR__ . '/../../../core/Database.php');

class InspeccionModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getByEmpleadoId($empleadoId) {
        $stmt = $this->conn->prepare("SELECT 
                descripcion, 
                monto_ofrecido, 
                trasferencia, 
                reciclaje, 
                monto_final, 
                fecha_inspeccion 
            FROM inspeccion 
            WHERE Empleado_id_empleado = ?");
        $stmt->execute([$empleadoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInspeccionesPendientes($sucursalId) {
        $stmt = $this->conn->prepare("SELECT 
                descripcion, 
                monto_ofrecido, 
                id_inspeccion,
                caja_enviada 
            FROM inspeccion 
            WHERE Sucursal_id_sucursal = ? AND revision = 0");
        $stmt->execute([$sucursalId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function caja($id) {
        // Primero obtener el estado actual
        $stmt = $this->conn->prepare("SELECT caja_enviada FROM inspeccion WHERE id_inspeccion = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Invertir el estado (0->1 o 1->0)
        $newStatus = $current['caja_enviada'] ? 0 : 1;
        
        // Actualizar el estado
        $stmt = $this->conn->prepare("UPDATE inspeccion SET caja_enviada = ? WHERE id_inspeccion = ?");
        $success = $stmt->execute([$newStatus, $id]);
        
        return $success;
    }
}