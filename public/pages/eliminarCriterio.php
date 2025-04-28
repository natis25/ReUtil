<?php
header('Content-Type: application/json');

try {
    // 1. Validar que recibimos el ID
    if (!isset($_POST['id_criterio']) || empty($_POST['id_criterio'])) {
        throw new Exception('ID de criterio no proporcionado');
    }

    // 2. Preparar datos
    $data = ['id_criterio' => (int)$_POST['id_criterio']]; // Forzamos tipo entero

    // 3. Configurar la solicitud
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterios/api.php';
    
    $options = [
        'http' => [
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'method' => 'DELETE',
            'content' => json_encode($data),
            'ignore_errors' => true // Para capturar respuestas de error
        ]
    ];

    // 4. Enviar la solicitud
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // 5. Manejar errores de conexión
    if ($response === false) {
        $error = error_get_last();
        throw new Exception('Error al conectar con la API: ' . ($error['message'] ?? 'Desconocido'));
    }

    // 6. Verificar respuesta JSON
    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Respuesta API no válida: ' . json_last_error_msg());
    }

    // 7. Verificar si la API reportó éxito
    if (isset($result['success']) && !$result['success']) {
        throw new Exception($result['error'] ?? 'Error al eliminar el criterio');
    }

    // 8. Redireccionar con éxito
    header('Location: criterios.php?success=1');
    exit;

} catch (Exception $e) {
    // 9. Manejo de errores
    error_log('Error en eliminarCriterio.php: ' . $e->getMessage());
    
    // Redireccionar con mensaje de error
    header('Location: criterios.php?error=' . urlencode($e->getMessage()));
    exit;
}