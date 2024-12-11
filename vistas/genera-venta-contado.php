<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    if ($_SESSION['rol'] != "Vendedor") {
        echo '
        <script>
            alert("Por favor Inicia Sesion");
            window.location = "../index.html"
        </script>
        ';
        session_destroy();
        die();
    }
}

require_once "../models/conexion.php";
include "../models/VentaModel.php";
include "../models/UsuarioModel.php";
$con = connection();
$sql = "SELECT * FROM productos INNER JOIN inventario WHERE inventario.producto_id = productos.id";
$query = mysqli_query($con, $sql);

$sql = "SELECT * FROM clientesjuridicos";
$cjquery = mysqli_query($con, $sql);
$sql = "SELECT * FROM clientesnaturales";
$cnquery = mysqli_query($con, $sql);
$nombre = $_SESSION['usuario'];
$id = UsuarioModel::obtener_IDusuario($nombre);
$ident = implode($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrar venta al contado</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
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
                        <h3 class="card-title">Generar Venta</h3>
                    </div>
                    <div class="card-body">
                        <form id="form" class="row" name="form" action="../controladores/ControladorVentaContado.php"
                            method="POST" class="row">
                            <div class="row">
                                <label class="form-label">Seleccione el tipo de cliente</label>
                                <div class="form-selectgroup mb-2">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="cliente" value="cliente-juridico"
                                            class="form-selectgroup-input">
                                        <span onclick="mostrarSelectCliente('juridico')" class="form-selectgroup-label">
                                            Cliente Juridico</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="cliente" value="cliente-natural"
                                            class="form-selectgroup-input" checked>
                                        <span onclick="mostrarSelectCliente('natural')" class="form-selectgroup-label">
                                            Cliente Natural</span>
                                    </label>
                                </div>

                                <input type="hidden" name="action" value="insert">
                                <input type="hidden" name="tipo_venta" value="contado">
                                <input type="hidden" id="usuario_id" name="usuario_id"
                                    value="<?php echo $_SESSION['id'] ?>">
                                <input type="hidden" id="data_array" name="data_array">
                                <input type="hidden" name="tipo_cliente" id="tipo_cliente" value="natural">
                                <div id="cliente" class="col-lg-5">
                                    <label>Cliente</label><input type="hidden" id="cliente" name="cliente"
                                        value="cliente-natural"><select class="form-select" id="clienteSelect"
                                        name="clienteSelect" placeholder="Seleccione un cliente...">
                                        <option value=""> Seleccione un cliente... </option>
                                        <?php foreach ($cnquery as $row): ?>
                                        <option value="<?= $row["id"] ?>" <?= $row["id"] == 15 ? 'selected' : '' ?>
                                            data-id="<?= $row["id"] ?>">
                                            <?= $row["id"] ?> <?= $row["nombre"] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label>Fecha</label>
                                    <?php date_default_timezone_set("America/El_Salvador");
                                    $fecha = date("Y-m-d"); ?>
                                    <input type="date" class="form-control" value="<?= $fecha ?>" id="fecha_venta"
                                        name="fecha" readonly>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-end">
                                <div class="col-lg-4">
                                    <label>Producto</label>

                                    <select class="form-select" id="productSelect" aria-placeholder="Seleccione"
                                        name="productSelect">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($query as $row): ?>
                                        <option value="<?= $row["id"] ?>" data-code="<?= $row["codigo"] ?>"
                                            data-stock="<?= $row["stok"] ?>"
                                            data-price="<?= $row["precio_venta"] + ($row["precio_venta"] * 0.25) ?>"
                                            data-inv="<?= $row["idInventario"] ?>" data-product="<?= $row["id"] ?>">
                                            <?= $row["codigo"] ?> | <?= $row["nombre"] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label>Precio($)</label>
                                    <input readonly class="form-control" id="txtprecio" name="txtprecio"
                                        type="number" />
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
                                    <input type="button" Value="Agregar" id="btnagregar" name="btnagregar"
                                        class="form-control btn btn-primary" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <label>PRECIO TOTAL</label>

                                    <input class="form-control" id="total_venta" name="total_venta" type="text"
                                        placeholder="00.00" readonly>
                                </div>
                            </div>



                            <div class="col-lg-12 mt-4">

                                <a class="btn btn-danger" id="btncancelar">Cancelar</a>
                                <button class="btn btn-primary" type="submit">Guardar venta</button>

                            </div>


                        </form>

                        <div id="cartContainer" class="mt-4" style="display: none">
                            <div class="row">


                                <table class="table table-striped" id="cartTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">cantidad</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Cart items will be dynamically added here -->
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


    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>
    <script src="../public/assets/js/toast.js"></script>
    <!-- END content-page -->




    <script>
    function mostrarSelectCliente(tipo) {
        if (tipo == 'juridico') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='cliente' name='cliente' value='cliente-juridico'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...' > <option value='' > Seleccione un cliente... </option> <?php foreach ($cjquery as $row): ?> <option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>'> <?= $row['id'] ?>                                                 <?= $row['nombre'] ?> </option> <?php endforeach; ?></select>"
            window.TomSelect && (new TomSelect("#clienteSelect", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            }));
            document.getElementById('tipo_cliente').value = "juridico"
        } else if (tipo == 'natural') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='cliente' name='cliente' value='cliente-natural'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...'> <option value='' > Seleccione un cliente... </option> <?php foreach ($cnquery as $row): ?> <option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>' > <?= $row['id'] ?>                                                     <?= $row['nombre'] ?> </option> <?php endforeach; ?></select>"
            window.TomSelect && (new TomSelect("#clienteSelect", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            }));
            document.getElementById('tipo_cliente').value = "natural"
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

    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageV'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageV']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageV']); // Clear the message ?>
    <?php endif; ?>

    var availableStock = {};


    // Attach a submit event listener to the form
    document.getElementById('form').addEventListener('submit', function(event) {
        // Serialize the array and set it as the value of the hidden input
        var serializedArray = JSON.stringify(cart);
        document.getElementById('data_array').value = serializedArray;
    });


    $(document).ready(function() {
        $('#productSelect').on('change', function() {
            var selectedPrice = $('option:selected', this).data('price');
            $('#txtprecio').val(selectedPrice);
        });
    });

    $(document).ready(function() {
        $('#productSelect').on('change', function() {
            var selectedPrice = $('option:selected', this).data('stock');
            $('#txtstock').val(selectedPrice);
        });
    });

    $(document).ready(function() {
        $('#clienteSelect').on('change', function() {
            var selectedTel = $('option:selected', this).data('numerot');
            $('#txttelefono').val(selectedTel);
        });
    });

    $(document).ready(function() {
        $('#clienteSelect').on('change', function() {
            var selectedDUI = $('option:selected', this).data('dui');
            $('#txtDUI').val(selectedDUI);
        });
    });



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
            var inv_id = parseInt(selectedOption.getAttribute("data-inv"));
            var product = parseInt(selectedOption.getAttribute("data-product"));



            // Initialize available stock for the selected product if not already done
            if (!availableStock[selectedProductCode]) {
                availableStock[selectedProductCode] = stock;
            }

            // Calculate the total quantity in the cart for the selected product
            var totalQuantityInCart = cart
                .filter(item => item.product === selectedProductName)
                .reduce(function(total, item) {
                    return total + item.quantity;
                }, 0);

            if (quantity > 0 && (totalQuantityInCart + quantity) <= availableStock[selectedProductCode]) {
                var existingItem = cart.find(item => item.product === selectedProductName);

                if (existingItem) {
                    // If the same product is already in the cart, update its quantity
                    existingItem.quantity += quantity;
                } else {
                    // Otherwise, add the new item to the cart
                    var item = {
                        code: selectedProductCode,
                        product: product,
                        price: parseFloat(selectedProductPrice),
                        quantity: quantity,
                        inv: inv_id,
                    };
                    cart.push(item);
                }

                // Update the cart table, its visibility, and the total price
                updateCartTable();
                updatetotal();
            } else if (quantity > (availableStock[selectedProductCode] - totalQuantityInCart)) {
                alert("No hay suficiente stock. Cantidad disponible: " + (availableStock[selectedProductCode] -
                    totalQuantityInCart));
            } else {
                alert("Please enter a valid quantity.");
            }
        } else {
            alert("Seleccione un producto.");
        }
    });

    var cart = []; // Array to store cart items

    function addItemToCart(item) {
        cart.push(item);

    }

    function updateCartTable() {
        var tableBody = document.querySelector("#cartTable tbody");
        tableBody.innerHTML = ""; // Clear the table body

        if (cart.length > 0) {
            document.getElementById("cartContainer").style.display = "block"; // Show the table
            cart.forEach(function(item) {
                var row = tableBody.insertRow();
                var productCell = row.insertCell(0);
                var priceCell = row.insertCell(1);
                var quantityCell = row.insertCell(2);
                var actionCell = row.insertCell(3);

                productCell.innerHTML = item.product;
                priceCell.innerHTML = item.price;
                quantityCell.innerHTML = item.quantity;
                actionCell.innerHTML =
                    '<button type="button" class="btn btn-danger" onclick="removeItem(this)"><i class="fa-solid fa-trash"></i></button></button>';
            });
        } else {
            document.getElementById("cartContainer").style.display = "none"; // Hide the table
        }

    }

    function removeItem(button) {
        var row = button.parentNode.parentNode;
        var index = row.rowIndex - 1; // Subtract 1 to account for the table header
        cart.splice(index, 1);
        updateCartTable();
        updatetotal();
    }

    function updatetotal() {
        var totalInput = document.getElementById("total_venta");
        var total = 0;

        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            total += item.price * item.quantity;
        }

        totalInput.value = total.toFixed(2); // Display total with two decimal places
    }
    </script>