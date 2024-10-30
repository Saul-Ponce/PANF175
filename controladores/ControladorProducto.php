<?php
date_default_timezone_set('America/El_Salvador');
require_once '../models/ProductoModel.php';

class ControladorProducto
{

    public static function listar()
    {

        $respuesta = ProductoModel::listar();
        return $respuesta;
    }
}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $file = $_FILES["imagen_p"]["name"]; // Nombre del archivo

            $validator = 1; // Variable validadora

            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Extensión del archivo

            $url_temp = $_FILES["imagen_p"]["tmp_name"]; // Ruta temporal donde se carga el archivo

            $nuevo_nombre = uniqid() . '.' . $file_type;

            // dirname(FILE) nos otorga la ruta absoluta hasta el archivo en ejecución
            $url_insert = dirname(__FILE__) . "/upload"; // Carpeta donde subiremos nuestros archivos

            // Ruta donde se guardará el archivo, usando str_replace para reemplazar "" por "/"
            $url_target = str_replace('\\', '/', $url_insert) . '/' . $nuevo_nombre;

            // Si la carpeta no existe, la creamos
            if (!file_exists($url_insert)) {
                mkdir($url_insert, 0777, true);
            }

            // Validamos el tamaño del archivo (1 MB en este caso)
            $file_size = $_FILES["imagen_p"]["size"];
            if ($file_size > 1000000) {
                echo "El archivo es muy pesado. Tamaño máximo permitido es 1MB.";
                $validator = 0;
            }

            // Validamos la extensión del archivo (jpg, jpeg, png, gif)
            if (!in_array($file_type, ["jpg", "jpeg", "png", "gif"])) {
                echo "Solo se permiten imágenes tipo JPG, JPEG, PNG y GIF.";
                $validator = 0;
            }

            // Movemos el archivo de la carpeta temporal a la carpeta objetivo y verificamos si fue exitoso
            if ($validator == 1) {
                if (move_uploaded_file($url_temp, $url_target)) {
                    $correlativo = "001"; // Correlativo autoincremental, inicializado a "001"
                    $ultimo_correlativo = ProductoModel::obtener_ultimocorrelativo();
                    if ($ultimo_correlativo->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($ultimo_correlativo)) {

                            $correlativoComoEntero = (int) $row["ultimo_correlativo"]; // Convertir a entero
                            $correlativoComoEntero++; // Incrementar
                            // Formatear nuevamente como string de tres dígitos, rellenando con ceros si es necesario
                            $nuevoCorrelativo = str_pad($correlativoComoEntero, 3, '0', STR_PAD_LEFT);
                            $correlativo = $nuevoCorrelativo;
                        }
                    }
                    $precio_producto = $_POST['precio']; // Obtener el precio del formulario
                    $fecha_actual = date("dmY"); // Obtener la fecha actual en el formato deseado

                    // Formatear el precio con dos ceros al inicio si es menor a 100
                    $precio_formateado = str_pad(str_replace('.', '', $precio_producto), 5, '0', STR_PAD_LEFT);

                    // Construir el código del producto
                    $codigo_producto = $precio_formateado . $fecha_actual . $correlativo;

                    ProductoModel::agregar($codigo_producto, $_POST['nombre_p'], $_POST['marca'], $_POST['precio'], $_POST['stock'], $_POST['categoria'], $_POST['proveedor'], 'upload/' . $nuevo_nombre);

                    header("Location: ../vistas/producto.php");
                } else {
                    echo "Ha habido un error al cargar tu archivo.";
                }
            } else {
                echo "Error: el archivo no se ha cargado.";
            }
            break;

        case "editar":
            $file = $_FILES["imagen_p"]["name"]; // Nombre del archivo

            $validator = 1; // Variable validadora

            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Extensión del archivo

            $url_temp = $_FILES["imagen_p"]["tmp_name"]; // Ruta temporal donde se carga el archivo

            $nuevo_nombre = uniqid() . '.' . $file_type;

            // dirname(FILE) nos otorga la ruta absoluta hasta el archivo en ejecución
            $url_insert = dirname(__FILE__) . "/upload"; // Carpeta donde subiremos nuestros archivos

            // Ruta donde se guardará el archivo, usando str_replace para reemplazar "" por "/"
            $url_target = str_replace('\\', '/', $url_insert) . '/' . $nuevo_nombre;

            // Si la carpeta no existe, la creamos
            if (!file_exists($url_insert)) {
                mkdir($url_insert, 0777, true);
            }

            // Validamos el tamaño del archivo (1 MB en este caso)
            $file_size = $_FILES["imagen_p"]["size"];
            if ($file_size > 1000000) {
                echo "El archivo es muy pesado. Tamaño máximo permitido es 1MB.";
                $validator = 0;
            }

            // Validamos la extensión del archivo (jpg, jpeg, png, gif)
            if (!in_array($file_type, ["jpg", "jpeg", "png", "gif"])) {
                echo "Solo se permiten imágenes tipo JPG, JPEG, PNG y GIF.";
                $validator = 0;
            }

            // Movemos el archivo de la carpeta temporal a la carpeta objetivo y verificamos si fue exitoso
            if ($validator == 1) {
                if (move_uploaded_file($url_temp, $url_target)) {

                    ProductoModel::editar($_POST, 'upload/' . $nuevo_nombre);

                    header("Location: ../vistas/lista-producto.php");
                } else {
                    echo "Ha habido un error al cargar tu archivo.";
                }
            } else {
                ProductoModel::editar($_POST);
                header("Location: ../vistas/lista-producto.php");
            }

            break;

        case "borrar":
            ProductoModel::borrar($_POST['codigo_producto']);
            header("Location: ../vistas/lista-producto.php");
            break;

        default:

            break;
    }
}
