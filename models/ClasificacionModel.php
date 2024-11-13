<?php
require_once("conexion.php");

class ClasificacionModel
{
    public static function listar()
    {
        $con = connection();
        $sql = "SELECT * FROM clasificaciones";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de listar: " . mysqli_error($con));
        }
        return $query;
    }

    public static function agregar($nombre, $descripcion)
    {
        $con = connection();
        $sql = "INSERT INTO clasificaciones (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de inserción: " . mysqli_error($con));
        }
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
        if (!$query) {
            die("Error en la consulta de actualización: " . mysqli_error($con));
        }
        return $query;
    }

    public static function borrar($id)
    {
        $con = connection();
        $sql = "DELETE FROM clasificaciones WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de eliminación: " . mysqli_error($con));
        }
        return $query;
    }

    public static function obtener_clasificacion($id)
    {
        $con = connection();
        $sql = "SELECT * FROM clasificaciones WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de obtención: " . mysqli_error($con));
        }
        return $query;
    }
}
?>
