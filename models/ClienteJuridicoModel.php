<?php
require_once("conexion.php");

class ClienteJuridicoModel
{
    public static function listar()
    {
        $con = connection();
        $sql = "SELECT cj.*, r.nombre AS nombre_representante, r.direccion AS direccion_representante, 
        r.telefono AS telefono_representante, r.email AS email_representante, r.dui AS dui_representante,
        c.nombre AS nombre_clasificacion, c.descripcion AS descripcion_clasificacion
        FROM clientesjuridicos cj 
        LEFT JOIN representante_legal r ON cj.representante_legal = r.id
        LEFT JOIN clasificaciones c ON cj.clasificacion_id = c.id";

        $query = mysqli_query($con, $sql);
        return $query;
    }

    public static function agregar($data, $representanteData)
    {
        $con = connection();

        // Iniciar una transacción para asegurar la integridad de los datos
        $con->begin_transaction();

        try {
            // Escapar y preparar los datos del representante legal
            $nombre_representante = mysqli_real_escape_string($con, $representanteData['nombre_representante']);
            $direccion_representante = mysqli_real_escape_string($con, $representanteData['direccion_representante']);
            $telefono_representante = mysqli_real_escape_string($con, $representanteData['telefono_representante']);
            $email_representante = mysqli_real_escape_string($con, $representanteData['email_representante']);
            $dui_representante = mysqli_real_escape_string($con, $representanteData['dui_representante']);

            // Insertar los datos del representante legal
            $sql_representante = "INSERT INTO representante_legal (nombre, direccion, telefono, email, dui) 
                                VALUES ('$nombre_representante', '$direccion_representante', '$telefono_representante', '$email_representante', '$dui_representante')";
            $result_representante = mysqli_query($con, $sql_representante);

            if (!$result_representante) {
                throw new Exception("Error al insertar representante legal: " . mysqli_error($con));
            }

            // Obtener el ID del representante legal insertado
            $representante_id = mysqli_insert_id($con);

            // Escapar y preparar los datos del cliente jurídico
            $nombre = mysqli_real_escape_string($con, $data['nombre']);
            $direccion = mysqli_real_escape_string($con, $data['direccion']);
            $telefono = mysqli_real_escape_string($con, $data['telefono']);
            $email = mysqli_real_escape_string($con, $data['email']);
            $nit = mysqli_real_escape_string($con, $data['nit']);
            $nrc = mysqli_real_escape_string($con, $data['nrc']);

            // Validar formato de NIT y NRC
            if (!self::validarFormatoNIT($nit)) {
                throw new Exception("Formato de NIT inválido");
            }
            if (!self::validarFormatoNRC($nrc)) {
                throw new Exception("Formato de NRC inválido");
            }

            // Insertar los datos del cliente jurídico con valores predeterminados
            $stmt = $con->prepare("INSERT INTO clientesjuridicos (nombre, direccion, telefono, email, representante_legal, nit, nrc, clasificacion_id, estado) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, 2, 'activo')"); // clasificacion_id = 1 para 'A', estado = 'activo' por defecto
            $stmt->bind_param("ssssiss", $nombre, $direccion, $telefono, $email, $representante_id, $nit, $nrc);

            $result_cliente = $stmt->execute();

            if (!$result_cliente) {
                throw new Exception("Error al insertar cliente jurídico: " . $stmt->error);
            }

            // Confirmar la transacción
            $con->commit();

            return $result_cliente;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $con->rollback();
            throw $e;
        }
    }

    public static function editar($data)
    {
        $con = connection();

        // Escapar y preparar los datos del cliente jurídico
        $id = (int)$data['id'];
        $nombre = mysqli_real_escape_string($con, $data['nombre']);
        $direccion = mysqli_real_escape_string($con, $data['direccion']);
        $telefono = mysqli_real_escape_string($con, $data['telefono']);
        $email = mysqli_real_escape_string($con, $data['email']);
        $nit = mysqli_real_escape_string($con, $data['nit']);
        $nrc = mysqli_real_escape_string($con, $data['nrc']);
        $clasificacion_id = (int)$data['clasificacion_id']; // Asegúrate de que el campo esté presente y sea un entero.

        // Validar formato de NIT y NRC
        if (!self::validarFormatoNIT($nit)) {
            throw new Exception("Formato de NIT inválido");
        }
        if (!self::validarFormatoNRC($nrc)) {
            throw new Exception("Formato de NRC inválido");
        }

        // Actualizar el registro del cliente jurídico
        $stmt = $con->prepare("UPDATE clientesjuridicos 
                           SET nombre = ?, direccion = ?, telefono = ?, email = ?, nit = ?, nrc = ?, clasificacion_id = ? 
                           WHERE id = ?");
        $stmt->bind_param("ssssssii", $nombre, $direccion, $telefono, $email, $nit, $nrc, $clasificacion_id, $id);

        $result_cliente = $stmt->execute();

        if (!$result_cliente) {
            throw new Exception("Error al actualizar cliente jurídico: " . $stmt->error);
        }

        return $result_cliente;
    }


    // Función para validar el formato del NIT
    private static function validarFormatoNIT($nit)
    {
        return preg_match('/^\d{4}-\d{6}-\d{3}-\d{1}$/', $nit);
    }

    // Función para validar el formato del NRC
    private static function validarFormatoNRC($nrc)
    {
        return preg_match('/^\d{6}-\d{1}$/', $nrc);
    }

    public static function editarRepresentante($data)
    {
        $con = connection();

        // Escapar y preparar los datos del representante legal
        $representante_legal_id = (int)$data['representante_legal_id'];
        $nombre_representante = mysqli_real_escape_string($con, $data['nombre_representante']);
        $direccion_representante = mysqli_real_escape_string($con, $data['direccion_representante']);
        $telefono_representante = mysqli_real_escape_string($con, $data['telefono_representante']);
        $email_representante = mysqli_real_escape_string($con, $data['email_representante']);
        $dui_representante = mysqli_real_escape_string($con, $data['dui_representante']);

        $sql = "UPDATE representante_legal SET nombre='$nombre_representante', direccion='$direccion_representante', 
                telefono='$telefono_representante', email='$email_representante', dui='$dui_representante' 
                WHERE id=$representante_legal_id";
        $result = mysqli_query($con, $sql);

        if (!$result) {
            throw new Exception("Error al actualizar representante legal: " . mysqli_error($con));
        }

        return $result;
    }

    public static function cambiarEstado($id, $estado)
    {
        $con = connection();
        $id = (int)$id;
        $nuevo_estado = $estado === 'activo' ? 'incobrable' : 'activo';
        $nuevo_estado = mysqli_real_escape_string($con, $nuevo_estado);

        $sql = "UPDATE clientesjuridicos SET estado='$nuevo_estado' WHERE id=$id";
        $result = mysqli_query($con, $sql);

        if (!$result) {
            throw new Exception("Error al cambiar estado del cliente jurídico: " . mysqli_error($con));
        }

        return $result;
    }
}
