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

include "../controladores/ControladorCompra.php";
include_once "../models/CompraModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lista de compras</title>
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

    <div class="main-panel">
        <div class="container-fluid mt-4 ">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de compras</h3>
                    <table class="table table-bordered  text-center align-middle">
                        <thead>
                            <tr>
                                <td class="font-weight: 700; font-size:10px; text-align: center!important;" 
                                    scope="col">Fecha</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Total</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">detalles</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">usuario</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$resultado = ControladorCompra::listar();
while ($row = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td>
                                    <?=$row["fecha"]?>
                                </td>
                                <td>
    $<?=$row["total_compra"]?>
</td>

                                   
<td>
    <button type="button" class="btn btn-primary" onclick="showDetalles(<?=$row['compras_id']?>)" data-bs-toggle="modal" data-bs-target="#mdverF">
        <i class="fa-solid fa-eye"></i>
    </button>
</td>
                                <td>
                                    <?=$row["nombre"]?>
                                </td>
                                
                            </tr>

                            

                            <?php endwhile;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php';?>
    <?php include '../vistas/Modals/modalCompras.php';?>
    
    



    
    
<div class="modal fade" id="detalleCompraModal" tabindex="-1" role="dialog" aria-labelledby="detalleCompraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalleCompraModalLabel">Detalles de la Compra</h5>
        <!-- Close button (X) -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="detalleCompraTableBody">
            <!-- Rows will be appended here dynamically -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- Cerrar button -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
function showDetalles(compraId) {
    $.ajax({
        url: '../vistas/getDetalleCompra.php', // The PHP file to fetch the details
        method: 'GET',
        data: { id_compra: compraId }, // Send the compraId to fetch details
        success: function(response) {
            try {
                // Directly use the response since the server sends a valid JSON array
                const detalle = response; 

                const tableBody = $('#detalleCompraTableBody');
                tableBody.empty(); // Clear any previous rows

                if (detalle.length === 0) {
                    tableBody.append('<tr><td colspan="4">No hay detalles disponibles.</td></tr>');
                    return;
                }

                detalle.forEach(item => {
                    const row = `<tr>
                        <td>${item.nombre}</td>
                        <td>${item.cantidad}</td>
                        <td>${item.precio_unitario}</td>
                        <td>${(item.cantidad * item.precio_unitario).toFixed(2)}</td>
                    </tr>`;
                    tableBody.append(row);
                });

                // Show the modal
                $('#detalleCompraModal').modal('show');
            } catch (e) {
                console.error('Error parsing response:', e);
                alert('Error al procesar los datos del servidor.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            alert('Error en la solicitud al servidor.');
        }
    });
}






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

    


    
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageC'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageC']); // Clear the message ?>
    <?php endif;?>
    </script>
</body>

</html>