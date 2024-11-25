<?php
require_once('../models/ProveedorModel.php');




class ControladorProveedor{


    public static function listar() 
    {

        $respuesta = ProveedorModel::listar();
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
            
        case "insert":
            
            ProveedorModel::agregar($_POST['nombre'],  $_POST['direccion'], $_POST['telefono'], $_POST['correo']);
            
            header("Location: ../vistas/lista-proveedor.php");
            break;

           case "editar":
                ProveedorModel::editar($_POST);
                header("Location: ../vistas/lista-proveedor.php");
                break;

            case "borrar":
                ProveedorModel::borrar($_POST['id']);
                 header("Location: ../vistas/lista-proveedor.php");
                break;

                case "cambiarEstado":
                    ProveedorModel::cambiarEstado($_POST);
                    header("Location: ../vistas/lista-proveedor.php");
                    break;
        default:
            
            break;
}
    
}
