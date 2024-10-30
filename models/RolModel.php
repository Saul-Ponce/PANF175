<?php
require_once("conexion.php");

class RolModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT *
        FROM
        rol";
		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre_rol)
	{
		$con = connection();


		$sql = "INSERT INTO rol (nombre_rol) VALUES ('$nombre_rol')";
        $querry = mysqli_query($con, $sql);
		
        



	}

	public static function editar($data)
	{

		$con = connection();

		$id  = $data['id_rol'];
		$rol = $data['nombre_rol'];



		$sql = "UPDATE rol SET nombre_rol='$rol'  WHERE id_rol='$id'";

		$query = mysqli_query($con, $sql);
	}

	public static function borrar($id_rol){

		$con = connection();
		

		$sql="DELETE FROM rol WHERE id_rol='$id_rol'";
		$query = mysqli_query($con, $sql);
		
	}


	

	
	
	
}


?>