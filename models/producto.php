<?php
date_default_timezone_set('America/El_Salvador');
require_once "../models/conexion.php";
include "../models/ProductoModel.php";
$con = connection();
$sql = "SELECT * FROM categoria";
$query = mysqli_query($con, $sql);
$sql2 = "SELECT * FROM proveedor";
$query2 = mysqli_query($con, $sql2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <title>Producto</title>
</head>

<body>
    <div class="container mt-5">
        <form action="../controladores/ControladorProducto.php" method="POST" class="row" name="form"
           onsubmit="return validarFormularioCompleto()" enctype="multipart/form-data">
            <input type="hidden" name="action" value="insert">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre_p">Nombre Producto</label>
                    <input type="text" class="form-control" id="nombre_p" name="nombre_p"   onkeypress="return Solo_Texto(event);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca"  onkeypress="return Solo_Texto(event);">
                </div>
            </div>
            <div class="col-md-6">
    <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" step="any" class="form-control" id="precio" name="precio" oninput="validarNoNegativo('precio')" >
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" oninput="validarNoNegativo('stock')">
    </div>
</div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" id="categoria" name="categoria" >
                        <option value="0">Seleccione</option>
                        <?php foreach ($query as $row): ?>
                            <option value="<?=$row["id_categoria"]?>"><?=$row["nombre"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="proveedor">Proveedor</label>
                    <select class="form-control" id="proveedor" name="proveedor" >
                        <option value="0">Seleccione</option>
                        <?php foreach ($query2 as $row): ?>
                            <option value="<?=$row["id_proveedor"]?>"><?=$row["nombre_p"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="imagen_p">Imagen del producto</label>
        <input  class="form-control-file" id="imagen_p" name="imagen_p" type="file" accept="image/*">
        <img id="previewImage" style="display: none; max-width: 100px; max-height: 100px;">
                </div>
            </div>

            <div class="col-12">
                    <button class="btn btn-primary" type="submit" >Agregar Producto</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <script>

const imageInput = document.getElementById('imagen_p');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function (event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Muestra la vista previa de la imagen
                    previewImage.style.display = 'block';
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(selectedFile);
            } else {
                // Oculta la vista previa si no se selecciona ninguna imagen
                previewImage.style.display = 'none';
                previewImage.src = '';
            }
        });


        function soloNumeros(e) {
            var key = e.charCode || e.keyCode;
            if (key < 48 || key > 57) {
                e.preventDefault();
            }
        }




        function validarFormulario() {
            var rol = document.getElementById('rol').value;
            if (rol == 0) {
                Swal.fire("Debe seleccionar un rol");
                return false; // Evitar el envío del formulario
            }
            return true;
        }

        function Solo_Texto(e) {
    var code;
    if (!e) var e = window.event;
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    var character = String.fromCharCode(code);
    var AllowRegex  = /^[\ba-zA-Z\s-]$/;
    if (AllowRegex.test(character)) return true;
    return false;
}

function validarNoNegativo(campo) {
    const elemento = document.getElementById(campo);
    if (elemento.value < 0 || isNaN(elemento.value)) {
        elemento.value = 0;
    }
}

function validarFormularioCompleto() {
    const nombreProducto = document.getElementById('nombre_p').value;
    const marca = document.getElementById('marca').value;
    const precio = document.getElementById('precio').value;
    const stock = document.getElementById('stock').value;
    const categoria = document.getElementById('categoria').value;
    const proveedor = document.getElementById('proveedor').value;
    const imagen = document.getElementById('imagen_p').files;

    if (!nombreProducto || !marca || !precio || !stock || categoria === '0' || proveedor === '0' || imagen.length === 0) {
        Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
        return false; // Evitar el envío del formulario
    }

    if (isNaN(precio) || isNaN(stock) || precio < 0 || stock < 0) {
        Swal.fire("Aviso", "El precio y el stock deben ser valores numéricos positivos.", "warning");
        return false; // Evitar el envío del formulario
    }

    // Si todas las validaciones son exitosas, el formulario se enviará
    return true;
}


    </script>
</body>

</html>
