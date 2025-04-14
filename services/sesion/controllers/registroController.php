<?php
include_once('../model/RegistroModel.php');

class RegistroController {
  public function registrar($nombre, $correo, $celular, $direccion, $contrasena, $fecha) {
    $modelo = new RegistroModel();
    $resultado = $modelo->registrarCliente($nombre, $correo, $celular, $direccion, $contrasena, $fecha);

    if ($resultado === "ok") {
      echo "✅ Usuario registrado con éxito.";
    } elseif ($resultado === "existe") {
      echo "⚠️ El correo ya está en uso.";
    } else {
      echo "❌ Error al registrar usuario.";
    }
  }
}
?>
