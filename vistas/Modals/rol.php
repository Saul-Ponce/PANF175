
<div class="modal fade" id="rolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container ">


<div class="row  ">


    <div class="col d-flex align-items-center justify-content-center">
        <form action="../controladores/ControladorRol.php" method="POST">
            <input type="hidden" name="action" value="insert">

            <label for="nombre_rol" class="form-label">Nombre</label>
            <input type="text" class="form-control" style="width:250px" id="nombre_rol" name="nombre_rol" required>



            <button class="btn btn-primary mt-3 mb-5" type="submit">Agregar rol</button>
            

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