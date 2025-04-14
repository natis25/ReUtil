<?php
include_once('../../core/conexion.php');

// Obtener sucursales desde la base de datos
$sucursales = [];
$resultado = $conexion->query("SELECT id_sucursal, nombre_sucursal FROM sucursal");
while ($fila = $resultado->fetch_assoc()) {
  $sucursales[] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
</head>
<body>
  <h2>Registro de Usuario</h2>
  <form action="../../services/sesion/api/registrar_usuario.php" method="POST">

    <label for="tipo_usuario">Tipo de usuario:</label><br>
    <select name="tipo_usuario" id="tipo_usuario" required>
      <option value="cliente">Cliente</option> 
      <option value="empleado">Empleado</option>
    </select>
    <br><br>

    <div id="sucursal_container" style="display: none;">
      <label for="sucursal">Sucursal:</label><br>
      <select name="sucursal" id="sucursal">
        <option value="">Selecciona una sucursal</option>
        <?php foreach($sucursales as $sucursal): ?>
          <option value="<?= $sucursal['id_sucursal'] ?>">
            <?= $sucursal['nombre_sucursal'] ?>
          </option>
        <?php endforeach; ?>
      </select>
      <br><br>
    </div>

    <label>Nombre:</label><br>
    <input type="text" name="nombre_cliente" required><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Celular:</label><br>
    <input type="text" name="celular" required><br><br>

    <label>Dirección:</label><br>
    <input type="text" name="direccion" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br><br>

    <input type="submit" value="Registrarse">
  </form>

  <script>
    const tipoUsuario = document.getElementById('tipo_usuario');
    const sucursalContainer = document.getElementById('sucursal_container');

    tipoUsuario.addEventListener('change', function() {
      sucursalContainer.style.display = (this.value === 'empleado') ? 'block' : 'none';
    });
  </script>
</body>
</html>
