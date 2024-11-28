<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor, inicia sesión");
        window.location = "../index.html";
    </script>
    ';
    session_destroy();
    die();
}

require_once "../models/conexion.php";
include "../models/VentaCreditoModel.php"; // Asegúrate de que este es el modelo correcto
include "../models/UsuarioModel.php";
$con = connection();

// Consultas para obtener los productos y clientes
$sqlProductos = "SELECT * FROM productos INNER JOIN inventario WHERE inventario.producto_id = productos.id";
$queryProductos = mysqli_query($con, $sqlProductos);

$sqlClientesJuridicos = "SELECT * FROM clientesjuridicos";
$cjquery = mysqli_query($con, $sqlClientesJuridicos);

$sqlClientesNaturales = "SELECT * FROM clientesnaturales";
$cnquery = mysqli_query($con, $sqlClientesNaturales);

$nombre = $_SESSION['usuario'];
$id = UsuarioModel::obtener_IDusuario($nombre);
$ident = implode($id);
?>

<!DOCTYPE html>
<html lang="es"> <!-- Cambié 'en' por 'es' para español -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrar venta al crédito</title>
    <meta content="Proyecto de análisis financiero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <div class="page-body">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <div class="container-xl">
            <!-- Start content -->
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Generar Venta al Crédito</h3>
                    </div>
                    <div class="card-body">
                        <!-- Formulario con enctype para permitir subida de archivos -->
                        <form id="form" class="row" name="form" action="../controladores/ControladorVentaCredito.php"
                            method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <label class="form-label">Seleccione el tipo de cliente</label>
                                <div class="form-selectgroup mb-2">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="cliente" value="cliente-juridico"
                                            class="form-selectgroup-input">
                                        <span onclick="mostrarSelectCliente('juridico')"
                                            class="form-selectgroup-label">Cliente Jurídico</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="cliente" value="cliente-natural"
                                            class="form-selectgroup-input" checked>
                                        <span onclick="mostrarSelectCliente('natural')"
                                            class="form-selectgroup-label">Cliente Natural</span>
                                    </label>
                                </div>

                                <input type="hidden" name="action" value="insert">
                                <input type="hidden" class="form-control" id="dui_emp" name="dui_emp"
                                    value="<?php echo $ident; ?>">

                                <input type="hidden" id="data_array" name="data_array">

                                <!-- Campo de selección de cliente -->
                                <div id="cliente" class="col-lg-5">
                                    <label>Cliente</label>
                                    <input type="hidden" id="tipo-cliente" name="tipo-cliente" value="cliente-natural">
                                    <select class="form-select" id="clienteSelect" name="clienteSelect"
                                        placeholder="Seleccione un cliente...">
                                        <option value="">Seleccione un cliente...</option>
                                        <?php foreach ($cnquery as $row): ?>
                                        <option value="<?= $row['id'] ?>" data-id="<?= $row['id'] ?>">
                                            <?= $row['id'] ?> <?= $row['nombre'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Campo de fecha y contrato de venta -->
                                <div class="col-lg-3">
                                    <label>Fecha</label>
                                    <?php date_default_timezone_set("America/El_Salvador");
                                    $fecha = date("Y-m-d"); ?>
                                    <input type="date" class="form-control" value="<?= $fecha ?>" id="fecha_venta"
                                        name="fecha_venta" readonly>
                                </div>

                                <div class="col-lg-4">
                                    <label>Contrato de venta al crédito (Aval)</label>
                                    <input type="file" class="form-control" id="contrato_venta" name="contrato_venta">
                                </div>
                            </div>

                            <div class="row mt-4 align-items-end">
                                <div class="col-lg-4">
                                    <label>Producto</label>
                                    <select class="form-select" id="productSelect" name="productSelect">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($queryProductos as $row): ?>
                                        <option value="<?= $row['id'] ?>" data-code="<?= $row['codigo'] ?>"
                                            data-stock="<?= $row['cantidad'] ?>"
                                            data-price="<?= ($row['total_venta'] / $row['cantidad']) + (($row['total_venta'] / $row['cantidad'])*0.22) ?>">
                                            <?= $row['codigo'] ?> | <?= $row['nombre'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label>Precio</label>
                                    <input readonly class="form-control" id="txtprecio" name="txtprecio" type="number" />
                                </div>

                                <div class="col-lg-2">
                                    <label>Stock</label>
                                    <input readonly class="form-control" id="txtstock" name="txtstock" type="number" />
                                </div>

                                <div class="col-lg-2">
                                    <label>Cantidad</label>
                                    <input class="form-control" id="txtcantidad" name="txtcantidad" type="number" />
                                </div>

                                <div class="col-lg-2">
                                    <input type="button" value="Agregar" id="btnagregar" name="btnagregar"
                                        class="form-control btn btn-primary" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <label>PRECIO TOTAL</label>
                                    <input class="form-control" id="total" name="total" type="text" placeholder="00.00"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <a class="btn btn-danger" id="btncancelar">Cancelar</a>
                                <button class="btn btn-primary" type="submit">Guardar venta al crédito</button>
                            </div>
                        </form>

                        <div id="cartContainer" class="mt-4" style="display: none;">
                            <div class="row">
                                <table class="table table-striped" id="cartTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los items del carrito se agregarán dinámicamente aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- END container-fluid -->

            </div>
            <!-- END content -->

        </div>
        <?php include '../layouts/Footer.php'; ?>
    </div>

    <!-- Scripts de Bootstrap y otros -->
    <?php include '../layouts/footerScript.php'; ?>
    <script src="../public/assets/js/toast.js"></script>

    <script>
    // Función para mostrar el select del cliente según el tipo
    function mostrarSelectCliente(tipo) {
        if (tipo == 'juridico') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-juridico'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...'> <option value=''>Seleccione un cliente...</option><?php foreach ($cjquery as $row): ?><option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>'><?= $row['id'] ?> <?= $row['nombre'] ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            }));
        } else if (tipo == 'natural') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-natural'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...'> <option value=''>Seleccione un cliente...</option><?php foreach ($cnquery as $row): ?><option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>'><?= $row['id'] ?> <?= $row['nombre'] ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            }));
        }
    }

    $(document).ready(function() {
        window.TomSelect && (new TomSelect("#clienteSelect", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        }));
        window.TomSelect && (new TomSelect("#productSelect", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        }));
    });

    // Mensaje de éxito si existe en la sesión
    <?php if (isset($_SESSION['success_messageV'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageV']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageV']); // Limpiar el mensaje ?>
    <?php endif; ?>

    var availableStock = {};

    // Evento submit del formulario
    document.getElementById('form').addEventListener('submit', function(event) {
        // Serializar el array y establecerlo en el input oculto
        var serializedArray = JSON.stringify(cart);
        document.getElementById('data_array').value = serializedArray;
    });

    // Actualizar precio al seleccionar un producto
    $(document).ready(function() {
        $('#productSelect').on('change', function() {
            var selectedPrice = $('option:selected', this).data('price');
            $('#txtprecio').val(selectedPrice);

            var selectedStock = $('option:selected', this).data('stock');
            $('#txtstock').val(selectedStock);
        });
    });

    // Variables y funciones para manejar el carrito
    var cart = []; // Array para almacenar los items del carrito

    document.getElementById("btnagregar").addEventListener("click", function() {
        var selectElement = document.getElementById("productSelect");
        var selectedIndex = selectElement.selectedIndex;
        var quantityInput = document.getElementById("txtcantidad");

        if (selectedIndex !== -1 && selectedIndex !== 0) {
            var selectedOption = selectElement.options[selectedIndex];
            var selectedProductCode = selectedOption.value;
            var selectedProductPrice = selectedOption.getAttribute("data-price");
            var selectedProductName = selectedOption.textContent;
            var quantity = parseInt(quantityInput.value);
            var stock = parseInt(selectedOption.getAttribute("data-stock"));

            // Inicializar el stock disponible para el producto seleccionado si no está ya hecho
            if (!availableStock[selectedProductCode]) {
                availableStock[selectedProductCode] = stock;
            }

            // Calcular la cantidad total en el carrito para el producto seleccionado
            var totalQuantityInCart = cart
                .filter(item => item.product === selectedProductName)
                .reduce(function(total, item) {
                    return total + item.quantity;
                }, 0);

            if (quantity > 0 && (totalQuantityInCart + quantity) <= availableStock[selectedProductCode]) {
                var existingItem = cart.find(item => item.product === selectedProductName);

                if (existingItem) {
                    // Si el mismo producto ya está en el carrito, actualizar su cantidad
                    existingItem.quantity += quantity;
                } else {
                    // De lo contrario, agregar el nuevo item al carrito
                    var item = {
                        code: selectedProductCode,
                        product: selectedProductName,
                        price: parseFloat(selectedProductPrice),
                        quantity: quantity,
                    };
                    cart.push(item);
                }

                // Actualizar la tabla del carrito y el precio total
                updateCartTable();
                updatetotal();
            } else if (quantity > (availableStock[selectedProductCode] - totalQuantityInCart)) {
                alert("No hay suficiente stock. Cantidad disponible: " + (availableStock[selectedProductCode] -
                    totalQuantityInCart));
            } else {
                alert("Por favor, ingrese una cantidad válida.");
            }
        } else {
            alert("Seleccione un producto.");
        }
    });

    function updateCartTable() {
        var tableBody = document.querySelector("#cartTable tbody");
        tableBody.innerHTML = ""; // Limpiar la tabla

        if (cart.length > 0) {
            document.getElementById("cartContainer").style.display = "block"; // Mostrar la tabla
            cart.forEach(function(item) {
                var row = tableBody.insertRow();
                var productCell = row.insertCell(0);
                var priceCell = row.insertCell(1);
                var quantityCell = row.insertCell(2);
                var actionCell = row.insertCell(3);

                productCell.innerHTML = item.product;
                priceCell.innerHTML = item.price.toFixed(2);
                quantityCell.innerHTML = item.quantity;
                actionCell.innerHTML =
                    '<button type="button" class="btn btn-danger" onclick="removeItem(this)"><i class="fa-solid fa-trash"></i></button>';
            });
        } else {
            document.getElementById("cartContainer").style.display = "none"; // Ocultar la tabla
        }
    }

    function removeItem(button) {
        var row = button.parentNode.parentNode;
        var index = row.rowIndex - 1; // Restar 1 por el encabezado de la tabla
        cart.splice(index, 1);
        updateCartTable();
        updatetotal();
    }

    function updatetotal() {
        var totalInput = document.getElementById("total");
        var total = 0;

        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            total += item.price * item.quantity;
        }

        totalInput.value = total.toFixed(2); // Mostrar total con dos decimales
    }
    </script>
</body>

</html>
