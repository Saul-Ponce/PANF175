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
    public static function obtenercategoria($id)
    {

        $respuesta = ProductoModel::obtener_categoria($id);
        return $respuesta;
    }
}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $file = $_FILES["imagen"]["name"]; // Nombre del archivo

            $validator = 1; // Variable validadora

            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Extensión del archivo

            $url_temp = $_FILES["imagen"]["tmp_name"]; // Ruta temporal donde se carga el archivo

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
            $file_size = $_FILES["imagen"]["size"];
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
                    ProductoModel::agregar($_POST['nombre'], $_POST['descripcion'], $_POST['cat_id'], 'upload/' . $nuevo_nombre, $_POST['marca'], $_POST['modelo'], $_POST['stock'], $_POST['codigo'], $_POST['clasificacion'], $_POST['stockmax']);
                    header("Location: ../vistas/lista-producto.php");
                } else {
                    echo "Ha habido un error al cargar tu archivo.";
                }
            } else {
                echo "Error: el archivo no se ha cargado.";
            }
            break;

        case "editar":
            $file = $_FILES["imagen"]["name"]; // Nombre del archivo

            $validator = 1; // Variable validadora

            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Extensión del archivo

            $url_temp = $_FILES["imagen"]["tmp_name"]; // Ruta temporal donde se carga el archivo

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
            $file_size = $_FILES["imagen"]["size"];
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
                ProductoModel::editar($_POST, null);
                header("Location: ../vistas/lista-producto.php");
            }

            break;

        case "borrar":
            ProductoModel::borrar($_POST['id']);
            header("Location: ../vistas/lista-producto.php");
            break;

            case "cambiarEstado":
                ProductoModel::cambiarEstado($_POST);
                header("Location: ../vistas/lista-producto.php");
                break;

        default:

            break;
    }
}
