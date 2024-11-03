<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}

include "../controladores/ControladorClienteJuridico.php";
include_once "../models/ClienteJuridicoModel.php";
include_once "../models/ClasificacionModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Clientes Jurídicos</title>
    <meta content="Proyecto de análisis financiero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php';?>
</head>

<body>
    <?php include '../layouts/Navbar.php';?>

    <div class="main-panel">
        <div class="container-fluid mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Clientes Jurídicos</h3>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">
                                    Nombre</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Dirección</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Teléfono</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Correo Electrónico</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Representante Legal</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Clasificación</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = ControladorClienteJuridico::listar();
                            foreach ($resultado as $row): ?>
                            <tr>
                                <td><?= $row["nombre"] ?></td>
                                <td><?= $row["direccion"] ?></td>
                                <td><?= $row["telefono"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["representante_legal"] ?></td>
                                <td><?= $row["clasificacion_id"] ?></td>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarClienteJuridico<?php echo $row['id']; ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="btn <?= $row["estado"] ? 'btn-danger' : 'btn-success' ?> mx-2" data-bs-toggle="modal" data-bs-target="#estadoClienteJuridico<?php echo $row['id']; ?>">
                                            <?= $row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' : '<i class="fa fa-user" aria-hidden="true"></i>' ?>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarClienteJuridico<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </th>
                            </tr>

                            <?php include '../vistas/Modals/ModalEditarClienteJuridico.php'; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>

    <?php foreach ($resultado as $row): ?>
      ¨  <?php //include '../vistas/Modals/ModalEstadoClienteJuridico.php'; ?>
      <?php include '../vistas/Modals/ModalEliminarClienteJuridico.php'; ?>
    <?php endforeach; ?>

    <script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageC'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageC']); // Clear the message ?>
    <?php endif; ?>
    </script>
</body>

</html>
