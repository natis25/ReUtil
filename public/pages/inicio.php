<?php
require_once '../../core/conexion.php';

$query = "SELECT id_tipo, nombre_tipo FROM tipo_dispositivo WHERE aceptado = 1";
$resultado = $conexion->query($query);

$dispositivos = [];
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $dispositivos[] = $fila;
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReeUtil - Inicio</title>
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
        <h1>Proyecto ReeUtil</h1>
        <p>ReeUtil es una plataforma diseñada para facilitar la gestión de equipos electrónicos que pueden tener una
            segunda vida. Nuestro objetivo es ayudar a personas y empresas a dar un mejor destino a sus dispositivos, ya sea 
            a través de su venta o su reciclaje responsable. Con ReeUtil podrás registrar, clasificar y dar seguimiento a los 
            recursos tecnológicos que ya no utilizas, optimizando su aprovechamiento y reduciendo el impacto ambiental. 
            Nuestro sistema permite llevar un inventario claro y organizado, facilitando la reutilización de materiales y 
            contribuyendo a un consumo más sostenible. ReeUtil transforma lo que parece desecho en una oportunidad.</p>

        <h2>Tipos de Dispositivos Aceptados</h2>
        <div class="devices">
            <?php if (!empty($dispositivos)): ?>
                <?php foreach ($dispositivos as $dispositivo): ?>
                    <div class="device-card">
                        <h3><?php echo htmlspecialchars($dispositivo['nombre_tipo']); ?></h3>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay dispositivos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
$conexion->close();
?>