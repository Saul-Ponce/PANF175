<!-- Modal -->
<div class="modal modal-blur fade" id="mdRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorRol.php" method="POST" name="form" id="form">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value=""
                                onkeypress="return Solo_Texto(event);" required="true">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usuario" class="col-form-label">Descripcion</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value=""
                                onkeypress="return Solo_Texto(event);" required="true">
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
