<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$api_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/marca/marcaApi.php';

$context = stream_context_create([
    'http' => [
        'ignore_errors' => true
    ]
]);

$api_response = @file_get_contents($api_url, false, $context);

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


echo "<!-- Respuesta API: ".htmlspecialchars(substr($api_response, 0, 500))." -->";


$marcas = json_decode($api_response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error en formato JSON: ".json_last_error_msg().
        "<br>Respuesta cruda:<pre>".htmlspecialchars($api_response)."</pre>");
}


$marcas = is_array($marcas) ? $marcas : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM de Marcas</title>
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
            <a class="nav-opctions" href="#">Cotizar</a>
            <a class="nav-opctions" href="inspeccion.php">Inspecciones</a>
        </div>
        <button class="btn-login">Iniciar Sesión</button>
    </nav>
    <div class="container">
        <h1>Gestionar de Marcas</h1>
        <br>
        
        <button 
            class="btn-login"
            onclick="abrirModal(null)"
        >
            Agregar Nueva Marca
        </button>
        <br>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Marca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marcas as $marca): ?>
                    <tr>
                        <td><?= htmlspecialchars($marca['marca']) ?></td>
                        <td class="actions-column">
                            <button 
                                class="btn btn-sm btn-warning me-2"
                                onclick="abrirModal(<?= htmlspecialchars(json_encode($marca)) ?>)"
                            >
                                Editar
                            </button>
                            <button 
                                class="btn btn-sm btn-danger"
                                onclick="confirmarEliminar(<?= $marca['id_marca'] ?>)"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div id="marcaModal" class="modal-backdrop" style="display: none;">
            <div class="modal-dialog" style="margin: 10% auto;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitulo">Agregar Marca</h5>
                        <button 
                            type="button" 
                            class="btn-close" 
                            onclick="cerrarModal()"
                        ></button>
                    </div>
                    <form id="marcaForm" action="guardarMarca.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="id_marca" name="id_marca" value="">
                            <div class="mb-3">
                                <label for="marca" class="form-label">Nombre de la Marca</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="marca"
                                    name="marca"
                                    required
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button 
                                type="button" 
                                class="btn btn-secondary" 
                                onclick="cerrarModal()"
                            >
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function abrirModal(marca) {
            const modal = document.getElementById('marcaModal');
            const titulo = document.getElementById('modalTitulo');
            const form = document.getElementById('marcaForm');
            
            if (marca) {
                titulo.textContent = 'Editar Marca';
                document.getElementById('id_marca').value = marca.id_marca;
                document.getElementById('marca').value = marca.marca;
            } else {
                titulo.textContent = 'Agregar Marca';
                document.getElementById('id_marca').value = '';
                document.getElementById('marca').value = '';
            }
            
            modal.style.display = 'block';
        }
        
        function cerrarModal() {
            document.getElementById('marcaModal').style.display = 'none';
        }
        
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta marca?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'eliminarMarca.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_marca';
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