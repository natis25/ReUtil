<?php
include_once('../../../core/conexion.php');

class CriterioModel {
  private $conn;

  public function __construct() {
    global $conexion;
    $this->conn = $conexion;
  }

  public function obtenerCriterios($id, $nombre, $correo, $celular, $direccion, $contrasena, $fecha) {
    $query = "INSERT INTO clientes (id_cliente, nombre_cliente, correo, celular, direccion, contrasena, fecha_registro)
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("sssssss", $id, $nombre, $correo, $celular, $direccion, $contrasena, $fecha);

    return $stmt->execute(); // Devuelve true o false
  }
}
?>