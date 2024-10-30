<!-- Ventana para eliminar cliente jurídico -->
<div class="modal fade" id="eliminarClienteJuridico<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿SEGURO QUE DESEA BORRAR ESTE CLIENTE JURÍDICO?
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorClienteJuridico.php" method="POST">
          <input type="hidden" name="action" value="borrar">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

          <label>Datos:</label>

          <div class="form-group row">
            <div class="col-md-6">
              <label for="nombre" class="col-form-label">Nombre de la Empresa</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="direccion" class="col-form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="telefono" class="col-form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono']; ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="representante_legal" class="col-form-label">Representante Legal</label>
              <input type="text" name="representante_legal" class="form-control" value="<?php echo $row['representante_legal']; ?>" disabled>
            </div>
            <div class="col-md-12">
              <label for="aval" class="col-form-label">Aval</label>
              <input type="text" name="aval" class="form-control" value="<?php echo $row['aval']; ?>" disabled>
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
<!-- Fin de la ventana para eliminar cliente jurídico -->
