<!--ventana para delete--->
<div class="modal modal-blur fade" id="estadoUsuario<?php echo $row["id"]; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <?=$row["estado"] ? '¿SEGURO QUE DESEA DAR DE BAJA A ESTE EMPLEADO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE EMPLEADO?'?>

                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>

            <div class="modal-body" id="cont_modal">
                <form action="../controladores/ControladorUsuario.php" method="POST">
                    <input type="hidden" name="action" value="cambiarEstado">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="estado" value="<?php echo !$row['estado']; ?>">



                    <label>Datos:</label>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre']; ?>"
                                disable>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usuario" class="col-form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control"
                                value="<?php echo $row['usuario']; ?>" disable>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rol_id">Rol</label>
                            <select class="form-select" name="rol_id" id="rol_id" disable>
                                <?php foreach ($query as $rol): ?>
                                <?php $selected = ($rol['id'] == $rol["rol_id"]) ? "selected" : "";?>
                                <option value="<?=$rol["id"]?>" <?=$selected?>><?=$rol["nombre"]?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="correo_recuperacion">Correo de recuperacion</label>
                            <input type="email" class="form-control" value="<?php echo $row['correo_recuperacion']; ?>"
                                id="correo_recuperacion" name="correo_recuperacion" disable>
                        </div>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit"
                    class="btn <?=$row["estado"] ? 'btn-danger' : 'btn-success'?>"><?=$row["estado"] ? 'Dar de baja' : 'Activar'?></button>
            </div>
            </form>

        </div>
    </div>
</div>
<!---fin ventana Update --->