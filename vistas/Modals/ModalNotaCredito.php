<?php
$con = connection();
$sql = "SELECT * FROM roles";
$query = mysqli_query($con, $sql);
?>



<!-- Modal -->
<div class="modal modal-blur fade" id="mdNotaCredito" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Generar nota de credito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorVentaContado.php" method="POST" name="form" id="form">
                <div class="modal-body">
                    <input type="hidden" id="usuario_id" name="usuario_id" value="">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="id-venta" id="id-venta" value="">
                    <h5 class="modal-title" id="titulo">ID #<span id="txtid-venta"></span></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha</label>
                            <?php date_default_timezone_set("America/El_Salvador");
                            $fecha = date("Y-m-d"); ?>
                            <input type="date" class="form-control" value="<?= $fecha ?>" id="fecha_nota" name="fecha"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Monto($)</label>
                            <input readonly class="form-control" id="monto" name="monto" type="number" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Motivo</label>
                            <input type="text" name="motivo" id="motivo" class="form-control" value="" required="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Usuario</label>
                            <input type="tex" class="form-control" value="" id="usuario" name="usuario" readonly>
                        </div>
                        <label class="form-label mt-2">selecione a que desea aplicar la nota al credito</label>
                        <div class="form-selectgroup mb-2">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="tipo" value="cliente-juridico" class="form-selectgroup-input"
                                    checked>
                                <span onclick="mostrarTablaProducto(false)" class=" form-selectgroup-label">
                                    Venta Completa</span>
                            </label>
                            <label class="form-selectgroup-item">
                                <input type="radio" name="tipo" value="cliente-natural" class="form-selectgroup-input">
                                <span onclick="mostrarTablaProducto(true)" class="form-selectgroup-label">
                                    Productos especificos</span>
                            </label>
                        </div>
                        <div id="dataDVN"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="enviar" class="btn btn-primary">Generar Nota de credito</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
//let formUsuario = document.getElementById('form');



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