<?php
require_once("conexion.php");

class CompraModel
{

	public static function listar()
    {
		$con = connection();
			
			$sql = "SELECT
			p.nombre, 
			p.apellido, 
			c.*
		FROM
			compras AS c
			INNER JOIN
			persona AS p
			ON 
				c.gerente = p.dui_persona";
			$result = mysqli_query($con,$sql);
            return $result; 
    }

	public static function listarDet($id)
    {
		$con = connection();
			
			$sql = "SELECT
			p.nombre_p,
			det.compra, 
			det.producto, 
			det.cantidad, 
			det.cantidad*p.precio as precioDet
		FROM
			detallecompra AS det
			INNER JOIN
			compras AS c
			ON 
				det.compra = c.id_compra
			INNER JOIN
			producto AS p
			ON 
				det.producto = p.codigo_producto
		WHERE
			id_compra = '$id'";
			$result = mysqli_query($con,$sql);
            return $result; 
    }

	

	public static function agregar($fecha_c, $gerente, $total, $data)
	{
		$con = connection();


		$sql = "INSERT INTO compras (fecha_c, gerente, total) VALUES ('$fecha_c','$gerente','$total')";
        $querry = mysqli_query($con, $sql);

		$compra_id = mysqli_insert_id($con);
		mysqli_close($con);

		self::agregarDet($compra_id, $data);

	}
	

	public static function agregarDet($id, $data)
	{
		$con = connection();

		 // Extract data from the array
		 foreach ($data as $item) {
		 $producto = $item['code'];
		 $cantidad = $item['quantity'];


		$sql = "INSERT INTO detallecompra (compra, producto, cantidad) VALUES ('$id','$producto','$cantidad')";
		
        $querry = mysqli_query($con, $sql);
        


		 }
	}




	public static function editar($data)
	{

		$con = connection();

		$id  = $data['id_compra'];
		$fecha_c = $data['fecha_c'];
		$gerente = $data['gerente'];
		




		$sql = "UPDATE compra SET fecha_c='$fecha_c', gerente='$gerente'  WHERE id_compra='$id'";

		$query = mysqli_query($con, $sql);
	}

	public static function borrar($id_compra){

		$con = connection();
		

		$sql="DELETE FROM compras WHERE id_compra='$id_compra'";
		$query = mysqli_query($con, $sql);
		
		
	}
	


	

	
	
	
}


?>