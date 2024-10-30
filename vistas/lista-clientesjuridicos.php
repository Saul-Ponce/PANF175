<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html";
    </script>
    ';
    session_destroy();
    die();
}
require_once("../models/conexion.php");
include("../models/ClienteJuridicoModel.php");
include("../models/ClasificacionModel.php");
include("../controladores/ControladorClienteJuridico.php");

// Obtener las clasificaciones fuera del ciclo de los clientes
$clasificaciones = ClasificacionModel::listar();
$listaClasificaciones = [];
while ($clasificacion = mysqli_fetch_assoc($clasificaciones)) {
    $listaClasificaciones[] = $clasificacion;
}

$clientes = ControladorClienteJuridico::listar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes Jurídicos</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />

    <!-- Core JS Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include("../includes/sidebar.php"); ?>
    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Clientes Jurídicos</h3>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">NOMBRE</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">DIRECCIÓN</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">TELÉFONO</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">CORREO ELECTRÓNICO</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">REPRESENTANTE LEGAL</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $row) : ?>
                                <tr>
                                    <td><?= $row["nombre"] ?></td>
                                    <td><?= $row["direccion"] ?></td>
                                    <td><?= $row["telefono"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["representante_legal"] ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarClienteJuridico<?php echo $row['id']; ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarClienteJuridico<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal para editar cliente jurídico -->
                                <div class="modal fade" id="editarClienteJuridico<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar Cliente Jurídico</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../controladores/ControladorClienteJuridico.php" method="POST" name="form">
                                                    <input type="hidden" name="action" value="editar">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="nombre" class="col-form-label">Nombre de la Empresa</label>
                                                            <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="direccion" class="col-form-label">Dirección</label>
                                                            <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="telefono" class="col-form-label">Teléfono</label>
                                                            <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono']; ?>" maxlength="15" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="email" class="col-form-label">Correo Electrónico</label>
                                                            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="representante_legal" class="col-form-label">Representante Legal</label>
                                                            <input type="text" name="representante_legal" class="form-control" value="<?php echo $row['representante_legal']; ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="aval" class="col-form-label">Aval</label>
                                                            <input type="text" name="aval" class="form-control" value="<?php echo $row['aval']; ?>">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="clasificacion_id" class="col-form-label">Clasificación</label>
                                                            <select class="form-control" id="clasificacion_id" name="clasificacion_id" required>
                                                                <option value="" disabled>Seleccione una clasificación</option>
                                                                <?php foreach ($listaClasificaciones as $clasificacion) : ?>
                                                                    <option value="<?php echo $clasificacion['id']; ?>" <?php echo $clasificacion['id'] == $row['clasificacion_id'] ? 'selected' : ''; ?>>
                                                                        <?php echo $clasificacion['nombre']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="estado" class="col-form-label">Estado</label>
                                                            <select class="form-control" id="estado" name="estado" required>
                                                                <option value="activo" <?php echo $row['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                                                <option value="inactivo" <?php echo $row['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin del modal editar cliente jurídico -->

                                <!-- Modal para eliminar cliente jurídico -->
                                <div class="modal fade" id="eliminarClienteJuridico<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">¿Seguro que desea eliminar este cliente jurídico?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="../controladores/ControladorClienteJuridico.php" method="POST">
                                                <input type="hidden" name="action" value="borrar">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="modal-body">
                                                    <p>Nombre: <strong><?php echo $row['nombre']; ?></strong></p>
                                                    <p>Dirección: <strong><?php echo $row['direccion']; ?></strong></p>
                                                    <p>Representante Legal: <strong><?php echo $row['representante_legal']; ?></strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin del modal eliminar cliente jurídico -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageC'])) : ?>
            Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
            <?php unset($_SESSION['success_messageC']); // Clear the message 
            ?>
        <?php endif; ?>
    </script>

</body>

</html>