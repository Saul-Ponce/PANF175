<?php
require_once('../models/CategoriaModel.php');




class ControladorCategoria{


    public static function listar() 
    {

        $respuesta = CategoriaModel::listar();
        return $respuesta;
    }
    public static function esEliminable($id_categoria) 
    {

        $respuesta = CategoriaModel::esEliminable($id_categoria) ;
        return $respuesta;
    }



}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            CategoriaModel::agregar($_POST['nombre'], $_POST['descripcion']);
            
            header("Location: ../vistas/lista-categoria.php");
            break;

           case "editar":
                CategoriaModel::editar($_POST);
                header("Location: ../vistas/lista-categoria.php");
                break;

            case "borrar":
                CategoriaModel::borrar($_POST['id']);
                 header("Location: ../vistas/lista-categoria.php");
                break;

            case "cambiarEstado":
                CategoriaModel::cambiarEstado($_POST);
                header("Location: ../vistas/lista-categoria.php");
                break;

           
        default:
            
            break;
}
    
}
