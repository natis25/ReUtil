<!-- services/sesion/controllers/SesionController.php -->
<?php
include_once('../model/sesionModel.php');
session_start();

class SesionController {
  public function iniciarSesion($email, $password, $tipoUsuario) {
    // Validar credenciales
    $sesionModel = new SesionModel();
    $usuario = $sesionModel->validarUsuario($email, $password, $tipoUsuario);

    if ($usuario) {
      // Usuario autenticado
      $_SESSION['usuario'] = $usuario;
      $_SESSION['tipo'] = $tipoUsuario;

      // Mostrar el mensaje según el tipo de usuario
      if ($tipoUsuario == 'cliente') {
        header("Location: ../../../public/pages/menuCliente.html");
        exit();
      } else {
        header("Location: ../../../public/pages/menuEmpleado.html");
        exit();
      }
    } else {
      // Credenciales incorrectas
      echo "Credenciales incorrectas.";
    }
  }
}
?>
