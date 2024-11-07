<?php
$con = connection();
$sql = "SELECT * FROM fiadores";
$query = mysqli_query($con, $sql);

?>

<!-- Modal -->
<div class="modal modal-blur fade" id="mdCN" tabindex="-1" role="dialog" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Datos del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>
            <form action="../controladores/ControladorClienteNatural.php" method="POST" name="form" id="form">
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
                            <label for="recipient-name" class="col-form-label">direccion</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" value=""
                                onkeypress="return Solo_Texto(event);" required="true">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">email</label>
                            <input type="email" name="email" id="email" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">ingresos</label>
                            <input type="text" name="ingresos" id="ingresos" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">egresos</label>
                            <input type="text" name="egresos" id="egresos" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">estado_civil</label>
                             <select class="form-select" id="estado_civil" name="estado_civil">
                                    <option value="0">Seleccione</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="casado">Casado</option>
                                    <option value="viudo">Viudo</option>
                                    <option value="separado">Separado</option>
                                    <option value="divorciado">Divorciado</option>
                                
                                </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">lugar_trabajo</label>
                            <input type="text" name="lugar_trabajo" id="lugar_trabajo" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">dui</label>
                            <input type="text" name="dui" id="dui" class="form-control" value="">
                        </div>

                        
                        <div class="form-group col-md-8">
                            <label for="recipient-name" class="col-form-label">fiador</label>
                            <select class="form-select" id="fiador_id" name="fiador_id">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                    <option value="<?=$row["id"]?>"> <?=$row["nombre"]?> <?="-"?> <?=$row["dui"]?></option>
                                    <?php endforeach;?>
                                </select>
                        </div>

                        
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">clasificacion</label>
                            <select class="form-select" id="clasificacion_id" name="clasificacion_id">
                                    <option value="2">A</option>
                                    <option value="3">B</option>
                                    <option value="4">C</option>
                                    <option value="5">D</option>
                                   
                                
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