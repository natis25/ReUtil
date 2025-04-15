<?php
require_once(__DIR__ . '/../../../core/Database.php');

class DispositivoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $query = "SELECT d.*, m.marca as nombre_marca, t.tipo as nombre_tipo 
                  FROM dispositivo d
                  LEFT JOIN marca m ON d.Marca_id_marca = m.id_marca
                  LEFT JOIN tipo_dispositivo t ON d.Tipo_dispositivo_id_tipo = t.id_tipo";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT d.*, m.marca as nombre_marca, t.tipo as nombre_tipo 
                  FROM dispositivo d
                  LEFT JOIN marca m ON d.Marca_id_marca = m.id_marca
                  LEFT JOIN tipo_dispositivo t ON d.Tipo_dispositivo_id_tipo = t.id_tipo
                  WHERE d.id_dispositivo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($modelo, $tipo_dispositivo_id, $marca_id) {
        $stmt = $this->conn->prepare("INSERT INTO dispositivo (modelo, Tipo_dispositivo_id_tipo, Marca_id_marca) VALUES (?, ?, ?)");
        return $stmt->execute([$modelo, $tipo_dispositivo_id, $marca_id]);
    }

    public function update($id, $modelo, $tipo_dispositivo_id, $marca_id) {
        $stmt = $this->conn->prepare("UPDATE dispositivo SET modelo = ?, Tipo_dispositivo_id_tipo = ?, Marca_id_marca = ? WHERE id_dispositivo = ?");
        return $stmt->execute([$modelo, $tipo_dispositivo_id, $marca_id, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM dispositivo WHERE id_dispositivo = ?");
        return $stmt->execute([$id]);
    }
}