<?php
$con = connection();
$sql = "SELECT * FROM categoriaproducto";
$query = mysqli_query($con, $sql);

//include_once "../models/ProductoModel.php";

//$imagen= ControladorProducto::obtener_imagen();
?>



<!-- Modal -->
<div class="modal modal-blur fade" id="mdProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorProducto.php" method="POST" name="form" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="estado" id="estado" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="codigo" class="col-form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value=""
                                >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value=""
                                onkeypress="return Solo_Texto(event);" required="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descripcion" class="col-form-label">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value=""
                                >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="categoria_id">Categoria</label>
                            <select class="form-select" name="categoria_id" id="categoria_id" required="true">
                                <?php foreach ($query as $cat): ?>
                                <option value="<?=$cat["id"]?>"><?=$cat["nombre"]?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="imagen">Actualizar Imagen del Producto</label>
                            <input class="form-control-file" id="imagen" name="imagen" type="file" accept="image/*">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="marca" class="col-form-label">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control" value=""
                               >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modelo" class="col-form-label">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" value=""
                                >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stock_minimo" class="col-form-label">Stock Minimo</label>
                            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value=""
                             required="true">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="enviar" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //let formUsuario = document.getElementById('form');
    const imageInput = document.getElementById('imagen');
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


    function Solo_Texto(e) {
        var code;
        if (!e) var e = window.event;
        if (e.keyCode) code = e.keyCode;
        else if (e.which) code = e.which;
        var character = String.fromCharCode(code);
        var AllowRegex = /^[\ba-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/;
        if (AllowRegex.test(character)) return true;
        return false;
    }
</script>