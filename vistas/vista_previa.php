<?php
require_once("../models/conexion.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $con = connection();

    // Consultar el archivo `aval` basado en el ID
    $stmt = $con->prepare("SELECT aval FROM clientesjuridicos WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($fileData);
        $stmt->fetch();
        $stmt->close();
        $con->close();

        // Verificar si se encontró el archivo y configurarlo para la vista previa
        if ($fileData) {
            // Opcional: Determinar el tipo de archivo si se almacena en la base de datos
            // Por ejemplo, almacenar el tipo MIME en otro campo
            header("Content-Type: application/pdf"); // Cambia esto según el tipo real del archivo
            header("Content-Disposition: inline; filename=\"aval.pdf\"");
            echo $fileData;
        } else {
            echo "Archivo no disponible.";
        }
    } else {
        echo "Error en la preparación de la consulta.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
