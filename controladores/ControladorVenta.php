<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 


require_once('../models/VentaModel.php');




class ControladorVenta{


    public static function listar() 
    {

        $respuesta = VentaModel::listar();
        return $respuesta;
    
    }

    public static function listarDet($id) 
    {

        $respuesta = VentaModel::listarDet($id);	
        return $respuesta;
    }


}

        if(ISSET($_POST["action"])){

        $action = $_POST["action"];
        switch($action){
        case "insert":
            $dataArray = json_decode($_POST['data_array'], true);
            var_dump($dataArray);
            
            $_SESSION['success_messageV'] = 'Venta agregada exitosamente!';
            VentaModel::agregar($_POST['fecha_venta'], $_POST['dui_c'],$_POST['dui_emp'], $_POST['total'], $dataArray);
            

            
            
            
            
            
            header("Location: ../vistas/genera-venta.php");
            break;

           case "editar":
                VentaModel::editar($_POST);
                header("Location: ../vistas/lista-Venta.php");
                break;

            case "borrar":
                VentaModel::borrar($_POST['dui_Venta']);
                 header("Location: ../vistas/lista-Venta.php");
                break;

           
        default:
            
            break;
}
    
}
