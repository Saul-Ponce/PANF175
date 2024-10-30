<!-- Modal para eliminar clasificación -->
<div class="modal fade" id="eliminarClasificacion<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Seguro que desea eliminar esta clasificación?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../controladores/ControladorClasificacion.php" method="POST">
                <input type="hidden" name="action" value="borrar">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="modal-body">
                    <p>Nombre: <strong><?php echo $row['nombre']; ?></strong></p>
                    <p>Descripción: <strong><?php echo $row['descripcion']; ?></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
