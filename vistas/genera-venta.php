<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}

require_once "../models/conexion.php";
include "../models/VentaModel.php";
include "../models/UsuarioModel.php";
$con = connection();
$sql = "SELECT * FROM producto";
$query = mysqli_query($con, $sql);

$sql = "SELECT * FROM cliente";
$cquery = mysqli_query($con, $sql);
$nombre = $_SESSION['usuario'];
$id = UsuarioModel::obtener_IDusuario($nombre);
$tel = UsuarioModel::obtener_tel($id[0]);
$ident = implode($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--     Fonts and icons     -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />


    <!--   Core JS Files   -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="../assets/js/light-bootstrap-dashboard.js " type="text/javascript"></script>

    <title>Empleado</title>
</head>

<body>
    <?php
include '../includes/sidebar.php';
?>
    <div class="main-panel">
        <div class="content-page">

            <!-- Start content -->
            <div class="content">

                <div class="container">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder">
                                <h1 class="main-title float-left">Generar Venta</h1>
                                <div class="clearfix">

                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="form" name="form" action="../controladores/ControladorVenta.php" method="POST" class="row">
                        <div class="row">


                            <div class="col-lg-5">
                                <label>Cliente</label>
                                <input type="hidden" name="action" value="insert">
                                <input type="hidden" class="form-control" id="dui_emp" name="dui_emp" value="<?php echo $ident ?>">

                                <input type="hidden" id="data_array" name="data_array">

                                <select class="form-control" id="clienteSelect" name="clienteSelect">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($cquery as $row): ?>
                                        <option value="<?=$row["dui_cliente"]?>" data-dui="<?=$row["dui_cliente"]?>" data-numerot="<?=$row["telefono_c"]?>"> <?=$row["nombre_c"]?> <?=$row["apellido_c"]?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>



                            <div class="col-lg-2">
                                <label>DUI</label>
                                <input readonly class="form-control" id="txtDUI" name="dui_c" type="text" />
                            </div>

                            <div class="col-lg-2">
                                <label>Telefono</label>
                                <input readonly class="form-control" id="txttelefono" name="txttelefono" type="text" />
                            </div>


                            <div class="col-lg-2">
                                <label>Fecha</label>
                                <?php date_default_timezone_set("America/El_Salvador");
$fecha = date("Y-m-d");?>
                                <input type="date" class="form-control" value="<?=$fecha?>" id="fecha_venta" name="fecha_venta">
                            </div>

                        </div>

                        <hr>

                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <label>Producto</label>

                                <select class="form-control" id="productSelect" name="productSelect">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                        <option value="<?=$row["codigo_producto"]?>" data-code="<?=$row["codigo_producto"]?>" data-stock="<?=$row["stock"]?>" data-price="<?=$row["precio"]?>"><?=$row["nombre_p"]?></option>
                                    <?php endforeach;?>
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
                                <label>´</label>
                                <input type="button" Value="Agregar" id="btnagregar" name="btnagregar" class="form-control btn btn-primary" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <label>PRECIO TOTAL</label>

                                <input class="form-control" id="total" name="total" type="text" placeholder="00.00" readonly>
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
                <!-- END container-fluid -->

            </div>
            <!-- END content -->

        </div>
    </div>
</body>
<!-- END content-page -->




<script>
     // Check if a success message is set in the session
     <?php if (isset($_SESSION['success_messageV'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageV']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageV']); // Clear the message ?>
    <?php endif;?>

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
                        product: selectedProductName,
                        price: parseFloat(selectedProductPrice),
                        quantity: quantity,
                    };
                    cart.push(item);
                }

                // Update the cart table, its visibility, and the total price
                updateCartTable();
                updatetotal();
            } else if (quantity > (availableStock[selectedProductCode] - totalQuantityInCart)) {
                alert("No hay suficiente stock. Cantidad disponible: " + (availableStock[selectedProductCode] - totalQuantityInCart));
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
                actionCell.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeItem(this)"><i class="fa-solid fa-trash"></i></button></button>';
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
        var totalInput = document.getElementById("total");
        var total = 0;

        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            total += item.price * item.quantity;
        }

        totalInput.value = total.toFixed(2); // Display total with two decimal places
    }
</script>