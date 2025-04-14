<?php
include_once('../../../core/conexion.php');

class RegistroModel {
  private $conn;

  public function __construct() {
    global $conexion;
    $this->conn = $conexion;
  }

  public function correoExiste($correo) {
    $query = "SELECT id_cliente FROM cliente WHERE correo = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0; // true si existe, false si no
  }

  public function registrarCliente($nombre, $correo, $celular, $direccion, $contrasena, $fecha) {
    $query = "INSERT INTO cliente (nombre_cliente, correo, celular, direccion, contrasena, fecha_registro)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssssss", $nombre, $correo, $celular, $direccion, $contrasena, $fecha);
    return $stmt->execute();
  }
  

  public function registrarEmpleado($nombre, $correo, $celular, $contrasena, $fecha, $id_sucursal) {
    $query = "INSERT INTO empleado (nombre_empleado, correo, celular, contrasena, fecha_registro, Sucursal_id_sucursal)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("sssssi", $nombre, $correo, $celular, $contrasena, $fecha, $id_sucursal);
    return $stmt->execute();
  }
}
?>
