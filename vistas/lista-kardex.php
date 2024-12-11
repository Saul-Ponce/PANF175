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
include "../controladores/ControladorKardex.php";
include_once "../models/KardexModel.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kardex</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../public/assets/libs/datatables/datatables.min.js"></script>
    <div class="main-panel">
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Kardex</h3>
                    <div class="table-responsive">
                        <table id="tabla-kardex" class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Fecha</th>
                                    <th style="font-size:13px !important;" scope="col">Producto</th>
                                    <th style="font-size:13px !important;" scope="col">Entrada</th>
                                    <th style="font-size:13px !important;" scope="col">Salida</th>
                                    <th style="font-size:13px !important;" scope="col">Existencia</th>
                                    <th style="font-size:13px !important;" scope="col">Precio unitario</th>
                                    <th style="font-size:13px !important;" scope="col">Costo total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorKardex::listar();
                                while ($row = mysqli_fetch_assoc($resultado)):
                                ?>
                                    <tr>
                                        <td><?= $row["fecha"] ?></td>
                                        <td><?= $row["producto"] ?></td>
                                        <td><?= $row["Entrada"] ?></td>
                                        <td><?= $row["Salida"] ?></td>
                                        <td><?= $row["Existencia"] ?></td>
                                        <td><?= $row["Costo_Unitario"] ?></td>
                                        <td><?= $row["Costo_Total"] ?></td>
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
        $(document).ready(function() {
            $('#tabla-kardex').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageP'])): ?>
            Swal.fire('<?php echo $_SESSION['success_messageP']; ?>', '', 'success');
            <?php unset($_SESSION['success_messageP']); // Clear the message 
            ?>
        <?php endif; ?>
    </script>
</body>

</html>