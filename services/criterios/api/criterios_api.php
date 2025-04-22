<?php
include_once('../controllers/criterioController.php');

$controller = new CriterioController();

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
  case 'crear':
    $nombre = $_POST['nombre_criterio'] ?? null;
    echo $nombre && $controller->crear($nombre)
      ? "Criterio creado correctamente."
      : "Error al crear criterio o nombre faltante.";
    break;

  case 'listar':
    $criterios = $controller->obtenerCriterios();
    header('Content-Type: application/json');
    echo json_encode($criterios);
    break;

  case 'editar':
    $id = $_POST['id_criterio'] ?? null;
    $nuevoNombre = $_POST['nombre_criterio'] ?? null;
    echo ($id && $nuevoNombre && $controller->actualizar($id, $nuevoNombre))
      ? "Criterio actualizado correctamente."
      : "Error al actualizar criterio o datos incompletos.";
    break;

  case 'eliminar':
    $id = $_POST['id_criterio'] ?? null;
    echo ($id && $controller->eliminar($id))
      ? "Criterio eliminado correctamente."
      : "Error al eliminar criterio o ID no enviado.";
    break;

  default:
    echo "Acción no válida o no especificada.";
    break;
}
?>
