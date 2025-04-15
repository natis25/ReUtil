<?php
require_once(__DIR__ . '/../model/tipoDispositivoModel.php');

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
                if (!isset($json['nombre_tipo'])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'error' => 'Campo nombre_tipo requerido']);
                    break;
                }
                $result = $this->model->create($json['nombre_tipo']);
                echo json_encode(['success' => $result]);
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['aceptar']) && $json['aceptar']) {
                    $result = $this->model->aceptar($json['id_tipo']);
                    echo json_encode(['success' => $result]);
                } else {
                    $result = $this->model->update($json['id_tipo'], $json['nombre_tipo']);
                    echo json_encode(['success' => $result]);
                }
                break;

            case 'DELETE':
                $json = json_decode(file_get_contents("php://input"), true);
                $result = $this->model->delete($json['id_tipo']);
                echo json_encode(['success' => $result]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}