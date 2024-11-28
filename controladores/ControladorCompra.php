<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 


require_once('../models/CompraModel.php');




class ControladorCompra{


    public static function listar() 
    {

        $respuesta = CompraModel::listar();
        return $respuesta;
    }
    public static function listarDet($id) 
    {

        $respuesta = CompraModel::listarDet($id);
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $dataArray = json_decode($_POST['data_array'], true);
            var_dump($dataArray);
            
            $_SESSION['success_messageC'] = 'Compra agregada exitosamente!';
            CompraModel::agregar($_POST['fecha'], $_POST['total'], $_POST['usuario_id'], $dataArray);
            

            
            header("Location: ../vistas/generar-Compra.php");
            break;

           

           case "editar":
                CompraModel::editar($_POST);
                header("Location: ../vistas/lista-Compra.php");
                break;

            case "borrar":
                CompraModel::borrar($_POST['dui_Compra']);
                 header("Location: ../vistas/lista-Compra.php");
                break;

           
        default:
            
            break;
}
    
}
