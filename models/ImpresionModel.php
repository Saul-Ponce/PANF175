<?php
require_once("conexion.php");

class ImpresionModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT * FROM detalleimpresion";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($producto,$tamanio,$grosor,$detalles)
	{
		$con = connection();
		$sql = "INSERT INTO detalleimpresion (producto, tamanio, grosor, detalles) VALUES ('$producto','$tamanio','$grosor','$detalles')";
        $query = mysqli_query($con, $sql);
		return $query;
	}

	public static function editar($data)
	{

		$con = connection();

		$id = $data['id_detalleimpresion'];
		$producto = $data['producto'];
		$tamanio = $data['tamanio'];
        $grosor = $data['grosor'];
		$detalles = $data['detalles'];
		$sql = "UPDATE detalleimpresion SET producto='$producto', tamanio='$tamanio', grosor='$grosor', detalles='$detalles' WHERE id_detalleimpresion='$id'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($id){

		$con = connection();
		

		$sql="DELETE FROM detalleimpresion WHERE id_detalleimpresion='$id'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_detalleimpresion($id){

        $con = connection();
		$sql ="SELECT * FROM detalleimpresion WHERE id_detalleimpresion = '$id'";
		$query = mysqli_query($con, $sql);
		return $query;
    }
    public static function obtener_nombrep($id)
    {

        $con = connection();
		$sql ="SELECT nombre_p FROM producto WHERE codigo_producto = '$id'";
		$query = mysqli_query($con, $sql);
		return $query;
    }
}
?>