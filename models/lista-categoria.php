<?php
include "../controladores/ControladorCategoria.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
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
        <h5 class="modal-title" id="exampleModalLabel">Registrar Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="frmregistrar" action="../controladores/ControladorCategoria.php" method="POST"   >
      <input type="hidden" name="action" value="insert">
        <div class="row">

           <div class="col-md-12">

            <label>Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required="true">


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
                <h3 class="card-title text-center align-middle">Categorias</h3>
                <button type="button"  class="btn btn-primary mb-4" data-toggle="modal" data-target="#modalregistrar"> Registrar </button>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorCategoria::listar() as $row): ?>
                            <tr>

                                <th>
                                    <?=$row["nombre"]?>
                                </th>

                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarCategoria<?php echo $row['id_categoria']; ?>">Editar</button>
                                        <button class="btn btn-danger"  <?=ControladorCategoria::esEliminable($row['id_categoria']) ? "disabled" : ""?> data-toggle="modal" data-target="#eliminarCategoria<?php echo $row['id_categoria']; ?>">Eliminar</button>
                                    </div>
                                </th>
                            </tr>
                            <?php include '../vistas/Modals/ModalEditarCategoria.php';
?>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <?php foreach (ControladorCategoria::listar() as $row): ?>
        <?php include '../vistas/Modals/ModalEliminarCategoria.php';?>
    <?php endforeach;?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validarFormulariocompleto() {

        const categoria = document.getElementById('nombre').value;


        if (!categoria) {
            Swal.fire("Aviso", "Por favor, agregue una categoria.", "warning");
            return false; // Evitar el envío del formulario
        }

            return true;

    }




    </script>



</body>

</html>