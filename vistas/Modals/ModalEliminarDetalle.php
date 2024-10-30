
<!--ventana para delete--->
<div class="modal fade" id="eliminarDetalle<?php echo $row["id_detalleimpresion"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">

          ¿SEGURO QUE DESEA BORRAR ESTE Detalle de impresion?

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorDetalle.php" method="POST">
          <input type="hidden" name="action" value="borrar">
          <input type="hidden" name="id_detalleimpresion" value="<?php echo $row['id_detalleimpresion']; ?>">



          <label>Datos:</label>

          <div class="form-group row">
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Producto</label>
        <input type="text" name="producto" class="form-control" value="<?php echo $row['producto']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Tamaño</label>
        <input type="text" name="tamanio" class="form-control" value="<?php echo $row['tamanio']; ?>" disabled>
    </div>
    <div class="col-md-12">
        <label for="recipient-name" class="col-form-label">Grosor</label>
        <input type="text" name="grosor" class="form-control" value="<?php echo $row['grosor']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Detalles</label>
        <input type="text" name="detalles" class="form-control" value="<?php echo $row['detalles']; ?>" disabled>
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