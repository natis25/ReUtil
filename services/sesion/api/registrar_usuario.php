<?php
include_once('../controllers/registroController.php');

// Verificar si llegan los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipo = $_POST['tipo_usuario'];
  $nombre = $_POST['nombre_cliente'];
  $correo = $_POST['correo'];
  $celular = $_POST['celular'];
  $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
  $contrasena = $_POST['contrasena'];
  $fecha = date('Y-m-d');
  $sucursal = isset($_POST['sucursal']) ? intval($_POST['sucursal']) : null;

  $controller = new RegistroController();
  $resultado = $controller->registrar($tipo, $nombre, $correo, $celular, $direccion, $contrasena, $fecha, $sucursal);

  if ($resultado) {
    echo "Registro exitoso como $tipo.";
  } else {
    echo "Error al registrar.";
  }
}
?>
