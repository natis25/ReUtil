<?php
require_once(__DIR__ . '/../../../core/Database.php');

class CriterioModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM criterio");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM criterio WHERE id_criterio = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre_criterio) {
        $stmt = $this->conn->prepare("INSERT INTO criterio (nombre_criterio) VALUES (?)");
        $stmt->execute([$nombre_criterio]);
        return $this->conn->lastInsertId(); // Retorna el ID autoincremental
    }

    public function update($id_criterio, $nombre_criterio) {
        $stmt = $this->conn->prepare("UPDATE criterio SET nombre_criterio = ? WHERE id_criterio = ?");
        return $stmt->execute([$nombre_criterio, $id_criterio]);
    }

    public function delete($id_criterio) {
        $stmt = $this->conn->prepare("DELETE FROM criterio WHERE id_criterio = ?");
        return $stmt->execute([$id_criterio]);
    }
}