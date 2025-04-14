<?php
require_once(__DIR__ . '/../model/TipoDispositivoModel.php');

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
                } elseif (isset($data['aceptado'])) {
                    echo json_encode($this->model->getByAceptado($data['aceptado']));
                } else {
                    echo json_encode($this->model->getAll());
                }
                break;

            case 'POST':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['tipo_dispositivo'])) {
                    echo json_encode($this->model->create($json['tipo_dispositivo']));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Campo 'tipo_dispositivo' requerido"]);
                }
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['id_tipo'])) {
                    echo json_encode($this->model->update($json['id_tipo']));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Campo 'id_tipo' requerido"]);
                }
                break;

            case 'DELETE':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['id_tipo'])) {
                    echo json_encode($this->model->delete($json['id_tipo']));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Campo 'id_tipo' requerido"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}