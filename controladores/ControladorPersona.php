<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once('../models/PersonaModel.php');




class ControladorPersona
{


    public static function listar()
    {

        $respuesta = PersonaModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $estado = true;
            PersonaModel::agregar($_POST['dui'], $_POST['nombre'], $_POST['apellido'], $_POST['fechaNacimiento'], $_POST['direccion'], $_POST['rol'], $_POST['telefono1'], $_POST['telefono2'], $_POST['fechaContratacion'], $estado);
            $_SESSION['success_messageP'] = 'Empleado agregado exitosamente!';
            header("Location: ../vistas/lista-persona.php");
            break;

        case "editar":
            PersonaModel::editar($_POST);
            header("Location: ../vistas/lista-persona.php");
            break;

        case "borrar":
            PersonaModel::borrar($_POST['dui_persona']);
            header("Location: ../vistas/lista-persona.php");
            break;

        case "cambiarEstado":
            PersonaModel::cambiarEstado($_POST['dui_persona'],$_POST['estado']);
            header("Location: ../vistas/lista-persona.php");
            break;



        default:

            break;
    }
}
