<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once('../models/VentaContadoModel.php');




class ControladorVentaContado
{


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

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $dataArray = json_decode($_POST['data_array'], true);
            var_dump($dataArray);
            var_dump($_POST);

            $_SESSION['success_messageV'] = 'Venta agregada exitosamente!';
            VentaModel::agregar($_POST['fecha'], $_POST['tipo_venta'], $_POST['tipo_cliente'], $_POST['clienteSelect'], $_POST['usuario_id'], $_POST['total_venta'], $dataArray);

            header("Location: ../vistas/lista-Venta-contado.php");
            break;
        case "editar":
            VentaModel::editar($_POST);
            header("Location: ../vistas/lista-Venta-contado.php");
            break;

        case "borrar":
            VentaModel::borrar($_POST['dui_Venta']);
            header("Location: ../vistas/lista-Venta.php");
            break;
        case "ver-det":
            $detalle = VentaModel::listarDet($_POST['id']);
            print json_encode($detalle);
            break;
        case "ver-det-notas":
            $detalleN = VentaModel::listarDetN($_POST['id']);
            print json_encode($detalleN);
            break;
        case "gen-nota":
            $_SESSION['success_messageNC'] = 'Nota de credito generada';
            VentaModel::agregarNotaC($_POST['id-venta'], $_POST['fecha'], $_POST['monto'], $_POST['motivo'], $_POST['usuario'], true);
            break;


        default:

            break;
    }

}