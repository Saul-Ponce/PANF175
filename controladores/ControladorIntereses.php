<?php
// Habilitar errores de PHP para ver mensajes de error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../models/InteresesModel.php');

class ControladorIntereses
{
    public static function listar()
    {
        $respuesta = InteresesModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $_SESSION['success_message'] = 'Interés agregado exitosamente!';
            InteresesModel::agregar($_POST['nombre'], $_POST['plazo_meses'], $_POST['tasa_interes'], $_POST['descripcion']);
            header("Location: ../vistas/lista-intereses.php");
            exit;

        case "editar":
            InteresesModel::editar($_POST);
            $_SESSION['success_message'] = 'Interés editado exitosamente!';
            header("Location: ../vistas/lista-intereses.php");
            exit;

        case "borrar":
            InteresesModel::borrar($_POST['id']);
            $_SESSION['success_message'] = 'Interés eliminado exitosamente!';
            header("Location: ../vistas/lista-intereses.php");
            exit;

        default:
            echo "Acción no válida";
            exit;
    }
}
?>
