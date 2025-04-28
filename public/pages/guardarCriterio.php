<?php
header('Content-Type: application/json');

try {
    // 1. Validación básica
    if (empty($_POST['nombre_criterio'])) {
        throw new Exception('El nombre del criterio es requerido');
    }

    // 2. Preparar datos
    $data = [
        'id_criterio' => $_POST['id_criterio'] ?? null,
        'nombre_criterio' => trim($_POST['nombre_criterio'])
    ];

    // 3. Configurar la solicitud
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterios/api.php';
    $method = empty($data['id_criterio']) ? 'POST' : 'PUT';

    $options = [
        'http' => [
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'method' => $method,
            'content' => json_encode($data),
            'ignore_errors' => true // Para leer la respuesta incluso con errores HTTP
        ]
    ];

    // 4. Enviar la solicitud
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // 5. Manejar errores HTTP
    if ($response === false) {
        $error = error_get_last();
        throw new Exception('Error al conectar con la API: ' . ($error['message'] ?? 'Desconocido'));
    }

    // 6. Verificar respuesta JSON
    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Respuesta API no válida: ' . json_last_error_msg());
    }

    // 7. Redireccionar con éxito
    header('Location: criterios.php');
    exit;

} catch (Exception $e) {
    // 8. Manejo de errores
    error_log('Error en guardarCriterio.php: ' . $e->getMessage());
    
    // Redireccionar con mensaje de error
    header('Location: criterios.php?error=' . urlencode($e->getMessage()));
    exit;
}