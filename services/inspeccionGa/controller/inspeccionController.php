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
                }
                elseif (isset($data['sucursal_id'])) {
                    echo json_encode($this->model->getInspeccionesPendientes($data['sucursal_id']));
                } 
                else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Se requiere el ID del empleado o sucursal']);
                }
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['id_inspeccion'])) {
                    $result = $this->model->caja($json['id_inspeccion']);
                    echo json_encode([
                        'success' => $result,
                        'message' => $result ? 'Estado de caja actualizado' : 'Error al actualizar'
                    ]);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Se requiere el ID de la inspección']);
                }
                break;
                
            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}