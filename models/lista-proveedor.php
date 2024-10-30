<?php
include "../controladores/ControladorProveedor.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>


<body>
    <div class="container-fluid mt-4 ">

<!-- Modal registrar -->
<div class="modal fade" id="modalregistrar" tabindex="-1" role="dialog" aria-labelledby="modalregistrar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="frmregistrar" action="../controladores/ControladorProveedor.php" method="POST"  onsubmit="return validarFormularioCompleto() && validarTelefono()">
      <input type="hidden" name="action" value="insert">
        <div class="row">

           <div class="col-md-12">

            <label>Nombre</label>
            <input type="text" class="form-control" id="nombre_p" name="nombre_p">
            <label>Direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
            <label>Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono"  maxlength="9" oninput="formatoTelefono(this)" >

            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btnregistrar">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>



        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle">Proveedores</h3>
                <button type="button"  class="btn btn-primary mb-4" data-toggle="modal" data-target="#modalregistrar"> Registrar </button>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Número de Teléfono</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorProveedor::listar() as $row): ?>
                            <tr>

                                <th>
                                    <?=$row["nombre_p"]?>
                                </th>

                                <th><?=$row["direccion"]?></th>

                                <th><?=$row["telefono"]?></th>

                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarProveedor<?php echo $row['id_proveedor']; ?>">Editar</button>
                                        <button class="btn btn-danger" <?=ControladorProveedor::esEliminable($row['id_proveedor']) ? "disabled" : ""?> data-toggle="modal" data-target="#eliminarProveedor<?php echo $row['id_proveedor']; ?>">Eliminar</button>
                                    </div>
                                </th>
                            </tr>
                            <?php include '../vistas/Modals/ModalEditarProveedor.php';
?>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <?php foreach (ControladorProveedor::listar() as $row): ?>
        <?php include '../vistas/Modals/ModalEliminarProveedor.php';?>
    <?php endforeach;?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function formatoTelefono(input) {
            var telefono = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (telefono.length > 4) {
                telefono = telefono.substring(0, 4) + '-' + telefono.substring(4, 8); // Agregar guión en la posición adecuada
            }
            input.value = telefono; // Actualizar el valor del campo
        }
        function validarTelefono() {
        var telefono = document.getElementById('telefono').value;
        // Verificar si la longitud del número es menor de la deseada
        if (telefono.length < 9) {
            Swal.fire('Faltan dígitos en el teléfono');
            return false; // Evitar el envío del formulario
        }
        return true; // Enviar el formulario si el teléfono tiene al menos 8 dígitos
    }

    function validarFormularioCompleto() {

        const nombre = document.getElementById('nombre_p').value;

        const direccion = document.getElementById('direccion').value;

        const telefono = document.getElementById('telefono').value;


        if (!nombre ||  !direccion  || !telefono) {
            Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
            return false; // Evitar el envío del formulario
        }

            return true;

    }

</script>

</body>

</html>