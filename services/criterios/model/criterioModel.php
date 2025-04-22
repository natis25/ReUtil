<?php

class CriterioModel {
  private $conn;

  // 1. Recibe la conexión por inyección de dependencias
  public function __construct($conexion) {
    $this->conn = $conexion;
  }

  // Cambiar el nombre del método a 'obtenerCriterios()'
  public function obtenerCriterios() {
    $query = "SELECT * FROM criterio";
    $result = $this->conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC); // Devuelve todos los criterios en un arreglo asociativo
  }


  public function crearCriterio($nombre) {
    $stmt = $this->conn->prepare("INSERT INTO criterio (nombre_criterio) VALUES (?)");
    $stmt->bind_param("s", $nombre);
    return $stmt->execute();
  }

  public function actualizarCriterio($id, $nuevoNombre) {
    $stmt = $this->conn->prepare("UPDATE criterio SET nombre_criterio = ? WHERE id_criterio = ?");
    $stmt->bind_param("si", $nuevoNombre, $id);
    return $stmt->execute();
  }

  public function eliminarCriterio($id) {
    $stmt = $this->conn->prepare("DELETE FROM criterio WHERE id_criterio = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
?>