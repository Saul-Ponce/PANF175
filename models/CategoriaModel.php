<?php
require_once("conexion.php");

class CategoriaModel
{

	public static function listar()
	{
		$con = connection();
		$sql ="SELECT * from categoriaproducto";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre,$descripcion)
	{
		$con = connection();


		$sql = "INSERT INTO categoriaproducto (nombre,descripcion) VALUES ('$nombre','$descripcion')";
        $query = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

        $id_categoria = $data['id'];
		$nombre = $data['nombre'];
		$descripcion = $data['descripcion'];
		$sql = "UPDATE categoriaproducto SET nombre='$nombre', descripcion='$descripcion'  WHERE id='$id_categoria'";
		$query = mysqli_query($con, $sql);	
	}

	public static function borrar($id_categoria){

		$con = connection();
		

		$sql="DELETE FROM categoriaproducto WHERE id='$id_categoria'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function cambiarEstado($data)
    {
        $con = connection();
        $idCategoria = $data['id'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE categoriaproducto SET estado=$estado WHERE id='$idCategoria'" : "UPDATE categoriaproducto SET estado='$estado' WHERE id='$idCategoria'";
        $query = mysqli_query($con, $sql);
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