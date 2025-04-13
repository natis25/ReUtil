<!-- services/sesion/api/login.php -->
<?php
include_once('../../../core/conexion.php');
include_once('../controllers/sesionController.php');

$email = $_POST['email'];
$password = $_POST['password'];
$tipoUsuario = $_POST['tipo_usuario'];

// Creamos el controlador y le pasamos los datos
$sesionController = new SesionController();
$sesionController->iniciarSesion($email, $password, $tipoUsuario);
?>
