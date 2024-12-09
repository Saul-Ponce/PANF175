<?php
require_once "conexion.php";

class inventarioModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "SELECT p.clasificacion,p.codigo,p.nombre,p.descripcion
                ,i.stok,i.precio_venta,p.stock_minimo,p.stok_maximo
                from inventario i 
                inner join productos p on i.producto_id=p.id   
                WHERE p.estado='1'
                ORDER BY 
                        CASE p.clasificacion
                            WHEN 'A' THEN 1
                            WHEN 'B' THEN 2
                            WHEN 'C' THEN 3
                        END; ";
        $query = mysqli_query($con, $sql);
        return $query;
    }
}
