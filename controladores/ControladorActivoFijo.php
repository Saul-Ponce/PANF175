<?php
require_once '../models/activoFijoModel.php'; // donde esta los querys
class ControladorActivoFijo
{

    public static function listar()
    {
        $respuesta = ActivoFijoModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            ActivoFijoModel::agregar(
                $_POST['codigoUnidad'],
                $_POST['nombre'],
                $_POST['idTipoActivo'],
                $_POST['fecha_adquisicion'],
                $_POST['valor_adquisicion'],
                $_POST['vida_util'],
                $_POST['estadoActivo'],
                $_POST['id']
            );
            $_SESSION['success_messageP'] = 'Tipo de activo agregado exitosamente!';
            header("Location: ../vistas/lista-ActivoFijo.php");
            break;
        case "editar":
            ActivoFijoModel::editar($_POST);
            header("Location: ../vistas/lista-ActivoFijo.php");
            break;
        case "borrar":
            ActivoFijoModel::borrar($_POST['id_activo']);
            header("Location: ../vistas/lista-ActivoFijo.php");
            break;
        default:
            echo "Bandera no encontrada";
            break;
    }
}
