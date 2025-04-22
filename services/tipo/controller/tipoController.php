<?php
require_once(__DIR__ . '/../model/TipoModel.php');

class TipoController {
    private $model;

    public function __construct() {
        $this->model = new TipoModel();
    }

    public function handleRequest($method, $data) {
        switch ($method) {
            case 'GET':
                if (isset($data['id'])) {
                    echo json_encode($this->model->getById($data['id']));
                } else {
                    // Solo devolvemos tipos aceptados (aceptado = 1)
                    echo json_encode($this->model->getAllAccepted());
                }
                break;

            case 'POST':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->create($json['nombre_tipo']));
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->update(
                    $json['id_tipo'],
                    $json['nombre_tipo'],
                    $json['aceptado']
                ));
                break;

            case 'DELETE':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->delete($json['id_tipo']));
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}