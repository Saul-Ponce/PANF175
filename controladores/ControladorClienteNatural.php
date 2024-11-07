<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/ClienteNaturalModel.php');

class ControladorClienteNatural
{
    public static function listar() 
    {
        $respuesta = ClienteNaturalModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $_SESSION['success_messageC'] = 'Cliente Natural agregado exitosamente!';
            ClienteNaturalModel::agregar(
                $_POST['nombre'], 
                $_POST['direccion'], 
                $_POST['telefono'], 
                $_POST['email'], 
                $_POST['ingresos'], 
                $_POST['egresos'], 
                $_POST['estado_civil'], 
                $_POST['lugar_trabajo'], 
                $_POST['dui'], 
                $_POST['fiador_id']
            );
            
            header("Location: ../vistas/lista-clientesnaturales.php");
            break;

        case "editar":
            ClienteNaturalModel::editar($_POST);
            header("Location: ../vistas/lista-clientesnaturales.php");
            break;

            case "cambiarEstado":
                ClienteNaturalModel::cambiarEstado($_POST);
                header("Location: ../vistas/lista-clientesnaturales.php");
                break;

        case "borrar":
            ClienteNaturalModel::borrar($_POST['id']);
            header("Location: ../vistas/lista-clientesnaturales.php");
            break;

        default:
            break;
    }
}
