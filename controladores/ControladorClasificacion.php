<?php
// Habilitar errores de PHP para ver mensajes de error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
            exit;

        case "editar":
            ClasificacionModel::editar($_POST);
            $_SESSION['success_message'] = 'Clasificación editada exitosamente!';
            header("Location: ../vistas/lista-clasificacion.php");
            exit;

        case "borrar":
            ClasificacionModel::borrar($_POST['id']);
            $_SESSION['success_message'] = 'Clasificación eliminada exitosamente!';
            header("Location: ../vistas/lista-clasificacion.php");
            exit;

        default:
            echo "Acción no válida";
            exit;
    }
}
?>
