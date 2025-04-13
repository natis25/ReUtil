<?php
require_once(__DIR__ . '/../../../core/Database.php');

class TipoDispositivoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Tipo_dispositivo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Tipo_dispositivo WHERE id_tipo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($marca) {
        $stmt = $this->conn->prepare("INSERT INTO Tipo_dispositivo (tipo_dispositivo) VALUES (?)");
        return $stmt->execute([$marca]);
    }

    public function update($id, $marca) {
        $stmt = $this->conn->prepare("UPDATE Tipo_dispositivo SET Tipo_dispositivo = ? WHERE id_tipo = ?");
        return $stmt->execute([$marca, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Tipo_dispositivo WHERE id_tipo = ?");
        return $stmt->execute([$id]);
    }
}
