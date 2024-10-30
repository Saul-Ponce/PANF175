<?php
$con = connection();
$sql = "SELECT * FROM cliente";
$query = mysqli_query($con, $sql);

?>



<!-- Modal edit-->

<div class="modal fade" id="editarEquipo<?php echo $row["id_equipo"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Equipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="../controladores/ControladorEquipo.php" method="POST" name="form">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id_equipo" value="<?php echo $row['id_equipo']; ?>">
          <div class="form-row">
          <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Fecha recibido</label>
              <input type="date" name="fecha_r" id= "fecha_nacimiento" class="form-control" value="<?php echo $row['fecha_r']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Marca</label>
              <input type="text" name="marca" class="form-control" value="<?php echo $row['marca']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Procesador</label>
              <input type="text" name="procesador" class="form-control" value="<?php echo $row['procesador']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">RAM</label>
              <input type="text" name="ram" class="form-control" value="<?php echo $row['ram']; ?>" required="true">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Almacenamiento</label>
              <input type="text" name="almacenamiento" class="form-control" value="<?php echo $row['almacenamiento']; ?>" required="true">
            </div>
              <div class="form-group col-md-12">
                <label for="observaciones">Observaciones</label>
                <input type="text" name="observaciones" class="form-control" value="<?php echo $row['observaciones']; ?>" id="Observaciones" placeholder="Observaciones" required="true">
              </div>
              <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Fecha de entrega</label>
              <input type="date" name="fecha_entrega" id= "fecha_entrega" class="form-control" value="<?php echo $row['fecha_entrega']; ?>" required="true">
            </div>
              <div class="form-group col-md-6">
                <label for="rol">DUI Cliente</label>
                <select class="form-control" value="<?php echo $row['dui_cliente']; ?>" name="dui_cliente" id="dui_cliente" required="true">
                  <?php foreach ($query as $row): ?>
                    <option value="<?=$row["dui_cliente"]?>"><?=$row["dui_cliente"]?></option>
                  <?php endforeach;?>
                </select>
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



