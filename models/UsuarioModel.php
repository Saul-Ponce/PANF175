<?php
require_once "conexion.php";

class UsuarioModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "SELECT u.id, u.nombre, u.usuario, r.id as rol_id, r.nombre as nombre_rol, u.correo_recuperacion, u.estado
                FROM usuarios u
                INNER JOIN roles r ON u.rol_id = r.id";

        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function agregar($nombre, $usuario, $rol_id, $contrasena, $correo_recuperacion, $estado)
    {
        $temp_contra = 1;
        $con = connection();

        $sql = "INSERT INTO usuarios ( nombre, usuario, rol_id, contrasena, correo_recuperacion, estado, temp_contra) VALUES ('$nombre','$usuario','$rol_id','$contrasena','$correo_recuperacion',$estado,$temp_contra)";
        $querry = mysqli_query($con, $sql);

    }

    public static function editar($data)
    {

        $con = connection();

        $id = $data['id'];
        $nombre = $data['nombre'];
        $usuario = $data['usuario'];
        $rol_id = $data['rol-id'];
        $correo = $data['correo-recuperacion'];
        $sql = "UPDATE usuarios SET nombre='$nombre', usuario='$usuario',rol_id='$rol_id', correo_recuperacion='$correo' WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }

    public static function cambiarEstado($data)
    {

        $con = connection();

        $id = $data['id'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE usuarios SET estado=$estado WHERE id='$id'" : "UPDATE usuarios SET estado='$estado' WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }

    public static function borrar($id)
    {

        $con = connection();

        $sql = "DELETE FROM usuarios WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }
    public static function obtener_usuario($nombre)
    {

        $con = connection();
        $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
        $query = mysqli_query($con, $sql);
        return $query;
    }
    public static function obtener_IDusuario($nombre)
    {

        $con = connection();
        $sql = "SELECT id FROM usuarios WHERE usuario = '$nombre'";
        $query = mysqli_query($con, $sql);
        $fila = mysqli_fetch_row($query);
        return $fila;
    }
    public static function obtener_correo($nombre)
    {

        $con = connection();
        $sql = "SELECT correo_recuperacion FROM usuarios WHERE nombre = '$nombre'";
        $query = mysqli_query($con, $sql);
        $fila = mysqli_fetch_row($query);
        return $fila;
    }
}