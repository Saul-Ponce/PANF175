<?php
$con = connection();
$sql = "SELECT * FROM rol";
$query = mysqli_query($con, $sql);

?>



<!-- Modal -->
<div class="modal fade" id="editarPersona<?php echo $row["dui_persona"]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos del Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../controladores/ControladorPersona.php" method="POST" name="form" id="form">
                    <input type="hidden" name="action" value="editar">
                    <input type="hidden" name="dui_persona" value="<?php echo $row['dui_persona']; ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">DUI</label>
                            <input type="text" name="dui" class="form-control"
                                value="<?php echo $row['dui_persona']; ?>" id="dui" placeholder="DUI" maxlength="10"
                                OnKeyPress="formato('########-#', this)" required="true" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>"
                                required="true" onkeypress="return Solo_Texto(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control"
                                value="<?php echo $row['apellido']; ?>" required="true"
                                onkeypress="return Solo_Texto(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Fecha de nacimiento </label>
                            <?php
// Calcular la fecha de hace 18 años desde la fecha actual
$fechaNacimiento = date('Y-m-d', strtotime($row['fecha_nacimiento']));
$fechaMaxima = date('Y-m-d', strtotime('-18 years'));
echo '<input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" max="' . $fechaMaxima . '" onchange="calcularEdad(this.value)" value="' . $fechaNacimiento . '">';
?>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="direccion">Direccion</label>
                            <input type="text" name="direccion" class="form-control"
                                value="<?php echo $row['direccion']; ?>" id="direccion" placeholder="Direccion"
                                required="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rol">Rol</label>
                            <select class="form-control" name="rol" id="rol" required="true">
                                <?php foreach ($query as $row): ?>
                                <?php $selected = ($row['rol'] == $row["id_rol"]) ? "selected" : "";?>
                                <option value="<?=$row["id_rol"]?>" <?=$selected?>><?=$row["nombre_rol"]?></option>
                                <?php endforeach;?>
                            </select>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="telefono1">Telefono 1</label>
                            <input type="text" name="telefono1" class="form-control"
                                value="<?php echo $row['telefono1']; ?>" id="telefono1" placeholder="Telefono 1"
                                maxlength="9" OnKeyPress="formato('####-####', this)" required="true">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telefono2">Telefono 2</label>
                            <input type="text" name="telefono2" class="form-control"
                                value="<?php echo (isset($row['telefono2']) ? $row['telefono2'] : ""); ?>"
                                id="telefono2" placeholder="Telefono 2" maxlength="9"
                                OnKeyPress="formato('####-####', this)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Fecha de contratación</label>
                            <input type="date" name="fecha_contratacion" class="form-control"
                                value="<?php echo $row['fecha_contratacion']; ?>" required="true">
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
let formPersona = document.getElementById('form');

function formato(mascara, documento) {
    var i = documento.value.length;
    var salida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != salida) {
        documento.value += texto.substring(0, 1);
    }
}

function calcularEdad(fecha) {
    var fechaNacimiento = new Date(fecha);
    var fechaActual = new Date();
    var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();

    if (fechaActual.getMonth() < fechaNacimiento.getMonth() || (fechaActual.getMonth() == fechaNacimiento.getMonth() &&
            fechaActual.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    if (edad < 18) {
        Swal.fire("La persona debe ser mayor de 18 años");
        document.getElementById('fecha_nacimiento').value = '';
    }
}

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
// Función para verificar la mayoría de edad
function verificarMayoriaEdad() {
    // Obtener la fecha de nacimiento ingresada por el usuario
    const fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);

    // Obtener la fecha actual
    const fechaActual = new Date();

    // Calcular la diferencia en milisegundos
    const diferenciaMs = fechaActual - fechaNacimiento;

    // Calcular la edad en años
    const edad = diferenciaMs / (1000 * 60 * 60 * 24 * 365.25);

    // Verificar si la persona tiene al menos 18 años
    if (edad >= 18) {
        console.log("se puede enviar");
        formPersona.submit();
    } else {
        alert('La persona no es mayor de edad.');
    }
}

// Agregar un evento al botón de envío del formulario para llamar a la función de verificación
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe
    verificarMayoriaEdad(); // Llamar a la función de verificación
});
</script>