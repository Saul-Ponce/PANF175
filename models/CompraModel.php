<?php
require_once("conexion.php");

class CompraModel
{


	/*public static function actualizarInventario($id, $cantidad) {
		$con = connection();
		
		// Retrieve the current cantidad from the inventario table
		$sqlSelect = "SELECT cantidad FROM inventario WHERE id='$id'";
		$result = mysqli_query($con, $sqlSelect);
		
		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$currentCantidad = $row['cantidad'];
			
			// Calculate the new cantidad
			$nuevo = $currentCantidad + $cantidad;
			
			// Update the inventario table with the new cantidad
			$sqlUpdate = "UPDATE inventario SET cantidad='$nuevo' WHERE id='$id'";
			$query = mysqli_query($con, $sqlUpdate);
			
			if ($query) {
				echo "Inventario actualizado correctamente.";
			} else {
				echo "Error al actualizar el inventario: " . mysqli_error($con);
			}
		} else {
			echo "Producto no encontrado.";
		}
		
		mysqli_close($con);
	}
		*/

	public static function listar()
    {
		$con = connection();
			
			$sql = "SELECT
			u.id as usuario_id,
			c.id as compras_id,
			c.*,
			u.*
		FROM
			compras AS c
			INNER JOIN
			usuarios AS u
			ON 
				c.usuario_id = u.id";
			$result = mysqli_query($con,$sql);
            return $result; 
    }



	public static function listarDet($id)
{
    $con = connection();
    
    $sql = "SELECT
        p.nombre,
        det.compra_id, 
        det.producto_id, 
        det.stok,
        det.precio_unitario
    FROM
        detallecompra AS det
    INNER JOIN
        compras AS c ON det.compra_id = c.id
    INNER JOIN
        productos AS p ON det.producto_id = p.id
    WHERE
        det.compra_id = '$id'";
    
    $result = mysqli_query($con, $sql);
    
    return $result;

   
	
}


	

public static function agregar($fecha, $total_compra, $usuario_id, $data)
{
    $con = connection();

    // Insertar la compra
    $sql = "INSERT INTO compras (fecha, total_compra, usuario_id) VALUES ('$fecha', '$total_compra', '$usuario_id')";
    $querry = mysqli_query($con, $sql);

    $compra_id = mysqli_insert_id($con);
    mysqli_close($con);

    // Insertar detalles de la compra
    self::agregarDet($compra_id, $data);
}

public static function agregarDet($compra_id, $data)
{
    $con = connection();

    foreach ($data as $item) {
        $producto_id = $item['code'];
        $cantidad = $item['quantity'];
        $precio_unitario = $item['price'];
        $proveedor_id = $item['proveedorId'];

        // Insertar detalle de la compra (el trigger maneja el inventario)
        $sql = "INSERT INTO detallecompra (compra_id, producto_id, proveedor_id, cantidad, precio_unitario) 
                VALUES ('$compra_id', '$producto_id', '$proveedor_id', '$cantidad', '$precio_unitario')";
        mysqli_query($con, $sql);
    }

    mysqli_close($con);
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