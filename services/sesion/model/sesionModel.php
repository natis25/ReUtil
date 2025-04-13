<!-- services/sesion/model/SesionModel.php -->
<?php
class SesionModel {
  private $conn;

  public function __construct() {
    // Conexión a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $basedatos = "reeutil";

    $conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $this->conn = $conexion;

  }

  public function validarUsuario($email, $password, $tipoUsuario) {
    // Consultar la base de datos dependiendo del tipo de usuario
    if ($tipoUsuario == 'cliente') {
      $query = "SELECT * FROM cliente WHERE correo = ? AND contrasena = ?";
    } else {
      $query = "SELECT * FROM empleado WHERE correo = ? AND contrasena = ?";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      return $result->fetch_assoc(); // Retorna el usuario si existe
    } else {
      return false; // No se encontró el usuario
    }
  }
}
?>
