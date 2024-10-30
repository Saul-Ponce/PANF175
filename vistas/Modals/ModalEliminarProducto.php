<!--ventana para delete--->
<div class="modal fade" id="eliminarProducto<?php echo $row["codigo_producto"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">

          ¿SEGURO QUE DESEA BORRAR ESTE PRODUCTO?

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorProducto.php" method="POST">
          <input type="hidden" name="action" value="borrar">
          <input type="hidden" name="codigo_producto" value="<?php echo $row['codigo_producto']; ?>">


          <div class="form-group row">
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Codigo Producto</label>
        <input type="text" name="codigo_producto" class="form-control" value="<?php echo $row['codigo_producto']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Nombre Producto</label>
        <input type="text" name="nombre_p" class="form-control" value="<?php echo $row['nombre_p']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Marca</label>
        <input type="text" name="marca" class="form-control" value="<?php echo $row['marca']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Precio</label>
        <input type="number" name="precio" class="form-control" value="<?php echo $row['precio']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Stock</label>
        <input type="number" name="stock" class="form-control" value="<?php echo $row['stock']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Categoria</label>
        <input type="text" name="categoria" class="form-control" value="<?php echo $row['nombre']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Proveedor</label>
        <input type="text" name="proveedor" class="form-control" value="<?php echo $row['proveedor']; ?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="recipient-name" class="col-form-label">Imagen del Producto</label>
        <img src="../controladores/<?=$row["imagen_p"]?>" style="max-width: 100px; max-height: 100px;" disabled>
    </div>


</div>


      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger">Eliminar</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->