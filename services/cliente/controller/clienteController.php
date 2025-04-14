<?php
require_once(__DIR__ . '/../model/ClienteModel.php');

class ClienteController {
    private $model;

    public function __construct() {
        $this->model = new ClienteModel();
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
                if (isset($json['nombre_cliente'], $json['correo'], $json['celular'], $json['direccion'], $json['contrasena'], $json['fecha_registro'])) {
                    $clientData = [
                        'nombre_cliente' => $json['nombre_cliente'],
                        'correo' => $json['correo'],
                        'celular' => $json['celular'],
                        'direccion' => $json['direccion'],
                        'contrasena' => $json['contrasena'],
                        'fecha_registro' => $json['fecha_registro']
                    ];
                    echo json_encode($this->model->create($clientData));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Todos los campos son requeridos: nombre_cliente, correo, celular, direccion, contrasena, fecha_registro"]);
                }
                break;

            case 'PUT':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['id_cliente'], $json['nombre_cliente'], $json['correo'], $json['celular'], $json['direccion'], $json['contrasena'])) {
                    $clientData = [
                        'id_cliente' => $json['id_cliente'],
                        'nombre_cliente' => $json['nombre_cliente'],
                        'correo' => $json['correo'],
                        'celular' => $json['celular'],
                        'direccion' => $json['direccion'],
                        'contrasena' => $json['contrasena']
                    ];
                    echo json_encode($this->model->update($clientData));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Todos los campos son requeridos: id_cliente, nombre_cliente, correo, celular, direccion, contrasena"]);
                }
                break;

            case 'DELETE':
                $json = json_decode(file_get_contents("php://input"), true);
                if (isset($json['id_cliente'])) {
                    echo json_encode($this->model->delete($json['id_cliente']));
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "El campo id_cliente es requerido"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}