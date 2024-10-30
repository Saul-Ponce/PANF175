
<!--ventana para delete--->
<div class="modal fade" id="editarVenta<?php echo $row["id_venta"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">

          Detalles de Venta

        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="cont_modal">
        <form action="../controladores/ControladorVenta.php" method="POST">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id_venta" value="<?php echo $row['id_venta']; ?>">



          <label>Datos:</label>


          <div class="row">
          <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Fecha de venta</label>
              <input type="date" name="fecha_venta" id= "fecha_venta" class="form-control" value="<?php echo $row['fecha_venta']; ?>" required="true" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">cliente</label>
              <input type="text" name="cliente" class="form-control" value="<?php echo $row['nombre_c']; ?> <?php echo $row['apellido_c']; ?>" required="true" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Empleado</label>
              <input type="text" name="cliente" class="form-control" value="<?php echo $row['nombre']; ?> <?php echo $row['apellido']; ?>" required="true" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Total</label>
              <input type="text" name="cliente" class="form-control" value="<?php echo $row['total']; ?>" required="true" readonly>
            </div>



          </div>
          <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Pago</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorVenta::listarDet($row["id_venta"]) as $row): ?>
                            <tr>

                                <th><?=$row["nombre_p"]?></th>
                                <th><?=$row["cantidad"]?></th>
                                <th><?=$row["precioDet"]?></th>

                                <th>
                                    <div class="d-flex justify-content-center">

                                    </div>
                                </th>
                            </tr>

                        <?php endforeach;?>

                    </tbody>
                </table>

      </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->