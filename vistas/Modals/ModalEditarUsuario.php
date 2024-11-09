<?php
$con = connection();
$sql = "SELECT * FROM roles";
$query = mysqli_query($con, $sql);

?>



<!-- Modal -->
<div class="modal modal-blur fade" id="editarUsuario<?php echo $row["id"]; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorUsuario.php" method="POST" name="form" id="form">
                <div class="modal-body">
                    <input type="hidden" name="action" value="editar">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>"
                                required="true" onkeypress="return Solo_Texto(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usuario" class="col-form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control"
                                value="<?php echo $row['usuario']; ?>" required="true"
                                onkeypress="return Solo_Texto(event);">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rol_id">Rol</label>
                            <select class="form-select" name="rol_id" id="rol_id" required="true">
                                <?php foreach ($query as $rol): ?>
                                <?php $selected = ($rol['id'] == $rol["rol_id"]) ? "selected" : "";?>
                                <option value="<?=$rol["id"]?>" <?=$selected?>><?=$rol["nombre"]?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="correo_recuperacion">Correo de recuperacion</label>
                            <input type="email" class="form-control" value="<?php echo $row['correo_recuperacion']; ?>"
                                id="correo_recuperacion" name="correo_recuperacion" required="true">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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