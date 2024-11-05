<?php
require_once '../models/CatalogoActivoFijoModel.php'; // donde esta los querys

class ControladorCatalogoActivoFijo
{

    public static function listar()
    {
        $respuesta = CatalogoActivoFijoModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            CatalogoActivoFijoModel::agregar($_POST['nombreActivo'], $_POST['descripcion'], $_POST['porcentajeDepreciacion'], $_POST['codigo']);
            $_SESSION['success_messageP'] = 'Tipo de activo agregado exitosamente!';
            header("Location: ../vistas/lista-catalogoActivoFijo.php");
            break;
        case "editar":
            CatalogoActivoFijoModel::editar($_POST);
            header("Location: ../vistas/lista-catalogoActivoFijo.php"); // al editar redirecciona a la tabla
            break;
        case "cambiarEstado":
            CatalogoActivoFijoModel::cambiarEstado($_POST);
            header("Location: ../vistas/lista-catalogoActivoFijo.php");
            break;
        default:
            echo "Bandera no encontrada";
            break;
    }
}
