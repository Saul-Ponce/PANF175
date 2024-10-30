<!-- Modal -->
<div class="modal fade" id="editarClienteJuridico<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente Jurídico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../controladores/ControladorClienteJuridico.php" method="POST" name="form">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nombre" class="col-form-label">Nombre de la Empresa</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="direccion" class="col-form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" id="direccion" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="telefono" class="col-form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono']; ?>" id="telefono" maxlength="15" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="email" class="col-form-label">Correo Electrónico</label>
              <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="representante_legal" class="col-form-label">Representante Legal</label>
              <input type="text" name="representante_legal" class="form-control" value="<?php echo $row['representante_legal']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="aval" class="col-form-label">Aval</label>
              <input type="text" name="aval" class="form-control" value="<?php echo $row['aval']; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="clasificacion_id" class="col-form-label">Clasificación</label>
              <select class="form-control" id="clasificacion_id" name="clasificacion_id" required="true">
                <option value="" disabled>Seleccione una clasificación</option>
                <?php 
                // Obtener las clasificaciones de la base de datos
                $clasificaciones = ClasificacionModel::listar();
                while ($clasificacion = mysqli_fetch_assoc($clasificaciones)) : ?>
                    <option value="<?php echo $clasificacion['id']; ?>" 
                        <?php echo $clasificacion['id'] == $row['clasificacion_id'] ? 'selected' : ''; ?>>
                        <?php echo $clasificacion['nombre']; ?>
                    </option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="estado" class="col-form-label">Estado</label>
              <select class="form-control" id="estado" name="estado" required="true">
                <option value="activo" <?php echo $row['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo $row['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <a type="button" class="btn btn-secondary" href="../vistas/lista-clientesjuridicos.php">Cerrar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
