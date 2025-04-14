<?php
require_once(__DIR__ . '/../../../core/Database.php');

class EmpleadoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Empleado");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Empleado WHERE id_empleado = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO Empleado (nombre_empleado, correo, celular, contrasena, fecha_registro, Sucursal_id_sucursal) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$data['nombre_empleado'], $data['correo'], $data['celular'], $data['contrasena'], $data['fecha_registro'], $data['Sucursal_id_sucursal']]);
    }

    public function update($id, $empleado) {
        $stmt = $this->conn->prepare("UPDATE Empleado SET Empleado = ? WHERE id_empleado = ?");
        return $stmt->execute([$empleado, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Empleado WHERE id_empleado = ?");
        return $stmt->execute([$id]);
    }
}
