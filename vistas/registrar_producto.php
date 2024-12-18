<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}

require_once "../models/conexion.php";
$con = connection();
$sql = "SELECT * FROM categoriaproducto";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Productos</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agregar Productos</h3>
                </div>
                <div class="card-body">
                    <form action="../controladores/ControladorProducto.php" method="POST" class="row" name="form"
                        enctype="multipart/form-data" onsubmit="return validarFormulariocompleto()">
                        <input type="hidden" name="action" value="insert">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol">Categoria</label>
                                <select class="form-select" id="cat_id" name="cat_id">
                                    <option value="0" disabled selected>Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                        <option value="<?= $row["id"] ?>"><?= $row["nombre"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="imagen">Imagen del producto</label>
                                <input class="form-control" id="imagen" name="imagen" type="file" accept="image/*" require="true">
                                <img id="previewImage" style="display: none; max-width: 100px; max-height: 100px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol">Clasificacion</label>
                                <select class="form-select" id="clasificacion" name="clasificacion">
                                    <option value="0" disabled selected>Seleccione</option>
                                    <option value="A">Alta Prioridad</option>
                                    <option value="B">Media Prioridad</option>
                                    <option value="C">Baja Prioridad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock">Stock Minimo</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    oninput="validarNoNegativo('stock')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stockmax">Stock Maximo</label>
                                <input type="number" class="form-control" id="stockmax" name="stockmax"
                                    oninput="validarNoNegativo('stock')">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar Producto</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    <?php include '../layouts/Footer.php'; ?>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>


    <script>
        const numero1 = document.getElementById('stockmax');
    const numero2 = document.getElementById('stock');

    // Actualizar el valor máximo permitido en el segundo campo
    numero1.addEventListener('input', () => {
        numero2.setAttribute('max', numero1.value);
    });

    function validarFormulario() {
        const valor1 = parseFloat(numero1.value);
        const valor2 = parseFloat(numero2.value);

        if (valor2 > valor1) {
            alert('El número 2 no puede ser mayor que el número 1.');
            return false; // Evitar el envío del formulario
        }
        return true; // Permitir el envío del formulario
    }

        //evitar que cualquier campo de texto envie el formulario despues de dar enter
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            }))
        });
        const imageInput = document.getElementById('imagen');
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

        function validarNoNegativo(campo) {
            const elemento = document.getElementById(campo);
            if (elemento.value < 0 || isNaN(elemento.value)) {
                elemento.value = 0;
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
            var AllowRegex = /^[\ba-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/;
            if (AllowRegex.test(character)) return true;
            return false;
        }

    </script>
</body>

</html>