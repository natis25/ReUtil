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
}