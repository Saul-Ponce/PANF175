<div class="modal fade" id="modalClasificacion" tabindex="-1" aria-labelledby="modalClasificacionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalClasificacionLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formClasificacion" method="post" action="../controladores/ControladorClasificacion.php">
        <input type="hidden" name="action" id="action"> <!-- Campo para definir la acción -->
        <input type="hidden" name="id" id="clasificacionId"> <!-- ID del registro para editar o eliminar -->
        
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
          </div>
          <p id="warningDelete" class="text-danger" style="display: none;">¿Estás seguro de que deseas eliminar esta clasificación?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="modalActionButton" class="btn btn-primary"></button>
        </div>
      </form>
    </div>
  </div>
</div>
