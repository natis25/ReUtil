<?php
require_once(__DIR__ . '/../../../core/Database.php');

class TipoDispositivoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM tipo_dispositivo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tipo_dispositivo WHERE id_tipo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByAceptado($aceptado) {
        $stmt = $this->conn->prepare("SELECT * FROM tipo_dispositivo WHERE aceptado = ?");
        $stmt->execute([$aceptado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($tipo) {
        $stmt = $this->conn->prepare("INSERT INTO tipo_dispositivo (nombre_tipo, aceptado) VALUES (?, false)");
        return $stmt->execute([$tipo]);
    }

    public function update($id, $tipo) {
        $stmt = $this->conn->prepare("UPDATE tipo_dispositivo SET nombre_tipo = ? WHERE id_tipo = ?");
        return $stmt->execute([$tipo, $id]);
    }

    public function aceptar($id) {
        // Primero obtenemos el estado actual
        $stmt = $this->conn->prepare("SELECT aceptado FROM tipo_dispositivo WHERE id_tipo = ?");
        $stmt->execute([$id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$current) {
            return false;
        }
        
        // Cambiamos al estado contrario
        $nuevoEstado = !$current['aceptado'];
        
        $stmt = $this->conn->prepare("UPDATE tipo_dispositivo SET aceptado = ? WHERE id_tipo = ?");
        return $stmt->execute([$nuevoEstado, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM tipo_dispositivo WHERE id_tipo = ?");
        return $stmt->execute([$id]);
    }
}