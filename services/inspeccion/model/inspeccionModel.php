<?php
require_once(__DIR__ . '/../../../core/Database.php');

class InspeccionModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Inspeccion");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Inspeccion WHERE id_inspeccion = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Insertando campos requeridos en el CREATE
    public function create($data) {
        $sql = "INSERT INTO Inspeccion (
                    descripcion,
                    monto_ofrecido,
                    transferencia,
                    fecha_inscripcion,
                    Dispositivo_id_dispositivo,
                    Cliente_id_cliente,
                    Sucursal_id_sucursal
                ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['descripcion'],
            $data['monto_ofrecido'],
            $data['transferencia'],
            $data['fecha_inscripcion'],
            $data['Dispositivo_id_dispositivo'],
            $data['Cliente_id_cliente'],
            $data['Sucursal_id_sucursal']
        ]);
    }

    public function updateCaja($id) {
        $sql = "UPDATE Inspeccion SET caja_enviada = NOT caja_enviada WHERE id_inspeccion = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    // ✅ Solo se actualizan los campos que mencionaste
    public function updateInpeccion($id, $data) {
        $sql = "UPDATE Inspeccion SET 
                    reciclaje = ?, 
                    monto_final = ?, 
                    revision = Not revision, 
                    Empleado_id_empleado = ?
                WHERE id_inspeccion = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['reciclaje'],
            $data['monto_final'],
            $data['Empleado_id_empleado'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Inspeccion WHERE id_inspeccion = ?");
        return $stmt->execute([$id]);
    }
}
