<?php
require_once __DIR__.'/../../../core/Database.php';

class CriterioTipoModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAllWithDetails() {
        try {
            $query = "SELECT 
                        ct.Criterio_id_criterio AS id_criterio,
                        ct.Tipo_dispositivo_id_tipo AS id_tipo,
                        c.nombre_criterio, 
                        t.nombre_tipo,
                        CONCAT(ct.Criterio_id_criterio, '-', ct.Tipo_dispositivo_id_tipo) AS id_relacion
                     FROM criterio_tipo_dispositivo ct
                     JOIN criterio c ON ct.Criterio_id_criterio = c.id_criterio
                     JOIN tipo_dispositivo t ON ct.Tipo_dispositivo_id_tipo = t.id_tipo";
            
            $stmt = $this->conn->query($query);
            
            if (!$stmt) {
                throw new Exception("Error en la consulta: " . implode(" ", $this->conn->errorInfo()));
            }
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Verificar si hay resultados
            if (empty($resultados)) {
                error_log("No se encontraron relaciones criterio-tipo");
            }
            
            return $resultados;
            
        } catch (Exception $e) {
            error_log("Error en getAllWithDetails(): " . $e->getMessage());
            return []; // Retorna array vacío en caso de error
        }
    }

    public function create($id_criterio, $id_tipo_dispositivo) {
        try {
            // Verificar si ya existe la relación
            $query = "SELECT 1 FROM criterio_tipo_dispositivo 
                     WHERE Criterio_id_criterio = ? AND Tipo_dispositivo_id_tipo = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id_criterio, $id_tipo_dispositivo]);
            
            if ($stmt->fetch()) {
                throw new Exception('Esta combinación ya existe');
            }
    
            // Insertar nueva relación
            $query = "INSERT INTO criterio_tipo_dispositivo 
                     (Criterio_id_criterio, Tipo_dispositivo_id_tipo) 
                     VALUES (?, ?)";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id_criterio, $id_tipo_dispositivo]);
            
        } catch (PDOException $e) {
            error_log("Error en CriterioTipoModel::create(): " . $e->getMessage());
            return false;
        }
    }

    public function delete($criterio_id_criterio,$tipo_id_tipo) {
        $query = "DELETE FROM criterio_tipo_dispositivo WHERE `criterio_tipo_dispositivo`.`Criterio_id_criterio` = ? AND `criterio_tipo_dispositivo`.`Tipo_dispositivo_id_tipo` = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$criterio_id_criterio,$tipo_id_tipo]);
    }
}