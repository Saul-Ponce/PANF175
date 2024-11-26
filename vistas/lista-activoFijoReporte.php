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
include "../controladores/ControladorActivoFijo.php";
include_once "../models/ActivoFijoModel.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Catalogo activo fijo</title>
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
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Activo fijo</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Fecha registro</th>
                                    <th style="font-size:13px !important;" scope="col">Codigo</th>
                                    <th style="font-size:13px !important;" scope="col">Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Fecha adquisicion</th>
                                    <th style="font-size:13px !important;" scope="col">Valor</th>
                                    <th style="font-size:13px !important;" scope="col">Depreciacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorActivoFijo::listar();
                                while ($row = mysqli_fetch_assoc($resultado)): ?>
                                    <tr>
                                        <td><?= $row["fecha_registro"] ?></td>
                                        <td><?= $row["codigo"] ?></td>
                                        <td><?= $row["nombre"] ?></td>
                                        <td><?= $row["fecha_adquisicion"] ?></td>
                                        <td><?= "$" . number_format($row["valor_adquisicion"], 2) ?></td>
                                        <th>
                                            <div class="d-flex justify-content-center">
                                                <!-- Botón para la depreciación lineal -->
                                                <button class="btn btn-danger me-1" data-bs-toggle="modal"
                                                    title="Aplicar Depreciación Lineal"
                                                    data-bs-target="#mdActivofijoLineal" onclick='Lineal(<?= $row["id_activo"] ?>)'>
                                                    <i class="fa-solid fa-arrow-down" aria-label="Depreciación Lineal"></i> <!-- Icono de flecha hacia abajo representando la disminución constante -->
                                                </button>

                                                <!-- Botón para la depreciación porcentual -->
                                                <button class="btn btn-secondary" title="Aplicar Depreciación Porcentual" data-bs-toggle="modal"
                                                    data-bs-target="#mdActivofijoPorcentual" onclick='porcentual(<?= $row["id_activo"] ?>)'>
                                                    <i class="fa-solid fa-percent" aria-label="Depreciación Porcentual"></i> <!-- Icono de porcentaje representando la depreciación porcentual -->
                                                </button>

                                            </div>
                                        </th>
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
    <?php include '../vistas/Modals/ModalActivoFijoPorcentual.php'; ?>
    <?php include '../vistas/Modals/ModalActivoFijoLineal.php'; ?>
    <script>
        // Función para abrir el modal "Lineal"
        function Lineal(id) {
            const url = new URL(window.location.href);
            url.searchParams.set('id', id);
            url.searchParams.set('modal', 'lineal'); // Añadir parámetro modal
            // Limpiar cualquier hash existente antes de agregar uno nuevo
            url.hash = 'mdActivofijoLineal';
            window.location.href = url.toString();
        }

        // Función para abrir el modal "Porcentual"
        function porcentual(id) {
            const url = new URL(window.location.href);
            url.searchParams.set('id', id);
            url.searchParams.set('modal', 'porcentual'); // Añadir parámetro modal
            // Limpiar cualquier hash existente antes de agregar uno nuevo
            url.hash = 'mdActivofijoPorcentual';
            window.location.href = url.toString();
        }

        // Controlar cuál modal abrir según el parámetro 'modal' de la URL
        window.addEventListener('load', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const modalType = urlParams.get('modal'); // Obtener el tipo de modal
            const id = urlParams.get('id'); // Obtener el ID

            if (modalType === 'lineal' && id) {
                const modalElement = new bootstrap.Modal(document.getElementById('mdActivofijoLineal'));
                modalElement.show();
            } else if (modalType === 'porcentual' && id) {
                const modalElement = new bootstrap.Modal(document.getElementById('mdActivofijoPorcentual'));
                modalElement.show();
            }
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