<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/RolModel.php');




class ControladorRol{


    public static function listar() 
    {

        $respuesta = RolModel::listar();
        return $respuesta;
    }
   

}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $_SESSION['success_messageR'] = 'Rol creado exitosamente!';
            RolModel::agregar($_POST['nombre_rol']);
            
            header("Location: ../vistas/lista-rol.php");


            break;

            case "edit":
                RolModel::editar($_POST);
                header("Location: ../vistas/lista-rol.php");
                break;

                case "borrar":
                    RolModel::borrar($_POST['id_rol']);
                     header("Location: ../vistas/lista-rol.php");
                    break;

            default:
            
            break;
}
    
}
