<?php
// controladores/ControladorVentaCredito.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../models/VentaCreditoModel.php');

class ControladorVentaCredito
{
    public static function listar()
    {
        $respuesta = VentaCreditoModel::listar();
        return $respuesta;
    }

    public static function listarDet($id)
    {
        $respuesta = VentaCreditoModel::listarDet($id);
        return $respuesta;
    }

    public static function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Corrección del nombre de la variable: 'total_venta' a 'total'
                $fecha_venta = $_POST['fecha_venta'];
                $tipo_venta = $_POST['tipo_venta'];
                $tipo_cliente = $_POST['tipo_cliente'];
                $cliente = $_POST['clienteSelect'];
                $usuario = $_POST['usuario_id'];
                $total = $_POST['total']; // Cambio aquí
                $data = json_decode($_POST['data_array'], true);
                $plazo = $_POST['plazo'];
                $interes = $_POST['tasa_interes'];
                $monto_total_interes = $_POST['monto_total_interes'];

                // Manejo del archivo aval
                if (isset($_FILES['aval']) && $_FILES['aval']['error'] == 0) {
                    $tipoCliente = ($tipo_cliente === 'natural') ? 'natural' : 'juridico';

                    $extension = strtolower(pathinfo($_FILES['aval']['name'], PATHINFO_EXTENSION));

                    // Validar que la extensión sea PDF
                    if ($extension !== 'pdf') {
                        throw new Exception("El archivo del aval debe ser un PDF.");
                    }

                    $prefijo = "contrato_" . $tipoCliente . "_";
                    $directorio = '../controladores/contrato/';
                    if (!file_exists($directorio)) {
                        if (!mkdir($directorio, 0777, true)) {
                            throw new Exception("No se pudo crear el directorio para contratos.");
                        }
                    }

                    // Generar un nombre de archivo único usando uniqid
                    $unique_id = uniqid('', true); // Más único con más entropía
                    $nombreArchivo = $prefijo . $unique_id . '.' . $extension;
                    $rutaDestino = $directorio . $nombreArchivo;

                    // Mover el archivo
                    if (!move_uploaded_file($_FILES['aval']['tmp_name'], $rutaDestino)) {
                        throw new Exception("Error al subir el archivo del aval.");
                    }
                } else {
                    throw new Exception("Error al subir el archivo del aval.");
                }

                // Agregar la venta al crédito
                // Asegúrate de que VentaCreditoModel::agregar recibe los parámetros correctos
                $venta_id = VentaCreditoModel::agregar($fecha_venta, $tipo_venta, $tipo_cliente, $cliente, $usuario, $total, $data, $nombreArchivo, $plazo, $interes, $monto_total_interes);

                $_SESSION['success_messageC'] = '¡Venta al crédito agregada exitosamente!';
                header("Location: ../vistas/lista-venta-credito.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
                header("Location: ../vistas/genera-venta-credito.php");
                exit();
            }
        }
    }

    public static function verDetalle()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ver-det') {
        $id = intval($_POST['id']); // Asegurar que sea un entero
        try {
            // Llama al método `listarDet` del modelo para obtener los datos
            $detalle = VentaCreditoModel::listarDet($id);

            echo json_encode([
                'error' => false,
                'detalles' => $detalle // Aquí se pasa la tabla generada por el modelo
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ver-contrato') {
        $id = intval($_POST['id']); // Asegurar que sea un entero
        // Obtener el contrato basado en la venta
        $con = connection();
        // Utilizar consultas preparadas para evitar inyección SQL
        $stmt = $con->prepare("SELECT aval FROM ventas WHERE id = ? AND tipo_venta = 'credito' LIMIT 1");
        if (!$stmt) {
            echo json_encode(['error' => true, 'message' => 'Error en la preparación de la consulta.']);
            exit();
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rutaContrato = "../controladores/contrato/" . $row['aval'];
            if (file_exists($rutaContrato)) {
                // Convertir la ruta a una URL accesible
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || 
                             $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $host = $_SERVER['HTTP_HOST'];
                // Asegurar que la URL sea correcta dependiendo de la estructura de directorios
                $ruta_contrato_url = $protocol . $host . "/controladores/contrato/" . $row['aval'];

                echo json_encode([
                    'error' => false,
                    'ruta_contrato' => $ruta_contrato_url
                ]);
            } else {
                echo json_encode(['error' => true, 'message' => 'Contrato no encontrado']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Venta no encontrada o no es al crédito']);
        }
        $stmt->close();
        exit();
    }
}

}

if (isset($_POST["action"]) && $_POST["action"] == 'insert') {
    ControladorVentaCredito::agregar();
} else {
    ControladorVentaCredito::verDetalle();
}
?>
