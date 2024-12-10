<?php
// models/VentaCreditoModel.php
require_once("conexion.php");

class VentaCreditoModel
{
    public static function listar()
    {
        $con = connection();

        $sql = "SELECT
                    v.*, 
                    cj.nombre as cliente_juridico, 
                    cn.nombre as cliente_natural,
                    u.nombre as usuario
                FROM
                    ventas AS v
                LEFT JOIN
                    clientesjuridicos AS cj ON v.cliente_juridico_id = cj.id
                LEFT JOIN
                    clientesnaturales AS cn ON v.cliente_natural_id = cn.id
                INNER JOIN
                    usuarios AS u ON v.usuario_id = u.id
                WHERE
                    v.tipo_venta = 'credito'";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            throw new Exception("Error al listar ventas: " . mysqli_error($con));
        }
        return $result;
    }

    public static function listarDet($id)
{
    $con = connection();

    $sql = "SELECT
                p.nombre AS producto, 
                d.cantidad,
                d.precio_unitario,
                c.plazo_cobro AS plazo,
                i.tasa_interes AS interes,
                c.monto AS total_con_interes,
                v.total_venta AS total
            FROM
                detalleventa AS d
            INNER JOIN
                ventas AS v ON v.id = d.venta_id
            INNER JOIN
                productos AS p ON d.producto_id = p.id
            LEFT JOIN
                cuentasporcobrar AS c ON c.venta_id = v.id
            LEFT JOIN
                intereses AS i ON i.id = c.interes_id
            WHERE
                d.venta_id = $id";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        throw new Exception("Error al listar detalle de venta: " . mysqli_error($con));
    }

    $tabla = '<table id="tabla_detalleVC" class="table table-bordered text-center align-middle" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Plazo (Meses)</th>
                        <th>Tasa de Interés (%)</th>
                        <th>Total</th>
                        <th>Total con Intereses</th>
                    </tr>
                </thead>
                <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $tabla .= '<tr>
                    <td>' . htmlspecialchars($row['producto']) . '</td>
                    <td>' . htmlspecialchars($row['cantidad']) . '</td>
                    <td>$' . htmlspecialchars(number_format($row['precio_unitario'], 2)) . '</td>
                    <td>' . htmlspecialchars($row['plazo']) . '</td>
                    <td>' . htmlspecialchars(number_format($row['interes'], 2)) . '%</td>
                    <td>$' . htmlspecialchars(number_format($row['total'], 2)) . '</td>
                    <td>$' . htmlspecialchars(number_format($row['total_con_interes'], 2)) . '</td>
                </tr>';
    }

    $tabla .= '</tbody>
            </table>';

    $con->close();

    return $tabla;
}


    public static function agregar($fecha_venta, $tipo_venta, $tipo_cliente, $cliente, $usuario, $total, $data, $aval, $plazo, $interes, $monto_total_interes)
    {
        $con = connection();
        mysqli_begin_transaction($con);

        try {
            if ($tipo_cliente == "natural") {
                $sql = "INSERT INTO ventas (fecha, tipo_venta, cliente_natural_id, total_venta, usuario_id, aval) 
                        VALUES ('$fecha_venta', '$tipo_venta', $cliente, $total, $usuario, '$aval')";
            } else {
                $sql = "INSERT INTO ventas (fecha, tipo_venta, cliente_juridico_id, total_venta, usuario_id, aval) 
                        VALUES ('$fecha_venta', '$tipo_venta', $cliente, $total, $usuario, '$aval')";
            }
            if (!mysqli_query($con, $sql)) {
                throw new Exception("Error al insertar venta: " . mysqli_error($con));
            }
            $venta_id = mysqli_insert_id($con);

            foreach ($data as $item) {
                $producto = intval($item['id']);
                $cantidad = intval($item['cantidad']);
                $precio = floatval($item['price']);
                $id_inventario = intval($item['inv']);

                if ($producto <= 0 || $id_inventario <= 0 || $cantidad <= 0) {
                    throw new Exception("Valores inválidos para producto o inventario.");
                }

                $sql_detalle = "INSERT INTO detalleventa (venta_id, producto_id, cantidad, precio_unitario) 
                                VALUES ($venta_id, $producto, $cantidad, $precio)";
                if (!mysqli_query($con, $sql_detalle)) {
                    throw new Exception("Error al insertar detalle de venta: " . mysqli_error($con));
                }

                $sql_update = "UPDATE inventario SET stok = stok - $cantidad WHERE idInventario = $id_inventario";
                if (!mysqli_query($con, $sql_update)) {
                    throw new Exception("Error al actualizar inventario: " . mysqli_error($con));
                }
            }

            $interes_id = self::obtenerInteresId($plazo, $con);
            if (!$interes_id) {
                throw new Exception("Interés no encontrado para el plazo seleccionado: $plazo");
            }

            $monto_total_interes = floatval($monto_total_interes);
            $saldo = $monto_total_interes;

            $sql_cuentas = "INSERT INTO cuentasporcobrar (venta_id, interes_id, monto, saldo, fecha_vencimiento, plazo_cobro)
                            VALUES ($venta_id, $interes_id, $monto_total_interes, $saldo, 
                                    DATE_ADD('$fecha_venta', INTERVAL $plazo MONTH), $plazo)";
            if (!mysqli_query($con, $sql_cuentas)) {
                throw new Exception("Error al insertar en cuentas por cobrar: " . mysqli_error($con));
            }

            mysqli_commit($con);
            mysqli_close($con);
            return $venta_id;
        } catch (Exception $e) {
            mysqli_rollback($con);
            mysqli_close($con);
            throw $e;
        }
    }

    private static function obtenerInteresId($plazo, $con)
    {
        $sql = "SELECT id FROM intereses WHERE plazo_meses = $plazo LIMIT 1";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['id'];
        }
        return null;
    }
}
?>
