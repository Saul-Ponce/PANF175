<?php

class EmbargoModel
{
    // Método para listar todas las cuentas en embargo
    public static function listarEmbargos()
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            SELECT 
                e.id AS embargo_id,
                c.id AS cuenta_id,
                IFNULL(cn.nombre, cj.nombre) AS cliente,
                c.monto,
                c.saldo,
                e.fecha_embargo,
                e.estado
            FROM 
                embargos e
            INNER JOIN cuentasporcobrar c ON e.cuenta_id = c.id
            LEFT JOIN clientesnaturales cn ON c.cliente_natural_id = cn.id
            LEFT JOIN clientesjuridicos cj ON c.cliente_juridico_id = cj.id
            ORDER BY e.fecha_embargo DESC
        ";

        $result = mysqli_query($con, $sql);

        if (!$result) {
            throw new Exception("Error al listar embargos: " . mysqli_error($con));
        }

        $embargos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $embargos[] = $row;
        }

        $con->close();
        return $embargos;
    }

    // Método para registrar una nueva cuenta en embargo
    public static function registrarEmbargo($cuenta_id, $motivo, $fecha_embargo)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            INSERT INTO embargos (cuenta_id, motivo, fecha_embargo, estado)
            VALUES (?, ?, ?, 'activo')
        ";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación del registro de embargo: " . $con->error);
        }

        $stmt->bind_param("iss", $cuenta_id, $motivo, $fecha_embargo);
        $stmt->execute();

        // Actualizar estado de la cuenta a 'embargo'
        $sqlUpdate = "UPDATE cuentasporcobrar SET estado = 'embargo' WHERE id = ?";
        $stmtUpdate = $con->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $cuenta_id);
        $stmtUpdate->execute();

        $stmt->close();
        $stmtUpdate->close();
        $con->close();
    }

    // Método para cambiar el estado de un embargo
    public static function cambiarEstadoEmbargo($embargo_id, $nuevo_estado)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "UPDATE embargos SET estado = ? WHERE id = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación para cambiar estado: " . $con->error);
        }

        $stmt->bind_param("si", $nuevo_estado, $embargo_id);
        $stmt->execute();

        $stmt->close();
        $con->close();
    }

    // Método para verificar y actualizar automáticamente cuentas por cobrar a embargo
    public static function verificarYActualizarEmbargos()
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        try {
            // Seleccionar cuentas vencidas según su plazo y estado
            $sql = "
                SELECT id, DATEDIFF(NOW(), fecha_vencimiento) AS dias_vencidos
                FROM cuentasporcobrar
                WHERE estado = 'pendiente' AND saldo > 0
            ";

            $result = $con->query($sql);

            if (!$result) {
                throw new Exception("Error al obtener cuentas pendientes: " . $con->error);
            }

            while ($row = $result->fetch_assoc()) {
                $diasVencidos = $row['dias_vencidos'];
                $cuentaId = $row['id'];

                // Si los días vencidos exceden un umbral (por ejemplo, 90 días)
                if ($diasVencidos >= 90) {
                    // Registrar el embargo
                    $motivo = "Vencido por más de 90 días";
                    $fechaEmbargo = date('Y-m-d');

                    self::registrarEmbargo($cuentaId, $motivo, $fechaEmbargo);
                }
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            $con->close();
        }
    }
}
