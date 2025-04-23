<?php
header('Content-Type: application/json');
require_once __DIR__.'/../../services/criterioTipo/model/CriterioTipoModel.php'; // Asegúrate que la ruta es correcta

try {
    // Obtener datos JSON del cuerpo de la solicitud
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Validación de datos
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Formato JSON inválido');
    }
    
    if (empty($data['criterio_id']) || empty($data['tipo_dispositivo_id'])) {
        throw new Exception('Debes seleccionar un criterio y un tipo de dispositivo');
    }

    // Sanitización
    $id_criterio = (int)$data['criterio_id'];
    $id_tipo = (int)$data['tipo_dispositivo_id'];

    // Crear relación
    $model = new CriterioTipoModel();
    $resultado = $model->create($id_criterio, $id_tipo);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Relación creada exitosamente',
            'data' => [
                'id_relacion' => $id_criterio.'-'.$id_tipo,
                'id_criterio' => $id_criterio,
                'id_tipo_dispositivo' => $id_tipo
            ]
        ]);
    } else {
        throw new Exception('No se pudo crear la relación (¿ya existe?)');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}