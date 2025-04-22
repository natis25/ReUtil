<?php
require_once(__DIR__ . '/../model/inspeccionModel.php');

class InspeccionController {
    private $model;

    public function __construct() {
        $this->model = new InspeccionModel();
    }

    public function handleRequest($method, $data) {
        switch ($method) {
            case 'GET':
                if (isset($data['empleado_id'])) {
                    echo json_encode($this->model->getByEmpleadoId($data['empleado_id']));
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Se requiere el ID del empleado']);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}