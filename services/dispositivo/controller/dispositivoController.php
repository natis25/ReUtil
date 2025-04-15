<?php
require_once(__DIR__ . '/../model/DispositivoModel.php');

class DispositivoController {
    private $model;

    public function __construct() {
        $this->model = new DispositivoModel();
    }

    public function handleRequest($method, $data) {
        switch ($method) {
            case 'GET':
                if (isset($data['id'])) {
                    echo json_encode($this->model->getById($data['id']));
                } else {
                    echo json_encode($this->model->getAll());
                }
                break;

case 'POST':
    $json = json_decode(file_get_contents("php://input"), true);
    $success = $this->model->create($json['modelo'], $json['tipo_dispositivo_id'], $json['marca_id']);
    echo json_encode(['success' => $success]);
    break;
            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->update(
                    $json['id_dispositivo'],
                    $json['modelo'],
                    $json['tipo_dispositivo_id'],
                    $json['marca_id']
                ));
                break;

            case 'DELETE':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->delete($json['id_dispositivo']));
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}