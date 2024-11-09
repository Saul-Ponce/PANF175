<?php
require_once "conexion.php";

class RolModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "SELECT *
        FROM
        roles";
        $query = mysqli_query($con, $sql);

        return $query;
    }

    public static function agregar($nombre, $descripcion)
    {
        $con = connection();

        $sql = "INSERT INTO roles (nombre, descripcion) VALUES('$nombre', '$descripcion');";
        $querry = mysqli_query($con, $sql);

    }

    public static function editar($data)
    {

        $con = connection();

        $id = $data['id'];
        $rol = $data['nombre'];
        $descripcion = $data['descripcion'];

        $sql = "UPDATE roles SET nombre='$rol', descripcion='$descripcion'  WHERE id='$id'";

        $query = mysqli_query($con, $sql);
    }

    public static function borrar($id)
    {

        $con = connection();

        $sql = "DELETE FROM roles WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }

}
