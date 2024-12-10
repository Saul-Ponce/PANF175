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
	public static function getDetalleById($detalleId) {
		$con = connection();
		$stmt = $con->prepare("SELECT * FROM detallecompra WHERE id = ?");
		$stmt->bind_param("i", $detalleId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
		
	}
	public static function getStockByProductId($productId) {
		$con = connection();
		$stmt = $con->prepare("SELECT stok FROM inventario WHERE producto_id = ?");
		$stmt->bind_param("i", $productId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc()['stok'];
	}
	public static function getStockMaximo($productId) {
		$con = connection();
		$stmt = $con->prepare("SELECT stok_maximo FROM productos WHERE id = ?");
		$stmt->bind_param("i", $productId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc()['stok_maximo'];
	}
	
	public static function updateStock($productId, $newStock) {
		$con = connection();
		$stmt = $con->prepare("UPDATE inventario SET stok = ? WHERE producto_id = ?");
		$stmt->bind_param("ii", $newStock, $productId);
		return $stmt->execute();
	}



	public static function listarDet($id)
{
    $con = connection();
    
    $sql = "SELECT
	    det.id,
      pr.nombre as nombre_proveedor,
        p.nombre,
        det.compra_id, 
        det.producto_id, 
        det.cantidad,
        det.precio_unitario
    FROM
        detallecompra AS det
    INNER JOIN
        compras AS c ON det.compra_id = c.id
    INNER JOIN
        productos AS p ON det.producto_id = p.id
        INNER JOIN
        proveedores as pr on pr.id = det.proveedor_id
    WHERE
        det.compra_id = '$id'";
    
    $result = mysqli_query($con, $sql);
    
    return $result;
	
}

public static function updateTotal($data)
{

	$con = connection();

	$id  = $data['compra_id'];
	$total_compra = $data['total_compra'];
    $sql = "UPDATE compras SET total_compra = ?  WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("di", $total_compra, $id);
	
    
    $result = $stmt->execute();

	
    $stmt->close();
    $con->close();
    
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

public static function updateDetalle($data)
{
	
    $con = connection();

	$id  = $data['id'];
	$cantidad = $data['cantidad'];
	$precio_unitario = $data['precio_unitario'];
    $sql = "UPDATE detallecompra SET cantidad = ?, precio_unitario = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ddi", $cantidad, $precio_unitario, $id);
	
    
    $result = $stmt->execute();

	
    $stmt->close();
    $con->close();
    
    return $result;
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