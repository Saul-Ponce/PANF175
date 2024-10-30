<?php
$con = connection();
$sql = "SELECT * FROM categoria";
$query = mysqli_query($con, $sql);
$sql2 = "SELECT * FROM proveedor";
$query2 = mysqli_query($con, $sql2);

?>



<!-- Modal -->
<div class="modal fade" id="editarProducto<?php echo $row["codigo_producto"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../controladores/ControladorProducto.php" method="POST" name="form" onsubmit="return validarFormularioCompleto()" enctype="multipart/form-data">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="codigo_producto" value="<?php echo $row['codigo_producto']; ?>">
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Nombre del Producto</label>
              <input type="text" name="nombre_p" class="form-control" value="<?php echo $row['nombre_p']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Marca</label>
              <input type="text" name="marca" class="form-control" value="<?php echo $row['marca']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Precio</label>
              <input type="number" step="any" name="precio" id="precio" class="form-control" value="<?php echo $row['precio']; ?>" oninput="validarNoNegativo('precio')" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Stock</label>
              <input type="number" name="stock" id="stock" class="form-control" value="<?php echo $row['stock']; ?>" oninput="validarNoNegativo('precio')" required="true">
            </div>

            <div class="form-group col-md-6">
              <label for="categoria">Categoria</label>
              <select class="form-control" name="categoria" id="categoria" required="true">
                <?php foreach ($query as $categoria): ?>
                  <?php $selected = ($row['nombre'] == $categoria["nombre"]) ? "selected" : "";?>
                  <option value="<?=$categoria["id_categoria"]?>" <?=$selected?>><?=$categoria["nombre"]?></option>
                <?php endforeach;?>
              </select>

            </div>

            <div class="form-group col-md-6">
              <label for="proveedor">Proveedor</label>
              <select class="form-control" name="proveedor" id="proveedor" required="true">
                <?php foreach ($query2 as $proveedor): ?>
                  <?php $selected = ($row['proveedor'] == $proveedor["nombre_p"]) ? "selected" : "";?>
                  <option value="<?=$proveedor["id_proveedor"]?>" <?=$selected?>><?=$proveedor["nombre_p"]?></option>
                <?php endforeach;?>
              </select>

            </div>


            <div class="form-group col-md-6">
              <label for="imagen_p">Imagen del Producto</label>
              <input class="form-control-file" id="imagen_p" name="imagen_p" type="file" accept="image/*">
              <img src="../controladores/<?=$row["imagen_p"]?>" id="previewImage" style=" max-width: 100px; max-height: 100px;">
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
  const imageInput = document.getElementById('imagen_p');
  const previewImage = document.getElementById('previewImage');

  imageInput.addEventListener('change', function(event) {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
      const reader = new FileReader();

      reader.onload = function(e) {
        // Muestra la vista previa de la imagen
        previewImage.style.display = 'block';
        previewImage.src = e.target.result;
      };

      reader.readAsDataURL(selectedFile);
    } else {
      // Oculta la vista previa si no se selecciona ninguna imagen
      previewImage.style.display = 'none';
      previewImage.src = '';
    }
  });


  function soloNumeros(e) {
    var key = e.charCode || e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
  }

  function validarNoNegativo(campo) {
    const elemento = document.getElementById(campo);
    if (elemento.value < 0 || isNaN(elemento.value)) {
      elemento.value = 0;
    }
  }

  function validarFormularioCompleto() {
    const nombreProducto = document.getElementById('nombre_p').value;
    const marca = document.getElementById('marca').value;
    const precio = document.getElementById('precio').value;
    const stock = document.getElementById('stock').value;
    const categoria = document.getElementById('categoria').value;
    const proveedor = document.getElementById('proveedor').value;
    const imagen = document.getElementById('imagen_p').files;

    if (!nombreProducto || !marca || !precio || !stock || categoria === '0' || proveedor === '0' || imagen.length === 0) {
      Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
      return false; // Evitar el envío del formulario
    }

    if (isNaN(precio) || isNaN(stock) || precio < 0 || stock < 0) {
      Swal.fire("Aviso", "El precio y el stock deben ser valores numéricos positivos.", "warning");
      return false; // Evitar el envío del formulario
    }

    // Si todas las validaciones son exitosas, el formulario se enviará
    return true;
  }
</script>