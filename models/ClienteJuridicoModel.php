<?php
require_once("conexion.php");

class ClienteJuridicoModel
{
    public static function listar()
    {
        $con = connection();
        $sql = "SELECT * FROM clientesjuridicos";
        $query = mysqli_query($con, $sql);

        return $query;
    }

    public static function agregar($nombre, $direccion, $telefono, $email, $representante_legal, $aval, $clasificacion_id, $estado)
    {
        $con = connection();
        $sql = "INSERT INTO clientesjuridicos (nombre, direccion, telefono, email, representante_legal, aval, clasificacion_id, estado) 
                VALUES ('$nombre', '$direccion', '$telefono', '$email', '$representante_legal', '$aval', '$clasificacion_id', '$estado')";
        $query = mysqli_query($con, $sql);
        
        return $query;
    }

    public static function editar($data)
    {
        $con = connection();

        $id = $data['id'];
        $nombre = $data['nombre'];
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];
        $email = $data['email'];
        $representante_legal = $data['representante_legal'];
        $aval = $data['aval'];
        $clasificacion_id = $data['clasificacion_id'];
        $estado = $data['estado'];

        $sql = "UPDATE clientesjuridicos 
                SET nombre='$nombre', direccion='$direccion', telefono='$telefono', email='$email', 
                    representante_legal='$representante_legal', aval='$aval', clasificacion_id='$clasificacion_id', estado='$estado' 
                WHERE id='$id'";
        $query = mysqli_query($con, $sql);

        return $query;
    }

    public static function borrar($id)
    {
        $con = connection();
        $sql = "DELETE FROM clientesjuridicos WHERE id='$id'";
        $query = mysqli_query($con, $sql);
        
        return $query;
    }

    public static function obtener_cliente($id)
    {
        $con = connection();
        $sql = "SELECT * FROM clientesjuridicos WHERE id = '$id'";
        $query = mysqli_query($con, $sql);

        return $query;
    }
}
?>
