
<div class="modal fade" id="edit-rolModal<?php echo $row["id_rol"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container ">


<div class="row">


    <div class="col">

        <form action="../controladores/ControladorRol.php" method="POST">

            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id_rol" value="<?php echo $row['id_rol']; ?>">

            <label for="nombre_rol" class="form-label">Rol</label>

            <input type="text" class="form-control mb-3" style="width:250px" id="nombre_rol" name="nombre_rol" value="<?php echo $row['nombre_rol']; ?>">



            <button class="btn btn-success " type="submit">editar</button>


        </form>
    </div>


</div>
</div>




      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>