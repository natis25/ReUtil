<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ReeUtil/core/conexion.php');

$ruta = $_SERVER['DOCUMENT_ROOT'] . '/ReeUtil/core/conexion.php';
echo "Buscando en: " . $ruta . "<br>";

if (file_exists($ruta)) {
    echo "✅ Archivo encontrado!";
    require_once($ruta);
} else {
    die("❌ Archivo NO encontrado. Verifica que exista en: " . $ruta);
}

class CriterioController {
  private $model;

  public function __construct() {
    // Obtiene la conexión del Singleton
    $conexion = Database::getInstance();
    // Inyecta la conexión al modelo
    $this->model = new CriterioModel($conexion);
  }

  public function obtenerCriterios() {
    return $this->model->obtenerCriterios();
  }

  public function crear($nombre) {
    return $this->model->crearCriterio($nombre);
  }

  public function actualizar($id, $nuevoNombre) {
    return $this->model->actualizarCriterio($id, $nuevoNombre);
  }

  public function eliminar($id) {
    return $this->model->eliminarCriterio($id);
  }
}
?>