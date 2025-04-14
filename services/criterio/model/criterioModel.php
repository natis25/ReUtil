<?php
require_once(__DIR__ . '/../../../core/Database.php');

class CriterioModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Criterio");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Criterio WHERE id_criterio = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($criterio) {
        $stmt = $this->conn->prepare("INSERT INTO Criterio (criterio) VALUES (?)");
        return $stmt->execute([$criterio]);
    }

    public function update($id, $criterio) {
        $stmt = $this->conn->prepare("UPDATE Criterio SET nombre_criterio = ? WHERE id_criterio = ?");
        return $stmt->execute([$criterio, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Criterio WHERE id_criterio = ?");
        return $stmt->execute([$id]);
    }
}
