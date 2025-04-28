<?php
require_once(__DIR__ . '/../../../core/Database.php');

class MarcaModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Marca");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Marca WHERE id_marca = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($marca) {
        $stmt = $this->conn->prepare("INSERT INTO Marca (marca) VALUES (?)");
        return $stmt->execute([$marca]);
    }

    public function update($id, $marca) {
        $stmt = $this->conn->prepare("UPDATE Marca SET marca = ? WHERE id_marca = ?");
        return $stmt->execute([$marca, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Marca WHERE id_marca = ?");
        return $stmt->execute([$id]);
    }
}
