<?php
// Incluir el controlador
include_once('../../services/criterios/controllers/criterioController.php');

// Crear una instancia del controlador
$controller = new CriterioController();

// Obtener los criterios desde la base de datos
$criterios = $controller->obtenerCriterios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Criterios</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }

    h2 {
      color: #2c3e50;
    }

    form, table {
      margin-top: 20px;
      width: 100%;
      max-width: 600px;
    }

    input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      margin-bottom: 15px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      padding: 10px 20px;
      background-color: #27ae60;
      color: white;
      border: none;
      cursor: pointer;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    .acciones button {
      margin-right: 5px;
      padding: 5px 10px;
      cursor: pointer;
    }

    .editar {
      background-color: #f39c12;
      color: white;
      border: none;
    }

    .eliminar {
      background-color: #c0392b;
      color: white;
      border: none;
    }
  </style>
</head>
<body>

  <!-- Formulario para agregar un nuevo criterio -->
  <h2>¿Cómo se llama este criterio?</h2>
  <form action="../../services/criterios/api/criterios_api.php" method="POST">
    <input type="text" name="nombre_criterio" placeholder="Ej: Criterio de evaluación" required>
    <input type="hidden" name="accion" value="crear">
    <input type="submit" value="Guardar Criterio">
  </form>

  <!-- Lista de criterios -->
  <h2>Lista de Criterios</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre del Criterio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Mostrar los criterios obtenidos del controlador -->
      <?php foreach ($criterios as $criterio): ?>
        <tr>
          <td><?= $criterio['id_criterio'] ?></td>
          <td><?= htmlspecialchars($criterio['nombre_criterio']) ?></td>
          <td class="acciones">
            <!-- Formulario para eliminar un criterio -->
            <form action="../../services/criterios/api/criterios_api.php" method="POST" style="display:inline;">
              <input type="hidden" name="accion" value="eliminar">
              <input type="hidden" name="id" value="<?= $criterio['id_criterio'] ?>">
              <button class="eliminar" type="submit">Eliminar</button>
            </form>

            <!-- Si quieres agregar edición, puedes hacerlo aquí -->
            <!-- Por ejemplo, un formulario similar para actualizar el criterio -->
            <form action="../../services/criterios/api/criterios_api.php" method="POST" style="display:inline;">
              <input type="hidden" name="accion" value="actualizar">
              <input type="hidden" name="id" value="<?= $criterio['id_criterio'] ?>">
              <input type="text" name="nombre_criterio" value="<?= $criterio['nombre_criterio'] ?>" required>
              <input type="submit" value="Actualizar">
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
