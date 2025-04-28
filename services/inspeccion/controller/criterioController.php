<?php
require_once(__DIR__ . '/../model/criterio.php');

class criterioController
{
    public static function obtenerCriteriosPorTipo($tipo_id)
    {
        return Criterio::obtenerCriteriosPorTipo($tipo_id);
    }
}
