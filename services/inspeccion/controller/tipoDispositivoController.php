<?php

require_once(__DIR__ . '/../model/tipoDispositivo.php');

class tipoDispositivoController {
    public static function obtenerTipos() {
        return TipoDispositivo::obtenerTodos();
    }
}
