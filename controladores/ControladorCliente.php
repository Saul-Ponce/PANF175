<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/ClienteModel.php');




class ControladorCliente{


    public static function listar() 
    {

        $respuesta = ClienteModel::listar();
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $_SESSION['success_messageC'] = 'Cliente agregado exitosamente!';
            ClienteModel::agregar($_POST['dui'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['telefono']);
            
            header("Location: ../vistas/lista-cliente.php");
            break;

           case "editar":
                ClienteModel::editar($_POST);
                header("Location: ../vistas/lista-cliente.php");
                break;

            case "borrar":
                ClienteModel::borrar($_POST['dui_cliente']);
                 header("Location: ../vistas/lista-cliente.php");
                break;

           
        default:
            
            break;
}
    
}
