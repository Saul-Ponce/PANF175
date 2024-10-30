<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

require_once('../models/MantModel.php');




class ControladorMant{


    public static function listar() 
    {

        $respuesta = MantModel::listar();
        return $respuesta;
    }

    public static function dui($dui) 
    {

        $respuesta = MantModel::dueño($dui);
        return $respuesta;
    }

   

}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $_SESSION['success_messageM'] = 'Mantenimiento creado exitosamente!';
            MantModel::agregar($_POST['fechaMant'],$_POST['detalles_m'],$_POST['estado_m'],$_POST['precio_m'],$_POST['equipo']);
            
            header("Location: ../vistas/lista-mant.php");


            break;

            case "edit":
                MantModel::editar($_POST);
                header("Location: ../vistas/lista-mant.php");
                break;

            case "borrar":
                MantModel::borrar($_POST['id_cmantenimiento']);
                header("Location: ../vistas/lista-mant.php");
                break;

            default:
            
            break;
}
    
}
