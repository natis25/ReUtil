<?php
require_once(__DIR__ . '/../../../core/Database.php');

class ClienteModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Cliente");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Cliente WHERE id_cliente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO Cliente (nombre_cliente, correo, celular, direccion, contrasena, fecha_registro) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$data['nombre_cliente'], $data['correo'], $data['celular'], $data['direccion'], $data['contrasena'], $data['fecha_registro']]);
    }

    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE Cliente SET nombre_cliente = ? , correo = ?, celular = ?, direccion = ?, contrasena = ? WHERE id_cliente = ?");
        return $stmt->execute([$data['nombre_cliente'], $data['correo'], $data['celular'], $data['direccion'], $data['contrasena'], $data['id_cliente']]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Cliente WHERE id_cliente = ?");
        return $stmt->execute([$id]);
    }
}
