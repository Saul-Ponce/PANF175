<?php
include_once "../controladores/ControladorCompra.php";

// Set content type to JSON and prevent output buffering issues
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if 'id_compra' parameter is provided
if (!isset($_GET['id_compra'])) {
    echo json_encode(['error' => 'ID de compra no proporcionado']);
    exit; // Exit to prevent further output
}

$id_compra = $_GET['id_compra'];

// Fetch related detallecompra records
$resultado = ControladorCompra::listarDet($id_compra);

// Initialize an array to hold the details
$detallecompra = [];
if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $detallecompra[] = $row;
    }

    // Return JSON response
    echo json_encode($detallecompra);
} else {
    // Return an empty array if no records are found
    echo json_encode([]);
}
exit; // Ensure no further output
?>
