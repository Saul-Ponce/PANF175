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
include "../models/CompraModel.php";
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

    <title>Generar Compra</title>
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
                                <h1 class="main-title float-left">Generar Compra</h1>
                                <div class="clearfix">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                    <hr>
                    <form id="form" name="form"  action="../controladores/ControladorCompra.php" method="POST">
                    <div class="row">
                        <!-- Button trigger modal -->

                        <div class="col-lg-5">
                            <label>Usuario</label>
                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" id="data_array" name="data_array">

                            <div class="form-group">
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre" value="<?php echo $row ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>DUI</label>
                            <input type="text" class="form-control" id="dui" name="dui" value="<?php echo $ident ?>" readonly>
                        </div>

                        <div class="col-lg-2">
                            <label>Telefono</label>
                            <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $tel[0] ?>" readonly>
                        </div>


                        <div class="col-lg-2">
                            <label>Fecha</label>
                            <?php date_default_timezone_set("America/El_Salvador");
$fecha = date("Y-m-d");?>
                            <input readonly type="date" id="fecha" name="fecha" class="form-control" value="<?=$fecha?>">
                        </div>

                    </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <label>Producto</label>

                                <select class="form-control" id="productSelect" name="productSelect">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                        <option value="<?=$row["codigo_producto"]?>" data-price="<?=$row["precio"]?>"><?=$row["nombre_p"]?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <label>Precio</label>
                                <input readonly class="form-control" id="txtprecio" name="txtprecio" type="number" />
                            </div>
                            <div class="col-lg-2">
                                <label>Cantidad</label>
                                <input class="form-control" id="txtcantidad" name="txtcantidad" type="number" />
                            </div>
                            <div class="col-lg-2">
                                <label> .</label>
                                <input type="button" Value="Agregar" id="btnagregar" name="btnagregar" class="form-control btn btn-primary" />
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12 mt-4">
                            <center>
                                <a class="btn btn-danger" id="btncancelar">Cancelar</a>
                                <button class="btn btn-primary" type="submit">Guardar venta</button>
                            </center>
                        </div>
                    </div>
                    <div id="cartContainer" class="mt-4"  style="display: none">
                        <div class="row">
                            <div class="col-lg-3">
                            <label>PRECIO TOTAL</label>

                            <input class="form-control" id="total" name="total" type="text" placeholder="00.00" readonly>
                        </div>

                            <table class="table table-striped" id="cartTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Cart items will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>







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
     <?php if (isset($_SESSION['success_messageC'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageC']); // Clear the message ?>
    <?php endif;?>

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

            if (quantity > 0) {
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

                // Update the cart table and its visibility
                updateCartTable();
                updateTotalPrice();
            } else {
                alert("Porfavor Ingrese un numero valido!!!");
            }
        } else {
            alert("Porfavor Seleccione un producto!!!");
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
                actionCell.innerHTML = '<button onclick="removeItem(this)">Quitar</button>';
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
        updateTotalPrice();
    }

    function updateTotalPrice() {
    var totalPriceInput = document.getElementById("total");
    var total = 0;

    for (var i = 0; i < cart.length; i++) {
        var item = cart[i];
        total += item.price * item.quantity;
    }

    totalPriceInput.value = total.toFixed(2); // Display total with two decimal places

}
</script>