<?php
require_once("conexion.php");

class ClienteNaturalModel
{
    
    public static function listar()
{
    $con = connection();
    $sql = "SELECT 
                cn.*, 
                f.nombre AS fiador_nombre, 
                f.direccion AS fiador_direccion, 
                f.telefono AS fiador_telefono, 
                f.dui AS fiador_dui,
                f.email AS fiador_email, 
                c.nombre AS clasificacion_nombre 
            FROM clientesnaturales cn
            LEFT JOIN fiadores f ON cn.fiador_id = f.id
            LEFT JOIN clasificaciones c ON cn.clasificacion_id = c.id";
    $query = mysqli_query($con, $sql);

    return $query;
}

public static function agregar($nombre, $direccion, $telefono, $email, $ingresos, $egresos, $estado_civil, $lugar_trabajo, $dui, $fiador_id)
{
    $con = connection();
    // Convert empty values to NULL
    $ingresos = $ingresos === "" ? 0 : $ingresos;
    $egresos = $egresos === "" ? 0 : $egresos;
    $fiador_id = $fiador_id === "" ? null : $fiador_id;

    $sql = "INSERT INTO clientesnaturales (nombre, direccion, telefono, email, ingresos, egresos, estado_civil, lugar_trabajo, dui, fiador_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param(
        "ssssddsssi", 
        $nombre, 
        $direccion, 
        $telefono, 
        $email, 
        $ingresos, 
        $egresos, 
        $estado_civil, 
        $lugar_trabajo, 
        $dui, 
        $fiador_id
    );

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

public static function editar($data)
{
    $con = connection();

    // Convertir valores vacíos a valores por defecto o NULL
    $id = $data['id'];
    $nombre = $data['nombre'];
    $direccion = $data['direccion'];
    $telefono = $data['telefono'];
    $email = $data['email'];
    $ingresos = $data['ingresos'] === "" ? 0 : $data['ingresos']; // Si está vacío, se asigna 0
    $egresos = $data['egresos'] === "" ? 0 : $data['egresos']; // Si está vacío, se asigna 0
    $estado_civil = $data['estado_civil'];
    $lugar_trabajo = $data['lugar_trabajo'];
    $dui = $data['dui'];
    $fiador_id = $data['fiador_id'] === "" ? null : $data['fiador_id']; // Si está vacío, se asigna NULL
    $clasificacion_id = $data['clasificacion_id'] === "" ? null : $data['clasificacion_id']; // Si está vacío, se asigna NULL

    $sql = "UPDATE clientesnaturales 
            SET nombre = ?, direccion = ?, telefono = ?, email = ?, 
                ingresos = ?, egresos = ?, estado_civil = ?, 
                lugar_trabajo = ?, dui = ?, fiador_id = ?, clasificacion_id = ? 
            WHERE id = ?";
    $stmt = $con->prepare($sql);
    
    // Vincular parámetros a la consulta
    $stmt->bind_param(
        "ssssddsssiii", 
        $nombre, 
        $direccion, 
        $telefono, 
        $email, 
        $ingresos, 
        $egresos, 
        $estado_civil, 
        $lugar_trabajo, 
        $dui, 
        $fiador_id, 
        $clasificacion_id, 
        $id
    );

    $result = $stmt->execute(); // Ejecutar la consulta
    $stmt->close(); // Cerrar la consulta preparada

    return $result; // Devolver el resultado de la operación
}

    public static function borrar($id)
    {
        $con = connection();
        $sql = "DELETE FROM clientesnaturales WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        
        return $query;
    }

    public static function cambiarEstado($data)
    {

        $con = connection();

        $id = $data['id'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE clientesnaturales SET estado=$estado WHERE id='$id'" : "UPDATE clientesnaturales SET estado='$estado' WHERE id='$id'";
        $query = mysqli_query($con, $sql);

    }

    public static function obtener_cliente($id)
    {
        $con = connection();
        $sql = "SELECT * FROM clientesnaturales WHERE id = '$id'";
        $query = mysqli_query($con, $sql);

        return $query;
    }
}
?>