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

include "../controladores/ControladorClienteNatural.php";
include_once "../models/ClienteNaturalModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lista de Clientes Naturales</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php';?>

<style>
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* For smooth scrolling on iOS */
}

</style>

<style>
    table td{
     padding:.5em; /* Not essential for this answer, just a little buffer for the jsfiddle */
}

.forcedWidth{
    width:200px;
    word-wrap:break-word;
    display:inline-block;
}
</style>

</head>

<body>
    <?php include '../layouts/Navbar.php';?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../public/assets/libs/datatables/datatables.min.js"></script>

    <div class="main-panel">
        <div class="container-fluid mt-4 ">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Clientes Naturales</h3>
                    <table id="tabla-clienteNat" class="table table-bordered ">
                        <thead>
                            <tr>
                                <td class="font-weight: 700; font-size:10px; text-align: center!important;" 
                                    scope="col">Nombre</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Direccion</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Telefono</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Email</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Ingresos</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Egresos</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Estado civil</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Lugar de trabajo</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">DUI</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Fiador</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Clasificación</th>
                                    <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Estado</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">acciones</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $resultado = ControladorClienteNatural::listar();
    while ($row = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?=$row["nombre"]?></td>
            <td><?=$row["direccion"]?></td>
            <td><?=$row["telefono"]?></td>
            <td><?=$row["email"]?></td>
            <td>
                <?= $row["ingresos"] > 0 ? "$" . number_format($row["ingresos"], 2) : '' ?>
            </td>
            <td>
                <?= $row["egresos"] > 0 ? "$" . number_format($row["egresos"], 2) : '' ?>
            </td>
            <td><?=$row["estado_civil"]?></td>
            <td><?=$row["lugar_trabajo"]?></td>
            <td><?=$row["dui"]?></td>
            <td>
                <?php if (!empty($row["fiador_id"])): ?>
                    <button type="button" class="btn btn-primary" 
                        onclick='verFiador(<?=json_encode($row)?>)' 
                        data-bs-toggle="modal" data-bs-target="#mdverF">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                <?php endif; ?>
            </td>
            <td>
                <?php
                $clasificacion = $row["clasificacion_nombre"];
                if ($clasificacion == 'A') {
                    echo '<span class="badge bg-green text-green-fg">A</span>';
                } elseif ($clasificacion == 'B') {
                    echo '<span class="badge bg-yellow text-yellow-fg">B</span>';
                } elseif ($clasificacion == 'C') {
                    echo '<span class="badge bg-orange text-orange-fg">C</span>';
                } elseif ($clasificacion == 'D') {
                    echo '<span class="badge bg-red text-red-fg">D</span>';
                }
                ?>
            </td>
            <td>
                <?= $row["estado"] ? '<span class="badge bg-green text-green-fg">Activo</span>' : '<span class="badge bg-red text-red-fg">Incobrable</span>' ?>
            </td>
            <th>
                <div class="d-flex justify-content-center">
                    <button type="button" onclick='editar(<?=json_encode($row)?>)'
                        id="btn-editar" class="btn btn-warning me-2" data-bs-toggle="modal"
                        data-bs-target="#mdCN">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>

                    <button class="btn <?=$row["estado"] ? 'btn-danger' : 'btn-success'?> me-2"
                        data-bs-toggle="modal" data-bs-target="#mdCN"
                        onclick='cambiarEstado(<?=json_encode($row)?>)'>
                        <?=$row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' : '<i class="fa fa-user" aria-hidden="true"></i>'?>
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#mdCN" onclick='eliminar(<?=json_encode($row)?>)'>
                        <i class="fa-solid fa-trash"></i>
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

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php';?>

    <?php include '../vistas/Modals/ModalClienteNatural.php';?>
    <?php include '../vistas/Modals/ModalVerF.php';?>

    


    <script>


$(document).ready(function() {
            $('#tabla-clienteNat').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });


    function editar(data) {
        document.getElementById("nombre").removeAttribute("disabled", "");
        document.getElementById("direccion").removeAttribute("disabled", "");
        document.getElementById("telefono").removeAttribute("disabled", "");
        document.getElementById("email").removeAttribute("disabled", "");
        document.getElementById("ingresos").removeAttribute("disabled", "");
        document.getElementById("egresos").removeAttribute("disabled", "");
        document.getElementById("estado_civil").removeAttribute("disabled", "");
        document.getElementById("lugar_trabajo").removeAttribute("disabled", "");
        document.getElementById("dui").removeAttribute("disabled", "");
        document.getElementById("estado").removeAttribute("disabled", "");
        document.getElementById("fiador_id").removeAttribute("disabled", "");
        document.getElementById("clasificacion_id").removeAttribute("disabled", "");
        
        
        

        document.getElementById("action").value = "editar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("direccion").value = data.direccion || "";
        document.getElementById("telefono").value = data.telefono || "";
        document.getElementById("email").value = data.email || "";
        document.getElementById("ingresos").value = data.ingresos || "";
        document.getElementById("egresos").value = data.egresos || "";
        document.getElementById("estado_civil").value = data.estado_civil || "";
        document.getElementById("lugar_trabajo").value = data.lugar_trabajo || "";
        document.getElementById("dui").value = data.dui || "";
        document.getElementById("estado").value = data.estado || "";
        document.getElementById("fiador_id").value = data.fiador_id || "";
        document.getElementById("clasificacion_id").value = data.clasificacion_id || "";
        document.getElementById("enviar").innerHTML = "Guardar Cambios";
        document.getElementById("enviar").classList.remove('btn-danger');
        document.getElementById("enviar").classList.add('btn-primary');

    }

    function cambiarEstado(data) {
        document.getElementById("titulo").innerHTML = data.estado == "1" ?
            '¿SEGURO QUE DESEA DAR DE BAJA A ESTE USUARIO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE CLIENTE?';

        document.getElementById("nombre").setAttribute("disabled", "");
        document.getElementById("direccion").setAttribute("disabled", "");
        document.getElementById("telefono").setAttribute("disabled", "");
        document.getElementById("email").setAttribute("disabled", "");
        document.getElementById("ingresos").setAttribute("disabled", "");
        document.getElementById("egresos").setAttribute("disabled", "");
        document.getElementById("estado_civil").setAttribute("disabled", "");
        document.getElementById("lugar_trabajo").setAttribute("disabled", "");
        document.getElementById("dui").setAttribute("disabled", "");
        
        document.getElementById("fiador_id").setAttribute("disabled", "");
        document.getElementById("clasificacion_id").setAttribute("disabled", "");

        document.getElementById("action").value = "cambiarEstado";
        document.getElementById("id").value = data.id || "";
        document.getElementById("estado").value = data.estado == 1 ? false : true || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("direccion").value = data.direccion || "";
        document.getElementById("telefono").value = data.telefono || "";
        document.getElementById("email").value = data.email || "";
        document.getElementById("ingresos").value = data.ingresos || "";
        document.getElementById("egresos").value = data.egresos || "";
        document.getElementById("estado_civil").value = data.estado_civil || "";
        document.getElementById("lugar_trabajo").value = data.lugar_trabajo || "";
        document.getElementById("dui").value = data.dui || "";
        document.getElementById("fiador_id").value = data.fiador_id || "";
        document.getElementById("clasificacion_id").value = data.clasificacion_id || "";
        document.getElementById("enviar").innerHTML = "Guardar Cambios";
        document.getElementById("enviar").classList.remove('btn-danger');
        document.getElementById("enviar").classList.add('btn-primary');
        document.getElementById("enviar").innerHTML = data.estado == 1 ? "Dar de baja" : "Activar";

        if (data.estado == 1) {
            document.getElementById("enviar").classList.remove('btn-primary');
            document.getElementById("enviar").classList.add('btn-danger');

        } else {
            document.getElementById("enviar").classList.remove('btn-danger');
            document.getElementById("enviar").classList.add('btn-primary');

        }

    }
    function eliminar(data) {
        document.getElementById("titulo").innerHTML = "¿SEGURO QUE DESEA BORRAR ESTE USUARIO?";

        document.getElementById("nombre").setAttribute("disabled", "");
        document.getElementById("direccion").setAttribute("disabled", "");
        document.getElementById("telefono").setAttribute("disabled", "");
        document.getElementById("email").setAttribute("disabled", "");
        document.getElementById("ingresos").setAttribute("disabled", "");
        document.getElementById("egresos").setAttribute("disabled", "");
        document.getElementById("estado_civil").setAttribute("disabled", "");
        document.getElementById("lugar_trabajo").setAttribute("disabled", "");
        document.getElementById("dui").setAttribute("disabled", "");

        document.getElementById("action").value = "borrar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("estado").value = data.estado == 1 ? false : true || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("direccion").value = data.direccion || "";
        document.getElementById("telefono").value = data.telefono || "";
        document.getElementById("email").value = data.email || "";
        document.getElementById("ingresos").value = data.ingresos || "";
        document.getElementById("egresos").value = data.egresos || "";
        document.getElementById("estado_civil").value = data.estado_civil || "";
        document.getElementById("lugar_trabajo").value = data.lugar_trabajo || "";
        document.getElementById("dui").value = data.dui || "";
        
        document.getElementById("fiador_id").value = data.fiador_id || "";
        document.getElementById("clasificacion_id").value = data.clasificacion_id || "";
        document.getElementById("enviar").innerHTML = "Eliminar";
        document.getElementById("enviar").classList.remove('btn-primary');
        document.getElementById("enviar").classList.add('btn-danger');

    }

    function verFiador(data) {
    // Set modal fields for the fiador data
    document.getElementById("nombref").textContent = data.fiador_nombre || "No disponible";
    document.getElementById("direccionf").textContent = data.fiador_direccion || "No disponible"; // assuming fiador_direccion exists
    document.getElementById("telefonof").textContent = data.fiador_telefono || "No disponible";   // 
    document.getElementById("emailf").textContent = data.fiador_email || "No disponible";   // assuming fiador_telefono exists
    document.getElementById("duif").textContent = data.fiador_dui || "No disponible";
}
    


    
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageC'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageC']); // Clear the message ?>
    <?php endif;?>
    </script>
</body>

</html>