
<!--ventana para delete--->
<div class="modal fade" id="eliminarCliente<?php echo $row["dui_cliente"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">

          ¿SEGURO QUE DESEA BORRAR ESTE CLIENTE?

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorCliente.php" method="POST">
          <input type="hidden" name="action" value="borrar">
          <input type="hidden" name="dui_cliente" value="<?php echo $row['dui_cliente']; ?>">



          <label>Datos:</label>

          <div class="form-group row">
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">DUI</label>
        <input type="text" name="dui" class="form-control" readonly="readonly" value="<?php echo $row['dui_cliente']; ?>">
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre_c']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" value="<?php echo $row['apellido_c']; ?>" disabled>
    </div>
    <div class="col-md-12">
        <label for="recipient-name" class="col-form-label">Direccion</label>
        <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Telefono</label>
        <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono_c']; ?>" disabled>
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