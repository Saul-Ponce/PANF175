<?php
require_once("conexion.php");

class ProductoModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT\n".
        "	producto.codigo_producto, \n".
        "	producto.nombre_p, \n".
        "	producto.marca, \n".
        "	producto.precio, \n".
        "	proveedor.nombre_p as \"proveedor\", \n".
        "	categoria.nombre, \n".
        "	producto.imagen_p, \n".
        "	producto.stock\n".
        "FROM\n".
        "	producto\n".
        "	INNER JOIN\n".
        "	proveedor\n".
        "	ON \n".
        "		producto.proveedor = proveedor.id_proveedor\n".
        "	INNER JOIN\n".
        "	categoria\n".
        "	ON \n".
        "		producto.categoria = categoria.id_categoria";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($codigo_producto, $nombre_p,  $marca, $precio, $stock,  $categoria, $proveedor, $imagen_p)
	{
		$con = connection();


		$sql = "INSERT INTO producto (codigo_producto, nombre_p, marca, precio, stock, categoria, proveedor, imagen_p ) VALUES ('$codigo_producto','$nombre_p','$marca', '$precio',  '$stock', '$categoria','$proveedor', '$imagen_p')";
        $query = mysqli_query($con, $sql);
        



	}

	public static function editar($data,$imagen_p=NULL)
	{

		$con = connection();

        $codigo_producto = $data['codigo_producto'];
		$nombre_p = $data['nombre_p'];
		$marca = $data['marca'];
		$precio = $data['precio'];
        $stock = $data['stock'];
        $categoria = $data['categoria'];
        $proveedor = $data['proveedor'];
        

		
        if(is_null($imagen_p)){
            $sql = "UPDATE producto SET nombre_p='$nombre_p',  marca='$marca', precio='$precio', categoria='$categoria', proveedor='$proveedor' , stock='$stock'  WHERE codigo_producto='$codigo_producto'";
		$query = mysqli_query($con, $sql);
        }else{
            $sql = "UPDATE producto SET nombre_p='$nombre_p',  marca='$marca', precio='$precio', categoria='$categoria', proveedor='$proveedor', imagen_p='$imagen_p', stock='$stock'   WHERE codigo_producto='$codigo_producto'";
		$query = mysqli_query($con, $sql);
        }
		

	
	}

	public static function borrar($codigo_producto){

		$con = connection();
		

		$sql="DELETE FROM producto WHERE codigo_producto='$codigo_producto'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_persona($codigo_producto){

        $con = connection();
		$sql = "SELECT\n".
        "	producto.codigo_producto, \n".
        "	producto.nombre_p, \n".
        "	producto.marca, \n".
        "	producto.precio, \n".
        "	proveedor.nombre_p as \"proveedor\", \n".
        "	categoria.nombre, \n".
        "	producto.imagen_p, \n".
        "	producto.stock\n".
        "FROM\n".
        "	producto\n".
        "	INNER JOIN\n".
        "	proveedor\n".
        "	ON \n".
        "		producto.proveedor = proveedor.id_proveedor\n".
        "	INNER JOIN\n".
        "	categoria\n".
        "	ON \n".
        "		producto.categoria = categoria.id_categoria WHERE codigo_producto = '$codigo_producto'";
		$query = mysqli_query($con, $sql);

		return $query;

    }

    public static function obtener_ultimocorrelativo(){
        $con = connection();
        $sql = "SELECT SUBSTRING(codigo_producto, 14, 3) AS ultimo_correlativo
        FROM producto
        ORDER BY codigo_producto DESC
        LIMIT 1";
        $query = mysqli_query($con, $sql);
        return $query;
    }
	
}


?>