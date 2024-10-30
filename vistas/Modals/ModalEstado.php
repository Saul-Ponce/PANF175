<!--ventana para delete--->
<div class="modal fade" id="estadoPersona<?php echo $row["dui_persona"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
        <?=$row["estado"] ? '¿SEGURO QUE DESEA DAR DE BAJA A ESTE EMPLEADO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE EMPLEADO?'?>

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorPersona.php" method="POST">
          <input type="hidden" name="action" value="cambiarEstado">
          <input type="hidden" name="dui_persona" value="<?php echo $row['dui_persona']; ?>">
          <input type="hidden" name="estado" value="<?php echo !$row['estado']; ?>">



          <label>Datos:</label>

          <div class="form-group row">
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">DUI</label>
        <input type="text" name="dui" class="form-control" value="<?php echo $row['dui_persona']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" value="<?php echo $row['apellido']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Fecha de nacimiento</label>
        <input type="date" name="fechaNacimiento" class="form-control" value="<?php echo $row['fecha_nacimiento']; ?>" disabled>
    </div>
    <div class="col-md-12">
        <label for="recipient-name" class="col-form-label">Direccion</label>
        <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Rol</label>
        <input type="text" name="rol" class="form-control" value="<?php echo $row['nombre_rol']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Telefono 1</label>
        <input type="text" name="telefono1" class="form-control" value="<?php echo $row['telefono1']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Telefono 2</label>
        <input type="text" name="telefono2" class="form-control" value="<?php echo $row['telefono2']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Fecha de contratación</label>
        <input type="date" name="fechaContratacion" class="form-control" value="<?php echo $row['fecha_contratacion']; ?>" disabled>
    </div>
</div>


      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn <?=$row["estado"] ? 'btn-danger' : 'btn-success'?>"><?=$row["estado"] ? 'Dar de baja' : 'Activar'?></button>
      </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->