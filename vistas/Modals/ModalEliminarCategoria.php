<!--ventana para delete--->
<div class="modal fade" id="eliminarCategoria<?php echo $row["id_categoria"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">

          ¿SEGURO QUE DESEA BORRAR ESTA CATEGORIA?

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorCategoria.php" method="POST">
          <input type="hidden" name="action" value="borrar">
          <input type="hidden" name="id_categoria" value="<?php echo $row['id_categoria']; ?>">


          <div class="form-group row">

    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" disabled>
    </div>



</div>


      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger">Eliminar</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->