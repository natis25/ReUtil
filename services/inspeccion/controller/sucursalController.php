<?php

require_once(__DIR__ . '/../model/sucursal.php');

class sucursalController {
    public static function obtenerSucursales() {
        return sucursal::obtenerTodas();
    }
}
