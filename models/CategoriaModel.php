<?php
require_once("conexion.php");

class CategoriaModel
{

	public static function listar()
	{
		$con = connection();
		$sql ="SELECT\n".
        "	categoria.id_categoria, \n".
        "	categoria.nombre\n".
        "FROM\n".
        "	categoria";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre)
	{
		$con = connection();


		$sql = "INSERT INTO categoria (nombre) VALUES ('$nombre')";
        $query = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

        $id_categoria = $data['id_categoria'];
		$nombre = $data['nombre'];
	
		

		$sql = "UPDATE categoria SET nombre='$nombre'  WHERE id_categoria='$id_categoria'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($id_categoria){

		$con = connection();
		

		$sql="DELETE FROM categoria WHERE id_categoria='$id_categoria'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_persona($id_categoria){

        $con = connection();
		$sql = "SELECT\n".
        "	categoria.id_categoria, \n".
        "	categoria.nombre\n".
        "FROM\n".
        "	categoria WHERE id_categoria = '$id_categoria'";
		$query = mysqli_query($con, $sql);

		return $query;

    }

	public static function esEliminable($id_categoria){
		
		$con = connection();
		$sql = "SELECT\n".
		"	categoria.*\n".
		"FROM\n".
		"	categoria\n".
		"	INNER JOIN\n".
		"	producto\n".
		"	ON \n".
		"		categoria.id_categoria = producto.categoria  WHERE id_categoria= $id_categoria";
		$result = mysqli_query($con, $sql);
		
		// Verificar si hay resultados
		if (mysqli_num_rows($result) > 0) {
			// Si hay resultados
			return true;
		} else {
			// Si no hay resultados
			return false;
		}
				
	}
	
}


?>