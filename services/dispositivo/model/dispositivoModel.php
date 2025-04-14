<?php
require_once(__DIR__ . '/../../../core/Database.php');

class DispositivoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM Dispositivo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Dispositivo WHERE id_dispositivo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO Dispositivo (modelo, Tipo_dispositivo_id_tipo, Marca_id_marca) VALUES (?,?,?)");
        return $stmt->execute([$data['modelo'], $data['Tipo_dispositivo_id_tipo'], $data['Marca_id_marca']]);
    }

    public function update($id, $dispositivo) {
        $stmt = $this->conn->prepare("UPDATE Dispositivo SET Dispositivo = ? WHERE id_dispositivo = ?");
        return $stmt->execute([$dispositivo, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM Dispositivo WHERE id_dispositivo = ?");
        return $stmt->execute([$id]);
    }
}
