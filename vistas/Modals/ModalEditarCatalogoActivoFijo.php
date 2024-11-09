<?php
$con = connection();
$sql = "SELECT * FROM roles";
$query = mysqli_query($con, $sql);

?>

<!-- Modal -->
<div class="modal modal-blur fade" id="mdCatalogoActivofijo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del Catalogo activo fijo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorCatalogoActivoFijo.php" method="POST" name="form" id="form">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="idTipoActivo" id="idTipoActivo" value="">
                    <input type="hidden" name="estado" id="estado" value="">
                    <div class="row">
                        <div class="mb-2">
                            <label for="codigo" class="col-form-label">Codigo</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="" required>
                        </div>
                        <div class="mb-2">
                            <label for="nombreActivo" class="col-form-label">Nombre</label>
                            <input type="text" name="nombreActivo" id="nombreActivo" class="form-control" value="" required>
                        </div>
                        <div class="mb-2">
                            <label for="descripcion" class="col-form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="porcentajeDepreciacion" class="col-form-label">Porcentaje de Depreciación (%)</label>
                            <input type="number" step="0.01" name="porcentajeDepreciacion" id="porcentajeDepreciacion" class="form-control" value="" required>
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
</script>