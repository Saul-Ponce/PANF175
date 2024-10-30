<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once('../models/ClasificacionModel.php');

class ControladorClasificacion
{
    public static function listar() 
    {
        $respuesta = ClasificacionModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $_SESSION['success_message'] = 'Clasificación agregada exitosamente!';
            ClasificacionModel::agregar($_POST['nombre'], $_POST['descripcion']);
            header("Location: ../vistas/lista-clasificacion.php");
            break;

        case "editar":
            ClasificacionModel::editar($_POST);
            header("Location: ../vistas/lista-clasificacion.php");
            break;

        case "borrar":
            ClasificacionModel::borrar($_POST['id']);
            header("Location: ../vistas/lista-clasificacion.php");
            break;

        default:
            break;
    }
}
?>
