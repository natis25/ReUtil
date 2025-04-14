<?php
include_once('../controllers/registroController.php');

// Verificar si llegan los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // $id = $_POST['id_cliente'];
  $nombre = $_POST['nombre_cliente'];
  $correo = $_POST['correo'];
  $celular = $_POST['celular'];
  $direccion = $_POST['direccion'];
  $contrasena = $_POST['contrasena'];
  $fecha = date('Y-m-d'); // Fecha actual

  $registroController = new RegistroController();
  $registroController->registrar( $nombre, $correo, $celular, $direccion, $contrasena, $fecha);
}
?>
