<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

require_once('../models/EquipoModel.php');




class ControladorEquipo{


    public static function listar() 
    {

        $respuesta = EquipoModel::listar();
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $_SESSION['success_messageE'] = 'Equipo agregado exitosamente!';
            EquipoModel::agregar($_POST['fecha_r'], $_POST['marca'], $_POST['procesador'], $_POST['ram'], $_POST['almacenamiento'], $_POST['observaciones'], $_POST['fecha_entrega'],$_POST['dui_cliente']);
            
            header("Location: ../vistas/lista-equipo.php");
            break;

           case "editar":
                EquipoModel::editar($_POST);
                header("Location: ../vistas/lista-equipo.php");
                break;

            case "borrar":
                EquipoModel::borrar($_POST['id_equipo']);
                 header("Location: ../vistas/lista-equipo.php");
                break;

           
        default:
            
            break;
}
    
}
