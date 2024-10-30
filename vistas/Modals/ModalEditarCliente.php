

<!-- Modal -->
<div class="modal fade" id="editarCliente<?php echo $row["dui_cliente"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../controladores/ControladorCliente.php" method="POST" name="form">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="dui_cliente" value="<?php echo $row['dui_cliente']; ?>">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">DUI</label>
              <input type="text" name="dui" class="form-control" value="<?php echo $row['dui_cliente']; ?>" id="dui" placeholder="DUI" maxlength="10" OnKeyPress="formato('########-#', this)" required="true" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre_c']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Apellido</label>
              <input type="text" name="apellido" class="form-control" value="<?php echo $row['apellido_c']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Direccion</label>
              <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" id="direccion" placeholder="Direccion" required="true">
            </div>
              <div class="form-group col-md-6">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono_c']; ?>" id="telefono" placeholder="Telefono " maxlength="9" OnKeyPress="formato('####-####', this)" required="true">
              </div>
            <div class="modal-footer">
        <a type="button" class="btn btn-secondary" href="../vistas/lista-cliente.php">Cerrar</a>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
        </form>
      </div>

    </div>
  </div>
</div>



<script>
  function formato(mascara, documento) {
    var i = documento.value.length;
    var salida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != salida) {
      documento.value += texto.substring(0, 1);
    }
  }
</script>