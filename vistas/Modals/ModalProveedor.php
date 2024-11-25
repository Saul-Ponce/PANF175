



<!-- Modal -->
<div class="modal modal-blur fade" id="mdProveedor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorProveedor.php" method="POST" name="form" id="form">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="estado" id="estado" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value=""
                                onkeypress="return Solo_Texto(event);" required="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="direccion" class="col-form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono" class="col-form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="correo" class="col-form-label">Correo Electronico</label>
                            <input type="email" name="correo" id="correo" class="form-control" value="">
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