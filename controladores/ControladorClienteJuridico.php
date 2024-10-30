<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/ClienteJuridicoModel.php');

class ControladorClienteJuridico
{
    public static function listar() 
    {
        $respuesta = ClienteJuridicoModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $_SESSION['success_messageC'] = 'Cliente Jurídico agregado exitosamente!';
            ClienteJuridicoModel::agregar(
                $_POST['nombre'], 
                $_POST['direccion'], 
                $_POST['telefono'], 
                $_POST['email'], 
                $_POST['representante_legal'], 
                $_POST['aval'], 
                $_POST['clasificacion_id'], 
                $_POST['estado']
            );
            header("Location: ../vistas/lista-clientesjuridicos.php");
            break;

        case "editar":
            ClienteJuridicoModel::editar($_POST);
            header("Location: ../vistas/lista-clientesjuridicos.php");
            break;

        case "borrar":
            ClienteJuridicoModel::borrar($_POST['id']);
            header("Location: ../vistas/lista-clientesjuridicos.php");
            break;

        default:
            break;
    }
}
