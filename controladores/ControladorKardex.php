<?php
require_once '../models/KardexModel.php'; // donde esta los querys

class ControladorKardex
{

    public static function listar()
    {
        $respuesta = kardexModel::listar();
        return $respuesta;
    }
}
