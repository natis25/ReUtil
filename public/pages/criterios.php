<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// URL de la API de criterios
$api_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/criterios/api.php';


$context = stream_context_create([
    'http' => [
        'ignore_errors' => true
    ]
]);

$api_response = @file_get_contents($api_url, false, $context);

// Fallback con cURL si file_get_contents falla
if ($api_response === false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $api_response = curl_exec($ch);
    curl_close($ch);
}

if ($api_response === false) {
    die("Error al conectar con la API. Verifica que el servicio esté activo.");
}

$criterios = json_decode($api_response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error en formato JSON: ".json_last_error_msg().
        "<br>Respuesta cruda:<pre>".htmlspecialchars($api_response)."</pre>");
}

$criterios = is_array($criterios) ? $criterios : [];
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
            <a class="nav-opctions" href="#">Conoce más de ReeUtil</a>
        </div>
        <a href="login.html">
            <button class="btn-login">Iniciar Sesión</button>
        </a>
    </nav>
    <div class="container">
        <h1>Gestión de Criterios</h1>
        <br>
        
        <button class="btn-login" onclick="abrirModal(null)">Agregar Nuevo Criterio</button>
        <a class="nav-opctions" href="criterio_tipo_dispositivo.php" style="font-weight: bold;">Asignar Criterios</a>

        <br>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Criterio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($criterios as $criterio): ?>
                    <tr>
                        <td><?= htmlspecialchars($criterio['nombre_criterio']) ?></td>
                        <td class="actions-column">
                            <button 
                                class="btn btn-sm btn-warning me-2"
                                onclick="abrirModal(<?= htmlspecialchars(json_encode($criterio)) ?>)"
                            >
                                Editar
                            </button>
                            <button 
                                class="btn btn-sm btn-danger"
                                onclick="confirmarEliminar(<?= $criterio['id_criterio'] ?>)"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Modal para agregar/editar -->
        <div id="criterioModal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="" id="modalTitulo">Agregar Criterio</h2>
                        <button 
                            type="button" 
                            class="btn-close" 
                            onclick="cerrarModal()"
                        ></button>
                    </div>
                    <form id="criterioForm" action="guardarCriterio.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="id_criterio" name="id_criterio" value="">
                            <div class="mb-3">
                                <label for="nombre_criterio" class="form-label">Nombre del Criterio</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nombre_criterio"
                                    name="nombre_criterio"
                                    required
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button 
                                type="button" 
                                class="buttonC"
                                onclick="cerrarModal()"
                            >
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
        function abrirModal(criterio) {
            const modal = document.getElementById('criterioModal');
            const titulo = document.getElementById('modalTitulo');
            
            if (criterio) {
                titulo.textContent = 'Editar Criterio';
                document.getElementById('id_criterio').value = criterio.id_criterio;
                document.getElementById('nombre_criterio').value = criterio.nombre_criterio;
            } else {
                titulo.textContent = 'Agregar Criterio';
                document.getElementById('id_criterio').value = '';
                document.getElementById('nombre_criterio').value = '';
            }
            
            modal.style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('criterioModal').style.display = 'none';
        }

        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este criterio?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'eliminarCriterio.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_criterio';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
</style>