<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/ImpresionModel.php');




class ControladorDetalle{


    public static function listar() 
    {

        $respuesta = ImpresionModel::listar();
        return $respuesta;
    }
    public static function listarp($id) 
    {

        $respuesta = ImpresionModel::obtener_nombrep($id);
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $_SESSION['success_messageC'] = 'Detalle Impresion agregado exitosamente!';
            ImpresionModel::agregar($_POST['producto'], $_POST['tamanio'], $_POST['grosor'], $_POST['detalles']);
            
            header("Location: ../vistas/lista-detalles.php");
            break;

           case "editar":
                ImpresionModel::editar($_POST);
                header("Location: ../vistas/lista-detalles.php");
                break;

            case "borrar":
                ImpresionModel::borrar($_POST['id_detalleimpresion']);
                 header("Location: ../vistas/lista-detalles.php");
                break;

           
        default:
            
            break;
}
    
}
