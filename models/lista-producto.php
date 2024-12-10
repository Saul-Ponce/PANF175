<?php
include "../controladores/ControladorProducto.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid mt-4 ">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle">Lista de Productos</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Codigo Producto</th>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Stock Minimo</th>
                            <th scope="col">Stock Maximo</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Imagen del producto</th>
                            <th scope="col">Clasificación</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorProducto::listar() as $row): ?>
                            <tr>
                                <th> <?=$row["codigo_producto"]?></th>
                                <th><?=$row["nombre_p"]?> </th>
                                <th><?=$row["marca"]?></th>
                                <th>$ <?=$row["precio"]?></th>
                                <th><?=$row["stock"]?></th>
                                <th><?=$row["stok_maximo"]?></th>
                                <th><?=$row["nombre"]?></th>
                                <th><?=$row["proveedor"]?></th>
                                <th><img src="../controladores/<?=$row["imagen_p"]?>" style="max-width: 100px; max-height: 100px;"></th>
                                <th><?=$row["clasificacion"]?></th>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarProducto<?php echo $row['codigo_producto']; ?>">Editar</button>
                                        <button  class="btn btn-danger" data-toggle="modal" data-target="#eliminarProducto<?php echo $row['codigo_producto']; ?>">Eliminar</button>
                                    </div>
                                </th>
                            </tr>
                            <?php include '../vistas/Modals/ModalEditarProducto.php';
?>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <?php foreach (ControladorProducto::listar() as $row): ?>
        <?php include '../vistas/Modals/ModalEliminarProducto.php';?>
    <?php endforeach;?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>