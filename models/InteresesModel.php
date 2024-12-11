<?php
require_once("conexion.php");

class InteresesModel
{
    public static function listar()
    {
        $con = connection();
        $sql = "SELECT * FROM intereses";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de listar: " . mysqli_error($con));
        }
        return $query;
    }

    public static function agregar($nombre, $plazo_meses, $tasa_interes, $descripcion)
    {
        $con = connection();
        $sql = "INSERT INTO intereses (nombre, plazo_meses, tasa_interes, descripcion) VALUES ('$nombre', '$plazo_meses', '$tasa_interes', '$descripcion')";
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
        $plazo_meses = $data['plazo_meses'];
        $tasa_interes = $data['tasa_interes'];
        $descripcion = $data['descripcion'];

        $sql = "UPDATE intereses SET nombre='$nombre', plazo_meses='$plazo_meses', tasa_interes='$tasa_interes', descripcion='$descripcion' WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de actualización: " . mysqli_error($con));
        }
        return $query;
    }

    public static function borrar($id)
    {
        $con = connection();
        $sql = "DELETE FROM intereses WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de eliminación: " . mysqli_error($con));
        }
        return $query;
    }

    public static function obtener_interes($id)
    {
        $con = connection();
        $sql = "SELECT * FROM intereses WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error en la consulta de obtención: " . mysqli_error($con));
        }
        return $query;
    }
}
?>
