<?php
class Conexion {
    public static function conectar() {
        $host = 'localhost';
        $usuario = 'root'; 
        $clave = ''; 
        $bd = 'reeutil';

        $conn = new mysqli($host, $usuario, $clave, $bd);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        return $conn;
    }
}