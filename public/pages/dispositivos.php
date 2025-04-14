<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$api_url = 'http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/dispositivo/dispositivoApi.php';
$api_response = @file_get_contents($api_url);

if ($api_response === false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $api_response = curl_exec($ch);
    curl_close($ch);
}

$dispositivos = json_decode($api_response, true) ?: [];

$marcas = json_decode(@file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/marca/marcaApi.php'), true) ?: [];
$tipos = json_decode(@file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/Reeutil/services/tipo/tipoApi.php'), true) ?: [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM de Dispositivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <nav>
      <div class="logo">
          <a href="inicio.php">
              <img src="images/eco.png" style="width: 50px; height: 50px"; alt="ReeUtil Logo">
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
        <h1>Gestión de Dispositivos</h1>
        <br>
        <br>
        
        <button class="btn-login" onclick="abrirModal(null)">
            Agregar Nuevo Dispositivo
        </button>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dispositivos as $dispositivo): ?>
                    <tr>
                        <td><?= htmlspecialchars($dispositivo['modelo']) ?></td>
                        <td><?= htmlspecialchars($dispositivo['nombre_tipo'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($dispositivo['nombre_marca'] ?? 'N/A') ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning me-2" 
                                onclick="abrirModal(<?= htmlspecialchars(json_encode($dispositivo)) ?>)">
                                Editar
                            </button>
                            <button class="btn btn-sm btn-danger" 
                                onclick="confirmarEliminar(<?= $dispositivo['id_dispositivo'] ?>)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div id="dispositivoModal" style="display: none;">
            <div class="modal-dialog" style="margin: 10% auto;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitulo">Agregar Dispositivo</h5>
                        <button type="button" class="btn-close" onclick="cerrarModal()"></button>
                    </div>
                    <form id="dispositivoForm" action="guardarDispositivo.php" method="post">
                        <input type="hidden" id="id_dispositivo" name="id_dispositivo" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_dispositivo_id" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo_dispositivo_id" name="tipo_dispositivo_id" required>
                                    <option value="">Seleccionar tipo</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?= $tipo['id_tipo'] ?>"><?= htmlspecialchars($tipo['tipo']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="marca_id" class="form-label">Marca</label>
                                <select class="form-select" id="marca_id" name="marca_id" required>
                                    <option value="">Seleccionar marca</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['id_marca'] ?>"><?= htmlspecialchars($marca['marca']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function abrirModal(dispositivo) {
            const modal = document.getElementById('dispositivoModal');
            const titulo = document.getElementById('modalTitulo');
            
            if (dispositivo) {
                titulo.textContent = 'Editar Dispositivo';
                document.getElementById('id_dispositivo').value = dispositivo.id_dispositivo;
                document.getElementById('modelo').value = dispositivo.modelo || '';
                document.getElementById('tipo_dispositivo_id').value = dispositivo.Tipo_dispositivo_id_tipo || '';
                document.getElementById('marca_id').value = dispositivo.Marca_id_marca || '';
            } else {
                titulo.textContent = 'Agregar Dispositivo';
                document.getElementById('id_dispositivo').value = '';
                document.getElementById('modelo').value = '';
                document.getElementById('tipo_dispositivo_id').value = '';
                document.getElementById('marca_id').value = '';
            }
            
            modal.style.display = 'block';
        }
        
        function cerrarModal() {
            document.getElementById('dispositivoModal').style.display = 'none';
        }
        
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este dispositivo?')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'eliminarDispositivo.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_dispositivo';
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
    .buttonG{
        padding: 10px 20px;
        margin-left: 20px;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 1rem;
        height: 40px;
    }

    .buttonC{
        padding: 10px 20px;
        background-color:rgb(119, 127, 129);
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 1rem;
        height: 40px;
    }

    .buttonC:hover{
        background-color:rgb(79, 80, 80);
    }


</style>