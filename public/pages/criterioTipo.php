<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para hacer requests HTTP robustos
function fetchApiData($url)
{
    $context = stream_context_create([
        'http' => ['ignore_errors' => true]
    ]);

    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    return $response;
}

// 1. Obtener criterios
$criterios_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Reeutil/services/criterios/api.php';
$criterios_response = fetchApiData($criterios_url);
$criterios = json_decode($criterios_response, true) ?: [];

// 2. Obtener tipos de dispositivo
$tipos_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Reeutil/services/tipo/tipoApi.php';
$tipos_response = fetchApiData($tipos_url);
$tipos_dispositivo = json_decode($tipos_response, true) ?: [];

// 3. Obtener asignaciones existentes - URL CORREGIDA
$asignaciones_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Reeutil/services/criterioTipo/api.php';

// Debug: Verificar la URL que se está usando
error_log("Intentando acceder a: " . $asignaciones_url);

$asignaciones_response = fetchApiData($asignaciones_url);

// Debug: Verificar la respuesta cruda
error_log("Respuesta del API: " . substr($asignaciones_response, 0, 200));

if ($asignaciones_response === false) {
    $error = error_get_last();
    error_log("Error al obtener asignaciones: " . $error['message']);
    $asignaciones = [];
} else {
    $asignaciones = json_decode($asignaciones_response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Error decodificando JSON: " . json_last_error_msg());
        error_log("Respuesta cruda: " . $asignaciones_response);
        $asignaciones = [];
    }
}
// Debug (opcional)
echo "<!-- Criterios: " . count($criterios) . " registros -->\n";
echo "<!-- Tipos: " . count($tipos_dispositivo) . " registros -->\n";
echo "<!-- Asignaciones: " . count($asignaciones) . " registros -->";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM de Criterios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/style.css">
</head>

<body>
    <nav>
        <div class="logo">
            <a href="inicio.php">
                <img src="images/eco.png" alt="ReeUtil Logo">
            </a>
        </div>
        <a class="titulo" href="inicio.php">ReeUtil</a>
        <div class="nav-links">
            <a class="nav-opctions" href="inicio.php">Inicio</a>
            <a class="nav-opctions" href="criterios.php">Criterios</a>

        </div>
        <a href="login.html">
            <button class="btn-login">Iniciar Sesión</button>
        </a>
    </nav>

    <div class="container">
        <h1>Asignación de Criterios a Tipos de Dispositivo</h1>
        <br>

        <button class="btn-login" onclick="abrirModalAsignacion(null)">
            Nueva Asignación
        </button>

        <a class="nav-opctions" href="criterios.php" style="font-weight: bold;">Gestionar Criterios</a>
        <br><br>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tipo de Dispositivo</th>
                        <th>Criterio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asignaciones as $asignacion): ?>
                        <tr>
                            <td><?= htmlspecialchars($asignacion['nombre_tipo'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($asignacion['nombre_criterio'] ?? 'N/A') ?></td>
                            <td class="actions-column">
                                <button class="btn btn-sm btn-danger"
                                    onclick="confirmarEliminarAsignacion(<?= $asignacion['nombre_criterio'] ?>)">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para nueva asignación -->
        <div id="asignacionModal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="" id="modalTituloAsignacion">Nueva Asignación</h2>
                        <button type="button" class="btn-close" onclick="cerrarModalAsignacion()"></button>
                    </div>
                    <!-- Cambia el formulario para usar fetch() en lugar de submit tradicional -->
                    <form id="asignacionForm">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tipo_dispositivo_id" class="form-label">Tipo de Dispositivo</label>
                                <select class="form-select" id="tipo_dispositivo_id" name="tipo_dispositivo_id"
                                    required>
                                    <option value="">Seleccionar tipo</option>
                                    <?php foreach ($tipos_dispositivo as $tipo): ?>
                                        <option value="<?= $tipo['id_tipo'] ?>">
                                            <?= htmlspecialchars($tipo['nombre_tipo']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="criterio_id" class="form-label">Criterio</label>
                                <select class="form-select" id="criterio_id" name="criterio_id" required>
                                    <option value="">Seleccionar criterio</option>
                                    <?php foreach ($criterios as $criterio): ?>
                                        <option value="<?= $criterio['id_criterio'] ?>">
                                            <?= htmlspecialchars($criterio['nombre_criterio']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="buttonC" onclick="cerrarModalAsignacion()">
                                Cancelar
                            </button>
                            <button type="button" class="buttonG" onclick="guardarAsignacion()">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>

    <script>
        // Funciones para el modal de asignación
        // Función mejorada para abrir el modal
        function abrirModalAsignacion(asignacion) {
            const modal = document.getElementById('asignacionModal');
            const titulo = document.getElementById('modalTituloAsignacion');

            if (asignacion) {
                // Modo edición
                titulo.textContent = 'Editar Asignación';
                document.getElementById('tipo_dispositivo_id').value = asignacion.id_tipo_dispositivo;
                document.getElementById('criterio_id').value = asignacion.id_criterio;
            } else {
                // Modo nueva
                titulo.textContent = 'Nueva Asignación';
                document.getElementById('asignacionForm').reset();
            }

            modal.style.display = 'block';
        }
        // Función para guardar (actualizada)
        function guardarAsignacion() {
            const form = document.getElementById('asignacionForm');
            const formData = {
                criterio_id: form.criterio_id.value,
                tipo_dispositivo_id: form.tipo_dispositivo_id.value
            };

            // Validación básica
            if (!formData.criterio_id || !formData.tipo_dispositivo_id) {
                alert('Por favor complete todos los campos');
                return;
            }

            fetch('guardarCriterioTipo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Relación guardada con éxito');
                        cerrarModalAsignacion();
                        location.reload(); // Recargar para ver cambios
                    } else {
                        alert('Error: ' + (data.error || 'No se pudo guardar'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión con el servidor');
                });
        }



        function cerrarModalAsignacion() {
            document.getElementById('asignacionModal').style.display = 'none';
        }

        function confirmarEliminarAsignacion(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta asignación?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'eliminarCriterioTipo.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<style>
    .buttonG {
        padding: 10px 20px;
        margin-left: 20px;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 1rem;
        height: 40px;
    }

    .buttonC {
        padding: 10px 20px;
        background-color: rgb(119, 127, 129);
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 1rem;
        height: 40px;
    }

    .buttonC:hover {
        background-color: rgb(79, 80, 80);
    }

    .nav-links a {
        margin-right: 15px;
    }
</style>