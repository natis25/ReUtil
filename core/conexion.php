<?php
class Database {
    // 1. Atributo estático para almacenar la única instancia
    private static $instance = null;
    private $connection;

    // 2. Constructor privado (para evitar instancias externas)
    private function __construct() {
        $servidor = "localhost";
        $usuario = "root";
        $contrasena = "";
        $basedatos = "reeutil";

        $this->connection = new mysqli($servidor, $usuario, $contrasena, $basedatos);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }

        // Configurar charset (opcional)
        $this->connection->set_charset("utf8");
    }

    // 3. Método estático para obtener la instancia
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}

// 4. Para compatibilidad con código existente (opcional)
$conexion = Database::getInstance();
?>