<?php
$con = connection();
$sql = "SELECT * FROM producto";
$query = mysqli_query($con, $sql);

?>

<!-- Modal -->
<div class="modal fade" id="editarDetalle<?php echo $row["id_detalleimpresion"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos de los Detalles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../controladores/ControladorDetalle.php" method="POST" name="form">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id_detalleimpresion" value="<?php echo $row['id_detalleimpresion']; ?>">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="producto">Producto</label>
              <select class="form-control" value="<?php echo $row['producto']; ?>" name="producto" id="producto" required="true"> <?php foreach ($query as $row): ?>
                  <option value="<?=$row["codigo_producto"]?>"><?=$row["nombre_p"]?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Tamaño</label>
              <input type="text" name="tamanio" class="form-control" value="<?php echo $row['tamanio']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Grosor</label>
              <input type="text" name="grosor" class="form-control" value="<?php echo $row['grosor']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Detalles</label>
              <input type="text" name="detalles" class="form-control" value="<?php echo $row['detalles']; ?>" id="detalles" placeholder="Detalles" required="true">
            </div>
            <div class="modal-footer">
              <a type="button" class="btn btn-secondary" href="../vistas/lista-detalles.php">Cerrar</a>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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