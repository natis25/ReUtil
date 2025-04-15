<?php

require_once(__DIR__ . '/../model/dispositivo.php');

class dispositivoController {
    public static function obtenerPorTipo($id_tipo) {
        return dispositivo::obtenerPorTipo($id_tipo);
    }
}
