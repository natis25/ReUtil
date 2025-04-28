<?php
header('Content-Type: application/json');

include_once('../../../core/conexion.php');
include_once('../controllers/sesionController.php');

$response = ["success" => false, "error" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tipoUsuario = $_POST['tipo_usuario'];

    $sesionController = new SesionController();
    
    if ($sesionController->iniciarSesion($email, $password, $tipoUsuario)) {
        $response["success"] = true;
        $response["redirect"] = ($tipoUsuario == 'cliente') 
            ? "../../../public/pages/menuCliente.html" 
            : "../../../public/pages/menuEmpleado.html";
    } else {
        $response["error"] = "Credenciales incorrectas";
    }
}

echo json_encode($response);
?>