<?php
require_once("conexion.php");

class ClasificacionModel
{
    public static function listar()
    {
        $con = connection();
        $sql = "SELECT * FROM clasificaciones";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function agregar($nombre, $descripcion)
    {
        $con = connection();
        $sql = "INSERT INTO clasificaciones (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function editar($data)
    {
        $con = connection();
        $id = $data['id'];
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $sql = "UPDATE clasificaciones SET nombre='$nombre', descripcion='$descripcion' WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function borrar($id)
    {
        $con = connection();
        $sql = "DELETE FROM clasificaciones WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function obtener_clasificacion($id)
    {
        $con = connection();
        $sql = "SELECT * FROM clasificaciones WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        return $query;
    }
}
?>
