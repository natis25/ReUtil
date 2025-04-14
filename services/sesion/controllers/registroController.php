<?php
include_once('../model/RegistroModel.php');

class RegistroController {
  public function registrar($tipo, $nombre, $correo, $celular, $contrasena, $fecha, $direccion = null, $sucursal = null) {
    $model = new RegistroModel();
    $tabla = $tipo === 'empleado' ? 'empleado' : 'cliente';
  
    if ($model->correoExiste($correo, $tabla)) {
      echo "El correo ya está registrado como $tipo.";
      return false;
    }
  
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
  
    if ($tipo === 'empleado') {
      return $model->registrarEmpleado($nombre, $correo, $celular, $hash, $fecha, $sucursal);
    } else {
      return $model->registrarCliente($nombre, $correo, $celular, $direccion, $hash, $fecha);
    }
  }
  
}
?>
