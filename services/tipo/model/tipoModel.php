<?php
require_once(__DIR__ . '/../../../core/Database.php');

class TipoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM tipo_dispositivo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAccepted() {
        $stmt = $this->conn->query("SELECT * FROM tipo_dispositivo WHERE aceptado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tipo_dispositivo WHERE id_tipo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre_tipo) {
        $stmt = $this->conn->prepare("INSERT INTO tipo_dispositivo (nombre_tipo, aceptado) VALUES (?, 1)");
        return $stmt->execute([$nombre_tipo]);
    }

    public function update($id, $nombre_tipo, $aceptado) {
        $stmt = $this->conn->prepare("UPDATE tipo_dispositivo SET nombre_tipo = ?, aceptado = ? WHERE id_tipo = ?");
        return $stmt->execute([$nombre_tipo, $aceptado, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM tipo_dispositivo WHERE id_tipo = ?");
        return $stmt->execute([$id]);
    }
}