<?php
require_once '../models/InventarioModel.php'; // donde esta los querys

class ControladorInventario
{

    public static function listar()
    {
        $respuesta = inventarioModel::listar();
        return $respuesta;
    }
}
