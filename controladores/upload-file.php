<?php
$file = $_FILES["imagen_p"]["name"]; // Nombre del archivo

$validator = 1; // Variable validadora

$file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Extensión del archivo

$url_temp = $_FILES["imagen_p"]["tmp_name"]; // Ruta temporal donde se carga el archivo

// dirname(FILE) nos otorga la ruta absoluta hasta el archivo en ejecución
$url_insert = dirname(__FILE__) . "/upload"; // Carpeta donde subiremos nuestros archivos

// Ruta donde se guardará el archivo, usando str_replace para reemplazar "" por "/"
$url_target = str_replace('\\', '/', $url_insert) . '/' . $file;

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
        echo "El archivo " . htmlspecialchars(basename($file)) . " ha sido cargado con éxito.";
    } else {
        echo "Ha habido un error al cargar tu archivo.";
    }
} else {
    echo "Error: el archivo no se ha cargado.";
}
?>