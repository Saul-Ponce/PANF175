


<!-- Modal -->
<div class="modal fade" id="editarProveedor<?php echo $row["id_proveedor"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../controladores/ControladorProveedor.php" method="POST" name="form" >
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id_proveedor" value="<?php echo $row['id_proveedor']; ?>">
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="nombre_p" class="col-form-label">Nombre del Proveedor</label>
              <input type="text" name="nombre_p" class="form-control" value="<?php echo $row['nombre_p']; ?>" required="true">
            </div>

              <div class="form-group col-md-12">
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" id="direccion" placeholder="Direccion" required="true">
              </div>


              <div class="form-group col-md-6">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo $row['telefono']; ?>" id="telefono" placeholder="Telefono" minlength="9" maxlength="9" OnKeyPress="formato('####-####', this)" required="true">
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
  function formato(mascara, documento) {
    var i = documento.value.length;
    var salida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != salida) {
      documento.value += texto.substring(0, 1);
    }
  }
  function formatoTelefono(input) {
            var telefono = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (telefono.length > 4) {
                telefono = telefono.substring(0, 4) + '-' + telefono.substring(4, 8); // Agregar guión en la posición adecuada
            }
            input.value = telefono; // Actualizar el valor del campo
        }
        function validarTelefono() {
        var telefono = document.getElementById('telefono').value;
        // Verificar si la longitud del número es menor de la deseada
        if (telefono.length < 9) {
            Swal.fire('Faltan dígitos en el teléfono');
            return false; // Evitar el envío del formulario
        }
        return true; // Enviar el formulario si el teléfono tiene al menos 8 dígitos
    }

    function validarFormularioCompleto() {

        const nombre = document.getElementById('nombre_p').value;

        const direccion = document.getElementById('direccion').value;

        const telefono = document.getElementById('telefono').value;


        if (!nombre ||  !direccion  || !telefono) {
            Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
            return false; // Evitar el envío del formulario
        }

            return true;

    }

</script>