<?php
require_once(__DIR__ . '/../../../core/Database.php');

class SucursalModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Sucursal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Sucursal WHERE id_sucursal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO Sucursal (nombre_sucursal, telefono, direccion) VALUES (?, ?, ?)");
        return $stmt->execute([$data['nombre_sucursal'], $data['telefono'], $data['direccion']]);
    }

    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE Sucursal SET nombre_sucursal = ?, telefono = ?, direccion = ? WHERE id_sucursal = ?");
        return $stmt->execute([$data['nombre_sucursal'], $data['telefono'], $data['direccion'], $data['id_sucursal']]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Sucursal WHERE id_sucursal = ?");
        return $stmt->execute([$id]);
    }
}
