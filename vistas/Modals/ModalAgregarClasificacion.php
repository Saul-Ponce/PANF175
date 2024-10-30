<div class="modal fade" id="clasificacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de Clasificación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col d-flex align-items-center justify-content-center">
              <form action="../controladores/ControladorClasificacion.php" method="POST">
                <input type="hidden" name="action" value="insert">

                <div class="form-group">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" style="width:250px" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                  <label for="descripcion" class="form-label">Descripción</label>
                  <textarea class="form-control" style="width:250px" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>

                <button class="btn btn-primary mt-3 mb-5" type="submit">Agregar Clasificación</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- Espacio opcional para botones adicionales si es necesario -->
      </div>
    </div>
  </div>
</div>
