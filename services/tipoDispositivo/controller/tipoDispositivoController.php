<?php
require_once(__DIR__ . '/../model/tipoDispositivoModel.phpModel.php');

class TipoDispositivoController {
    private $model;

    public function __construct() {
        $this->model = new TipoDispositivoModel();
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
                echo json_encode($this->model->create($json['tipo_dispositivo']));
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                echo json_encode($this->model->update($json['id_tipo'], $json['tipo_despositivo']));
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
