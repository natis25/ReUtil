<?php
require_once(__DIR__ . '/../model/dispositivo.php');

class dispositivoController
{
    public static function obtenerPorTipo($id_tipo)
    {
        return Dispositivo::obtenerPorTipo($id_tipo);
    }

    public static function obtenerMarcasPorTipo($id_tipo)
    {
        return Dispositivo::obtenerMarcasPorTipo($id_tipo);
    }

    public static function obtenerModelosPorMarcaYTipo($marca_id, $tipo_id)
    {
        return Dispositivo::obtenerModelosPorMarcaYTipo($marca_id, $tipo_id);
    }

}
?>
