<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1) {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}

// Conexión a la base de datos
include '../models/conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos
$con = connection();
$productosAlerta = [];
$query = "SELECT p.id, p.codigo, p.nombre, p.stock_minimo, i.stok  
          FROM inventario i 
          INNER JOIN productos p ON p.id = i.producto_id 
          WHERE i.stok <= p.stock_minimo";

$result = $con->query($query); // Ejecutamos la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productosAlerta[] = $row; // Guardamos los productos en un array
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Inicio</title>
    <meta content="Proyecto de análisis financiero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <div class="page">
        <?php include '../layouts/Navbar.php'; ?>
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl mt-4">
                    <h2 class="page-title text-white">Inicio</h2>
                    <br><br><br><br>
                    <!-- Mostrar alertas individuales si hay productos -->
                    <?php if (!empty($productosAlerta)): ?>
                        <?php foreach ($productosAlerta as $producto): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" onclick="window.location.href='generar-compra.php?producto_id=<?php echo $producto['id']; ?>'">
                                <strong>¡Atención!</strong>
                                El producto <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong> tiene stock insuficiente. Debe reabastecer.
                                <br>
                                <small>Stock actual: <?php echo $producto['stok']; ?>, Stock mínimo: <?php echo $producto['stock_minimo']; ?></small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="event.stopPropagation();"></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php include '../layouts/Footer.php'; ?>
    </div>
    <?php include '../layouts/footerScript.php'; ?>
</body>

</html>