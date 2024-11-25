<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '<script>window.location = "../index.php"</script>';
    session_destroy();
    die();
}

include "../controladores/ControladorClasificacion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Clasificaciones</title>
    <?php include '../layouts/headerStyles.php';?>
</head>
<body>
<?php include '../layouts/Navbar.php';?>

<div class="main-panel">
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center" style="font-weight: 700;">Lista de Clasificaciones</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorClasificacion::listar() as $row): ?>
                        <tr>
                            <td><?= $row["nombre"] ?></td>
                            <td><?= $row["descripcion"] ?></td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-warning me-2" onclick='editar(<?=json_encode($row)?>)' data-bs-toggle="modal" data-bs-target="#modalClasificacion">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick='eliminar(<?=json_encode($row)?>)' data-bs-toggle="modal" data-bs-target="#modalClasificacion">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mt-3" onclick="agregar()" data-bs-toggle="modal" data-bs-target="#modalClasificacion">
                    Agregar Clasificación
                </button>
            </div>
        </div>
    </div>
</div>

<?php include '../vistas/Modals/ModalClasificacion.php'; ?> <!-- Incluye el modal aquí -->
<?php include '../layouts/footerScript.php';?>

<script>
function agregar() {
    document.getElementById("modalClasificacionLabel").textContent = "Agregar Clasificación";
    document.getElementById("action").value = "insert";
    document.getElementById("formClasificacion").reset();
    document.getElementById("modalActionButton").textContent = "Agregar";
    document.getElementById("modalActionButton").className = "btn btn-primary";
    document.getElementById("warningDelete").style.display = "none";
}

function editar(data) {
    document.getElementById("modalClasificacionLabel").textContent = "Editar Clasificación";
    document.getElementById("action").value = "editar";
    document.getElementById("clasificacionId").value = data.id;
    document.getElementById("nombre").value = data.nombre;
    document.getElementById("descripcion").value = data.descripcion;
    document.getElementById("modalActionButton").textContent = "Guardar Cambios";
    document.getElementById("modalActionButton").className = "btn btn-warning";
    document.getElementById("warningDelete").style.display = "none";
}

function eliminar(data) {
    document.getElementById("modalClasificacionLabel").textContent = "Eliminar Clasificación";
    document.getElementById("action").value = "borrar";
    document.getElementById("clasificacionId").value = data.id;
    document.getElementById("nombre").value = data.nombre;
    document.getElementById("descripcion").value = data.descripcion;
    document.getElementById("nombre").setAttribute("disabled", "true");
    document.getElementById("descripcion").setAttribute("disabled", "true");
    document.getElementById("modalActionButton").textContent = "Eliminar";
    document.getElementById("modalActionButton").className = "btn btn-danger";
    document.getElementById("warningDelete").style.display = "block";
}

// Reactivar campos cuando el modal se cierre
document.getElementById('modalClasificacion').addEventListener('hidden.bs.modal', function () {
    document.getElementById("nombre").removeAttribute("disabled");
    document.getElementById("descripcion").removeAttribute("disabled");
});
</script>
</body>
</html>
