<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}
include "../controladores/ControladorInventario.php";
include_once "../models/InventarioModel.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lista de inventario</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Inventario</h3>
                    <!-- Sección de explicaciones de las bolitas en línea -->
                    <div class="text-center mt-3">
                        <span style="width: 12px; height: 12px; border-radius: 50%; display: inline-block; background-color: red;"></span>
                        <strong> Stock insuficiente, es necesario reabastecer.</strong> &nbsp;
                        <span style="width: 12px; height: 12px; border-radius: 50%; display: inline-block; background-color: green;"></span>
                        <strong> Stock adecuado, dentro del rango permitido.</strong> &nbsp;
                        <span style="width: 12px; height: 12px; border-radius: 50%; display: inline-block; background-color: orange;"></span>
                        <strong> Stock excesivo, podría necesitar revisión.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Clasificacion</th>
                                    <th style="font-size:13px !important;" scope="col">Codigo</th>
                                    <th style="font-size:13px !important;" scope="col">Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Descripcion</th>
                                    <th style="font-size:13px !important;" scope="col">Stok</th>
                                    <th style="font-size:13px !important;" scope="col">Precio unitario</th>
                                    <th style="font-size:13px !important;" scope="col">Alerta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorInventario::listar();
                                while ($row = mysqli_fetch_assoc($resultado)):
                                    // Lógica de las alertas
                                    $stok = $row["stok"];
                                    $stok_minimo = $row["stock_minimo"];
                                    $stok_maximo = $row["stok_maximo"];

                                    // Determinar el tipo de alerta
                                    if ($stok >= $stok_maximo) {
                                        $alertaColor = "orange";  // Rojo
                                    } elseif ($stok >= $stok_minimo && $stok <= $stok_maximo) {
                                        $alertaColor = "green";  // Verde
                                    } else {
                                        $alertaColor = "red";  // Naranja
                                    }
                                ?>
                                    <tr>
                                        <td><?= $row["clasificacion"] ?></td>
                                        <td><?= $row["codigo"] ?></td>
                                        <td><?= $row["nombre"] ?></td>
                                        <td><?= $row["descripcion"] ?></td>
                                        <td><?= $row["stok"] ?></td>
                                        <td><?= $row["precio_venta"] ?></td>
                                        <td>
                                            <!-- Bolita de color según la alerta -->
                                            <span style="width: 12px; height: 12px; border-radius: 50%; display: inline-block; background-color: <?= $alertaColor ?>;"></span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <?php include '../layouts/Footer.php'; ?>
    </div>
    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>
    <script>
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageP'])): ?>
            Swal.fire('<?php echo $_SESSION['success_messageP']; ?>', '', 'success');
            <?php unset($_SESSION['success_messageP']); // Clear the message 
            ?>
        <?php endif; ?>
    </script>
</body>

</html>