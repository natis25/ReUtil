<?php
require_once __DIR__.'/../model/CriterioTipoModel.php';

class CriterioTipoController {
    private $model;

    public function __construct() {
        $this->model = new CriterioTipoModel();
    }

    public function handleRequest($method) {
        try {
            switch ($method) {
                case 'GET':
                    $this->getAllRelations();
                    break;
                case 'POST':
                    $this->createRelation();
                    break;
                case 'DELETE':
                    $this->deleteRelation();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Método no permitido']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function getAllRelations() {
        $relations = $this->model->getAllWithDetails();
        echo json_encode($relations);
    }

    private function createRelation() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['id_criterio']) || empty($data['id_tipo_dispositivo'])) {
            throw new Exception('Datos incompletos');
        }

        $success = $this->model->create(
            (int)$data['id_criterio'],
            (int)$data['id_tipo_dispositivo']
        );

        echo json_encode(['success' => $success]);
    }

    private function deleteRelation() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['id'])) {
            throw new Exception('ID no proporcionado');
        }

        $success = $this->model->delete((int)$data['id_criterio'],(int)$data['id_tipo']);
        echo json_encode(['success' => $success]);
    }
}