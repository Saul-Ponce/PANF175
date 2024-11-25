<?php
require_once("conexion.php");

class ProductoModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT *,c.nombre as cnombre, p.nombre as pnombre, p.descripcion as pdescripcion, p.id as pid, p.estado as pestado from productos p INNER JOIN categoriaproducto c ON p.categoria_id=c.id";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre, $descripcion, $categoria, $imagen, $marca, $modelo, $stock, $codigo)
	{
		$con = connection();


		$sql = "INSERT INTO productos (nombre, descripcion, categoria_id, imagen, marca, modelo, stock_minimo, codigo) VALUES ('$nombre','$descripcion','$categoria', '$imagen',  '$marca', '$modelo', '$stock', '$codigo')";
        $query = mysqli_query($con, $sql);
	}

	public static function editar($data,$imagen)
	{

		$con = connection();
        $id = $data['id'];
        $nombre = $data['nombre'];
		$descripcion = $data['descripcion'];
		$categoria_id = $data['categoria_id'];
		$oimagen = $data['imagen'];
        $marca = $data['marca'];
        $modelo = $data['modelo'];
        $stock_minimo = $data['stock_minimo'];
		$codigo = $data['codigo'];
        if(is_null($imagen)){
            $sql = "UPDATE productos SET nombre='$nombre',  descripcion='$descripcion', categoria_id='$categoria_id', marca='$marca' , modelo='$modelo', stock_minimo='$stock_minimo', codigo='$codigo'  WHERE id='$id'";
		$query = mysqli_query($con, $sql);
        }else{
            $sql = "UPDATE productos SET nombre='$nombre',  descripcion='$descripcion', categoria_id='$categoria_id', imagen='$imagen', marca='$marca' , modelo='$modelo', stock_minimo='$stock_minimo', codigo='$codigo'  WHERE id='$id'";
		$query = mysqli_query($con, $sql);
        }
		

	
	}

	public static function borrar($codigo_producto){

		$con = connection();
		

		$sql="DELETE FROM productos WHERE id='$codigo_producto'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_imagen($id){

        $con = connection();
		$sql = "SELECT imagen WHERE = '$id'";
		$query = mysqli_query($con, $sql);
		return $query;

    }

    public static function obtener_categoria($id){
        $con = connection();
        $sql = "SELECT c.nombre as categoria from productos p INNER JOIN categoriaproducto c ON p.categoria_id=c.id WHERE p.categoria_id='$id'";
        $query = mysqli_query($con, $sql);
        return $query;
    }

	public static function cambiarEstado($data)
    {

        $con = connection();

        $id = $data['id'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE productos SET estado=$estado WHERE id='$id'" : "UPDATE productos SET estado='$estado' WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }
	
}


?>