<?php
require_once "conexion.php";

class CatalogoActivoFijoModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "SELECT * FROM Catalogo_Tipos_Activos";
        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function agregar($nombreActivo, $descripcion, $porcentajeDepreciacion, $codigo)
    {
        $con = connection();
        $sql = "INSERT INTO Catalogo_Tipos_Activos (nombreActivo,descripcion,porcentajeDepreciacion,codigo) 
        VALUES ('$nombreActivo','$descripcion',$porcentajeDepreciacion,'$codigo')";
        $querry = mysqli_query($con, $sql);
    }

    public static function editar($data)
    {
        $con = connection();
        $idTipoActivo = $data['idTipoActivo'];
        $nombreActivo = $data['nombreActivo'];
        $porcentajeDepreciacion = $data['porcentajeDepreciacion'];
        $descripcion = $data['descripcion'];
        $codigo = $data['codigo'];
        $sql = "UPDATE Catalogo_Tipos_Activos SET nombreActivo='$nombreActivo', porcentajeDepreciacion='$porcentajeDepreciacion',descripcion='$descripcion',codigo='$codigo' WHERE idTipoActivo='$idTipoActivo'";
        $query = mysqli_query($con, $sql);
    }

    public static function cambiarEstado($data)
    {
        $con = connection();
        $idTipoActivo = $data['idTipoActivo'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE Catalogo_Tipos_Activos SET estado=$estado WHERE idTipoActivo='$idTipoActivo'" : "UPDATE Catalogo_Tipos_Activos SET estado='$estado' WHERE idTipoActivo='$idTipoActivo'";
        $query = mysqli_query($con, $sql);
    }

    /*public static function borrar($idTipoActivo)
    {
        $con = connection();

        $sql = "DELETE FROM Catalogo_Tipos_Activos WHERE idTipoActivo='$idTipoActivo'";
        $query = mysqli_query($con, $sql);
    }*/
}
