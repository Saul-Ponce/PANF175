<?php
require_once('../models/ProveedorModel.php');




class ControladorProveedor{


    public static function listar() 
    {

        $respuesta = ProveedorModel::listar();
        return $respuesta;
    }

    public static function esEliminable($id_proveedor) 
    {

        $respuesta = ProveedorModel::esEliminable($id_proveedor) ;
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
            
        case "insert":
            
            ProveedorModel::agregar($_POST['nombre_p'],  $_POST['direccion'], $_POST['telefono']);
            
            header("Location: ../vistas/lista-proveedor.php");
            break;

           case "editar":
                ProveedorModel::editar($_POST);
                header("Location: ../vistas/lista-proveedor.php");
                break;

            case "borrar":
                ProveedorModel::borrar($_POST['id_proveedor']);
                 header("Location: ../vistas/lista-proveedor.php");
                break;

           
        default:
            
            break;
}
    
}
