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
                $nombreArchivo = $_FILES['contrato_venta']['name'];
                $tipoArchivo = $_FILES['contrato_venta']['type'];
                $tamañoArchivo = $_FILES['contrato_venta']['size'];
                $rutaTemporal = $_FILES['contrato_venta']['tmp_name'];

                // Validar el tipo de archivo
                $extensionesPermitidas = array("pdf", "doc", "docx");
                $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

                if (in_array(strtolower($extension), $extensionesPermitidas)) {
                    // Definir la ruta donde se guardará el archivo
                    $rutaDestino = '../contrato/' . uniqid() . '_' . $nombreArchivo;

                    // Verificar que la carpeta de destino exista o crearla
                    if (!file_exists('../contrato/')) {
                        mkdir('../contrato/', 0777, true);
                    }

                    // Mover el archivo subido a la ruta destino
                    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                        // El archivo se ha subido correctamente
                        // Proceder a guardar la venta al crédito

                        // Escapar variables para seguridad
                        $con = connection();
                        $fecha_venta = mysqli_real_escape_string($con, $_POST['fecha_venta']);
                        $clienteSelect = mysqli_real_escape_string($con, $_POST['clienteSelect']);
                        $dui_emp = mysqli_real_escape_string($con, $_POST['dui_emp']);
                        $total = mysqli_real_escape_string($con, $_POST['total']);

                        VentaCreditoModel::agregar($fecha_venta, $clienteSelect, $dui_emp, $total, $dataArray, $rutaDestino);

                        $_SESSION['success_messageV'] = '¡Venta al crédito agregada exitosamente!';
                        header("Location: ../vistas/genera-venta-credito.php");
                        exit();
                    } else {
                        // Ocurrió un error al mover el archivo
                        $_SESSION['error_message'] = 'Error al mover el archivo.';
                        header("Location: ../vistas/genera-venta-credito.php");
                        exit();
                    }
                } else {
                    // Tipo de archivo no permitido
                    $_SESSION['error_message'] = 'Tipo de archivo no permitido. Solo se permiten archivos PDF, DOC y DOCX.';
                    header("Location: ../vistas/genera-venta-credito.php");
                    exit();
                }
            } else {
                // No se subió el archivo o ocurrió un error
                $_SESSION['error_message'] = 'Error al subir el archivo. Por favor, asegúrate de seleccionar un archivo válido.';
                header("Location: ../vistas/genera-venta-credito.php");
                exit();
            }
            break;

        case "editar":
            // Implementar si es necesario
            // VentaCreditoModel::editar($_POST);
            // header("Location: ../vistas/lista-venta-credito.php");
            break;

        case "borrar":
            // Implementar si es necesario
            // VentaCreditoModel::borrar($_POST['id_venta']);
            // header("Location: ../vistas/lista-venta-credito.php");
            break;

        default:
            break;
    }
}
?>
