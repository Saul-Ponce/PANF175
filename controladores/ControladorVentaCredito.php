<?php
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
}

// Manejo de acciones POST
if (isset($_POST["action"])) {
    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $dataArray = json_decode($_POST['data_array'], true);

            // Manejo del archivo 'contrato_venta'
            if (isset($_FILES['contrato_venta']) && $_FILES['contrato_venta']['error'] == 0) {
                $tipoCliente = $_POST['tipo-cliente']; // Natural o Jurídico
                $nombreArchivoOriginal = $_FILES['contrato_venta']['name'];
                $extension = pathinfo($nombreArchivoOriginal, PATHINFO_EXTENSION);
                $rutaTemporal = $_FILES['contrato_venta']['tmp_name'];
                $prefijo = $tipoCliente == 'cliente-natural' ? 'contrato_natural' : 'contrato_juridico';

                // Buscar el último número usado en los archivos
                $directorio = '../contrato/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crear la carpeta si no existe
                }
                $archivosExistentes = glob($directorio . $prefijo . '*.pdf');
                $numeroMax = 0;

                foreach ($archivosExistentes as $archivo) {
                    preg_match('/(\d+)\.pdf$/', $archivo, $matches);
                    if (isset($matches[1])) {
                        $numero = intval($matches[1]);
                        if ($numero > $numeroMax) {
                            $numeroMax = $numero;
                        }
                    }
                }

                $nuevoNumero = $numeroMax + 1;
                $nuevoNombreArchivo = $prefijo . str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT) . '.' . $extension;
                $rutaDestino = $directorio . $nuevoNombreArchivo;

                // Mover el archivo al destino final
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    // Procesar la venta
                    $con = connection();
                    $fecha_venta = mysqli_real_escape_string($con, $_POST['fecha_venta']);
                    $clienteSelect = mysqli_real_escape_string($con, $_POST['clienteSelect']);
                    $dui_emp = mysqli_real_escape_string($con, $_POST['dui_emp']);
                    $total = mysqli_real_escape_string($con, $_POST['total']);

                    VentaCreditoModel::agregar($fecha_venta, $clienteSelect, $dui_emp, $total, $dataArray, $nuevoNombreArchivo);

                    $_SESSION['success_messageV'] = '¡Venta al crédito agregada exitosamente!';
                    header("Location: ../vistas/genera-venta-credito.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Error al mover el archivo.';
                    header("Location: ../vistas/genera-venta-credito.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = 'Error al subir el archivo. Selecciona un archivo válido.';
                header("Location: ../vistas/genera-venta-credito.php");
                exit();
            }
            break;

        // Otros casos
        default:
            break;
    }
}
