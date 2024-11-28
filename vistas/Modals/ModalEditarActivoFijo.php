<?php
$con = connection();
$sql = "SELECT * FROM Catalogo_Tipos_Activos";
$query = mysqli_query($con, $sql);

?>

<!-- Modal -->
<div class="modal modal-blur fade" id="mdActivofijo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del activo fijo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorActivoFijo.php" method="POST" name="form" id="form" onsubmit="return validarSeleccion()">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id_activo" id="id_activo" value="">
                    <input type="hidden" name="codigo" id="codigo" value="">
                    <input type="hidden" name="darBaja" id="darBaja" value="">
                    <div class="row">
                        <div class="mb-3">
                            <label for="nombre">Codigo de la unidad</label>
                            <input type="text" class="form-control" id="codigoUnidad" name="codigoUnidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol">Tipo de activo fijo</label>
                            <select class="form-select" id="idTipoActivo" name="idTipoActivo">
                                <option value="0">Seleccione</option>
                                <?php foreach ($query as $row): ?>
                                    <option value="<?= $row["idTipoActivo"] ?>"><?= $row["nombreActivo"] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="mensajeError" class="text-danger d-none" role="alert"></div>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_adquisicion">Fecha de Adquisición</label>
                            <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                        </div>
                        <div class="mb-3">
                            <label for="valor_adquisicion">Valor de Adquisición</label>
                            <input type="number" class="form-control" id="valor_adquisicion" name="valor_adquisicion" step="0.01" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="vida_util">Vida Útil (años)</label>
                            <input type="number" class="form-control" id="vida_util" name="vida_util" step="1" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="estadoActivo">Estado del Activo</label>
                            <select class="form-control" id="estadoActivo" name="estadoActivo" required>
                                <option value="1">Nuevo</option> <!-- Nuevo activo recién adquirido -->
                                <option value="2">Usado</option> <!-- Activo en reparación o revisión -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="darBaja">Dar de baja</label>
                            <select class="form-control" id="darBaja" name="darBaja" required>
                                <option value="1">Dar de baja</option>
                                <option value="2">Donar</option>
                                <option value="3">Vendido</option>
                                <option value="4">Votarlo</option>
                            </select>
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

    function validarSeleccion() {
        const tipoActivo = document.getElementById("idTipoActivo").value;
        const mensajeError = document.getElementById("mensajeError");
        const select = document.getElementById("idTipoActivo");

        if (tipoActivo === "0") {
            // Cambiar el borde del select a rojo
            select.classList.add("is-invalid");

            // Mostrar el mensaje de error
            mensajeError.textContent = "Por favor, seleccione un tipo de activo válido.";
            mensajeError.classList.remove("d-none"); // Muestra el mensaje de error

            return false; // Evita el envío del formulario
        }

        // Quitar el borde rojo si la validación pasa
        select.classList.remove("is-invalid");

        // Ocultar el mensaje de error
        mensajeError.classList.add("d-none");

        return true; // Permite el envío del formulario si la selección es válida
    }
</script>