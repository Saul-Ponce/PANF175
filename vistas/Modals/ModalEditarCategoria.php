
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Modal -->
<div class="modal fade" id="editarCategoria<?php echo $row["id_categoria"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  action="../controladores/ControladorCategoria.php" method="POST" name="form"  >
          <input type="hidden" name="action" value="editar">

          <input type="hidden" name="id_categoria" value="<?php echo $row['id_categoria']; ?>">
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Nombre de la Categoria</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>" required="true">
            </div>



              <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
     function validarNombre() {
  const nombre = document.getElementById('nombre').value;
  if (!nombre) {
    Swal.fire("Aviso", "Por favor, ingrese un nombre de categoría.", "warning");
    return false;
  }
  return true;
}

function validarFormularioCompleto() {
  if (!validarNombre()) {
    return false;
  }
  // Otras validaciones o envío del formulario
  return true;
}
    </script>
