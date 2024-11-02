<?php
require_once '../models/UsuarioModel.php';

class ControladorUsuario
{

    public static function listar()
    {

        $respuesta = UsuarioModel::listar();
        return $respuesta;
    }

}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT, ['cost' => 10]);
            $estado = true;
            UsuarioModel::agregar($_POST['nombre'], $_POST['usuario'], $_POST['rol_id'], $hash, $_POST['correo_recuperacion'], $estado);
            $_SESSION['success_messageP'] = 'Empleado agregado exitosamente!';
            header("Location: ../vistas/lista-usuario.php");
            break;
        case "editar":
            UsuarioModel::editar($_POST);
            header("Location: ../vistas/lista-usuario.php");
            break;
        case "cambiarEstado":
            UsuarioModel::cambiarEstado($_POST);
            header("Location: ../vistas/lista-usuario.php");
            break;
        case "borrar":
            UsuarioModel::borrar($_POST['id']);
            header("Location: ../vistas/lista-usuario.php");
            break;

        default:
            echo "Bandera no encontrada";
            break;
    }

}
