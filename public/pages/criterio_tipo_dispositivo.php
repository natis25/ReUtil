<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para hacer requests HTTP robustos
function fetchApiData($url) {
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
$criterios_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterios/api.php';
$criterios_response = fetchApiData($criterios_url);
$criterios = json_decode($criterios_response, true) ?: [];

// 2. Obtener tipos de dispositivo
$tipos_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/tipo/tipoApi.php';
$tipos_response = fetchApiData($tipos_url);
$tipos_dispositivo = json_decode($tipos_response, true) ?: [];

// 3. Obtener asignaciones existentes (nuevo endpoint)
$asignaciones_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterio_tipo/api.php';
$asignaciones_response = fetchApiData($asignaciones_url);

// Formato esperado para asignaciones:
// [{
//   "id": 1,
//   "id_criterio": 1,
//   "id_tipo_dispositivo": 1,
//   "nombre_criterio": "Batería en buen estado",
//   "nombre_tipo": "Smartphone"
// }]
$asignaciones = json_decode($asignaciones_response, true) ?: [];

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

        <a class="nav-opctions" href="criterios.php" style="font-weight: bold;">Asignar Criterios</a>
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
                                onclick="confirmarEliminarAsignacion(<?= $asignacion['id'] ?>)">
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
                    <form id="asignacionForm" action="guardar_asignacion.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tipo_dispositivo_id" class="form-label">Tipo de Dispositivo</label>
                                <select class="form-select" id="tipo_dispositivo_id" name="tipo_dispositivo_id" required>
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
                            <button class="buttonG" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funciones para el modal de asignación
        function abrirModalAsignacion(asignacion) {
            const modal = document.getElementById('asignacionModal');
            const titulo = document.getElementById('modalTituloAsignacion');
            
            if (asignacion) {
                titulo.textContent = 'Editar Asignación';
                document.getElementById('tipo_dispositivo_id').value = asignacion.tipo_dispositivo_id;
                document.getElementById('criterio_id').value = asignacion.criterio_id;
            } else {
                titulo.textContent = 'Nueva Asignación';
                document.getElementById('asignacionForm').reset();
            }
            
            modal.style.display = 'block';
        }

        function cerrarModalAsignacion() {
            document.getElementById('asignacionModal').style.display = 'none';
        }

        function confirmarEliminarAsignacion(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta asignación?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'eliminar_asignacion.php';
                
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