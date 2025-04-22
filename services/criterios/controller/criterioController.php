<?php
require_once(__DIR__ . '/../model/criterioModel.php');

class CriterioController {
    private $model;

    public function __construct() {
        $this->model = new CriterioModel();
    }

    public function handleRequest($method, $data) {
        try {
            switch ($method) {
                case 'GET':
                    $this->handleGetRequest($data);
                    break;
                case 'POST':
                    $this->handlePostRequest();
                    break;
                case 'PUT':
                    $this->handlePutRequest();
                    break;
                case 'DELETE':
                    $this->handleDeleteRequest();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["error" => "Método no permitido"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    private function handleGetRequest($data) {
        if (isset($data['id_criterio'])) {
            $result = $this->model->getById($data['id_criterio']);
            if (!$result) {
                http_response_code(404);
                echo json_encode(["error" => "Criterio no encontrado"]);
            } else {
                echo json_encode($result);
            }
        } else {
            echo json_encode($this->model->getAll());
        }
    }

    private function handlePostRequest() {
        $json = json_decode(file_get_contents("php://input"), true);
        if (empty($json['nombre_criterio'])) {
            http_response_code(400);
            echo json_encode(["error" => "El campo 'nombre_criterio' es requerido"]);
            return;
        }
        $id = $this->model->create($json['nombre_criterio']);
        http_response_code(201);
        echo json_encode(["success" => true, "id_criterio" => $id]);
    }

    private function handlePutRequest() {
        $json = json_decode(file_get_contents("php://input"), true);
        if (empty($json['id_criterio']) || empty($json['nombre_criterio'])) {
            http_response_code(400);
            echo json_encode(["error" => "Se requieren 'id_criterio' y 'nombre_criterio'"]);
            return;
        }
        $success = $this->model->update($json['id_criterio'], $json['nombre_criterio']);
        echo json_encode(["success" => $success]);
    }

    private function handleDeleteRequest() {
        $json = json_decode(file_get_contents("php://input"), true);
        if (empty($json['id_criterio'])) {
            http_response_code(400);
            echo json_encode(["error" => "El campo 'id_criterio' es requerido"]);
            return;
        }
        $success = $this->model->delete($json['id_criterio']);
        echo json_encode(["success" => $success]);
    }
}