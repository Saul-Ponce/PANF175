
<div class="modal fade" id="addMant<?php echo $row["id_equipo"]; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog" role="document">

        <?php $dueño = ControladorMant::dui($row['dui_cliente']);
echo ($row['dui_cliente']);

if ($dueño) {
    // Fetch a single row from the result
    $result = mysqli_fetch_assoc($dueño);

}
if ($result) {

    $column1Value = $result['nombre_c'];
    $column2Value = $result['apellido_c'];
} else {
    echo "No rows found.";
}

?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir mantenimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="MantForm" action="../controladores/ControladorMant.php" method="POST">
                        <input type="hidden" name="action" value="insert">
                        <h6 style="text-align: center;">Datos del equipo</h6>
                        <input type="hidden" name="equipo" value="<?php echo $row['id_equipo'] ?>">


                        <div class="row mb-3">
                            <div class="col">
                            <label for="dueño" class="form-label">Dueño</label>
                            <input type="text" class="form-control" id="dueño" name="dueño" value="<?php echo $column1Value; ?> <?php echo $column2Value; ?>  " disabled>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $row['marca']; ?> " disabled>
                                <label for="procesador" class="form-label">Procesador</label>
                                <input type="text" class="form-control" id="procesador" name="procesador" value="<?php echo $row['procesador']; ?> " disabled>




                            </div>

                            <div class="col-md-6 mb-3">

                                <label for="Ram" class="form-label">Ram</label>
                                <input type="text" class="form-control" id="ram" name="ram" value="<?php echo $row['ram']; ?> " disabled>
                                <label for="Almacenamiento" class="form-label">Almacenamiento</label>
                                <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" value="<?php echo $row['almacenamiento']; ?> " disabled>


                            </div>
                        </div>


                        <h6 style="text-align: center;" class="mt-3 mb-3">Datos del mantenimiento</h6>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="detalles" class="form-label">Detalles</label>
                                <input type="text" class="form-control" id="detalles_m" name="detalles_m">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fechaMant" class="form-label">Fecha de mantenimiento</label>
                                <input type="date" class="form-control" id="fechaMant" name="fechaMant" value="">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="direccion" class="form-label">Precio</label>
                                <input type="text" oninput="formatMoneyInput(this)" class="form-control" id="precio_m" name="precio_m">

                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check-radio mt-4">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="estado_m" id="exampleRadios1" value="Finalizado">
                                        <span class="form-check-sign"></span>
                                        Finalizado
                                    </label>
                                </div>

                                <div class="form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="estado_m" id="exampleRadios2" value="En proceso" checked>
                                        <span class="form-check-sign"></span>
                                        En proceso
                                    </label>
                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar mantenimiento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  // Function to format the input value when it changes
  function formatMoneyInput(input) {

    // Remove any non-numeric and extra decimal points
    input.value = input.value.replace(/[^\d.]/g, '');

    // Ensure a maximum of two decimal places
    var parts = input.value.split('.');
    if (parts[1] && parts[1].length > 2) {
      parts[1] = parts[1].substring(0, 2);
      input.value = parts.join('.');
    }

  }


  // Get the current date
  var currentDate = new Date();

  // Format the date as YYYY-MM-DD (required format for date input)
  var year = currentDate.getFullYear();
  var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Add 1 to the month since it's zero-based
  var day = String(currentDate.getDate()).padStart(2, '0');
  var formattedDate = year + '-' + month + '-' + day;

  // Set the formatted date as the default value for the date input
  document.getElementById('fechaMant').value = formattedDate;



</script>