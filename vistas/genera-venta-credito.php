<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    if($_SESSION['rol'] != "Vendedor"){
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
include "../models/VentaCreditoModel.php"; // Asegúrate de que este es el modelo correcto
include "../models/UsuarioModel.php";
include_once "../controladores/ControladorIntereses.php";
$con = connection();

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
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrar venta al crédito</title>
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <div class="page-body">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generar Venta al Crédito</h3>
                </div>
                <div class="card-body">
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
                            <input type="hidden" class="form-control" id="dui_emp" name="dui_emp" value="<?php echo $ident; ?>">
                            <input type="hidden" id="data_array" name="data_array">

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

                            <div class="col-lg-3">
                                <label>Fecha</label>
                                <?php date_default_timezone_set("America/El_Salvador");
                                $fecha = date("Y-m-d"); ?>
                                <input type="date" class="form-control" value="<?= $fecha ?>" id="fecha_venta"
                                    name="fecha_venta" readonly>
                            </div>

                            <div class="col-lg-3">
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
                                        data-stock="<?= $row['stok'] ?>" data-price="<?= $row['precio_venta'] ?>">
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
                                <input class="form-control" id="txtcantidad" name="txtcantidad" type="number" min="0"/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label for="plazo">Plazo de Pago (Meses)</label>
                                <select id="plazo" name="plazo" class="form-select" required>
                                    <option value="" disabled selected>Seleccione el plazo</option>
                                    <?php
                                    $intereses = ControladorIntereses::listar();
                                    if ($intereses && mysqli_num_rows($intereses) > 0) {
                                        while ($row = mysqli_fetch_assoc($intereses)) {
                                            echo "<option value='{$row['plazo_meses']}' data-interes='{$row['tasa_interes']}'>
                                                {$row['plazo_meses']} meses
                                            </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="tasa_interes">Tasa de Interés (%)</label>
                                <input type="text" id="tasa_interes" name="tasa_interes" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row mt-3 align-items-end">
                            <div class="col-lg-6">
                                <label>PRECIO TOTAL</label>
                                <input class="form-control" id="total" name="total" type="text" placeholder="00.00" readonly>
                            </div>
                            <div class="col-lg-6">
                                <label for="monto_total_interes">Monto Total con Intereses ($)</label>
                                <input type="text" id="monto_total_interes" name="monto_total_interes" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Tabla de cuotas -->
                        <div class="row mt-4" id="installmentsContainer" style="display:none;">
                            <div class="col-lg-12">
                                <h5>Detalle de Cuotas</h5>
                                <table class="table table-bordered" id="installmentsTable">
                                    <thead>
                                        <tr>
                                            <th>No. de Cuota</th>
                                            <th>Monto de la Cuota ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Se llenará dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12 text-end">
                                <input type="button" value="Agregar" id="btnagregar" name="btnagregar" class="btn btn-primary" />
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
                                        <th>Producto</th>
                                        <th>Precio Unit.</th>
                                        <th>Cantidad</th>
                                        <th>Costo Total sin Int.</th>
                                        <th>% Interés</th>
                                        <th>Plazo (Meses)</th>
                                        <th>Costo Total c/ Int.</th>
                                        <th>Valor Cuota/mes</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items del carrito dinámicos -->
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
    <?php include '../layouts/footerScript.php'; ?>
    <script src="../public/assets/js/toast.js"></script>

    <script>
    var availableStock = {};
    var cart = [];

    function mostrarSelectCliente(tipo) {
        if (tipo == 'juridico') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-juridico'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...'> <option value=''>Seleccione un cliente...</option><?php foreach ($cjquery as $row): ?><option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>'><?= $row['id'] ?> <?= $row['nombre'] ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {create: false,sortField:{field:"text",direction:"asc"}}));
        } else if (tipo == 'natural') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-natural'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...'> <option value=''>Seleccione un cliente...</option><?php foreach ($cnquery as $row): ?><option value='<?= $row['id'] ?>' data-id='<?= $row['id'] ?>'><?= $row['id'] ?> <?= $row['nombre'] ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {create: false,sortField:{field:"text",direction:"asc"}}));
        }
    }

    $(document).ready(function() {
        window.TomSelect && (new TomSelect("#clienteSelect", {create: false,sortField:{field:"text",direction:"asc"}}));
        window.TomSelect && (new TomSelect("#productSelect", {create: false,sortField:{field:"text",direction:"asc"}}));

        <?php if (isset($_SESSION['success_messageV'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageV']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageV']); ?>
        <?php endif; ?>

        $('#productSelect').on('change', function() {
            var selectedPrice = $('option:selected', this).data('price');
            $('#txtprecio').val(selectedPrice);

            var selectedStock = $('option:selected', this).data('stock');
            $('#txtstock').val(selectedStock);

            updatePreviewTotals();
        });

        $('#txtcantidad').on('input', function() {
            updatePreviewTotals();
        });

        $('#plazo').on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tasaInteres = selectedOption.getAttribute('data-interes');
            document.getElementById('tasa_interes').value = tasaInteres + '%';
            updatePreviewTotals();
        });

        document.getElementById('form').addEventListener('submit', function() {
            var serializedArray = JSON.stringify(cart);
            document.getElementById('data_array').value = serializedArray;
        });

        document.getElementById("btnagregar").addEventListener("click", function() {
            var oldCart = JSON.parse(JSON.stringify(cart)); // Copia del estado anterior del carrito

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

                if (!availableStock[selectedProductCode]) {
                    availableStock[selectedProductCode] = stock;
                }

                var totalQuantityInCart = cart.filter(item => item.product === selectedProductName)
                    .reduce((total, item) => total + item.quantity, 0);

                if (quantity > 0 && (totalQuantityInCart + quantity) <= availableStock[selectedProductCode]) {
                    var existingItem = cart.find(item => item.product === selectedProductName);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        cart.push({
                            code: selectedProductCode,
                            product: selectedProductName,
                            price: parseFloat(selectedProductPrice),
                            quantity: quantity,
                        });
                    }
                    updateCartTable();
                    updatetotal(); // Recalcular totales del carrito

                    var totalVal = getCartTotal();
                    var plazo = parseInt(document.getElementById('plazo').value) || 0;

                    if (totalVal < 100) {
                        Swal.fire('La venta debe ser mínimo de $100', '', 'error');
                        cart = oldCart;
                        updateCartTable();
                        updatetotal();
                        return;
                    }

                    if (totalVal <= 200 && plazo > 6) {
                        Swal.fire('No se permiten plazos tan largos con ventas menores o iguales a $200', '', 'error');
                        cart = oldCart;
                        updateCartTable();
                        updatetotal();
                        return;
                    }

                } else if (quantity > (availableStock[selectedProductCode] - totalQuantityInCart)) {
                    alert("No hay suficiente stock. Cantidad disponible: " + (availableStock[selectedProductCode] - totalQuantityInCart));
                } else {
                    alert("Por favor, ingrese una cantidad válida.");
                }
            } else {
                alert("Seleccione un producto.");
            }
        });

        // ** Eliminado: Evento del botón "Generar Contrato" **
    });

    function updateCartTable() {
        var tableBody = document.querySelector("#cartTable tbody");
        tableBody.innerHTML = "";

        var totalVal = getCartTotal();
        var plazo = parseInt(document.getElementById('plazo').value) || 0;
        var interesStr = document.getElementById('tasa_interes').value || "";
        var interes = parseFloat(interesStr.replace('%','')) || 0;
        var interesDecimal = interes / 100;

        var montoTotalInteres = 0.00;
        if (totalVal > 0 && interesDecimal >= 0) {
            montoTotalInteres = totalVal + (totalVal * interesDecimal);
        }

        var cuota = (plazo > 0 && montoTotalInteres > 0) ? (montoTotalInteres / plazo) : 0;

        cart.forEach(function(item, index) {
            var row = tableBody.insertRow();
            var productCell = row.insertCell(0);
            var priceCell = row.insertCell(1);
            var quantityCell = row.insertCell(2);
            var costoSinIntCell = row.insertCell(3);
            var interesCell = row.insertCell(4);
            var plazoCell = row.insertCell(5);
            var costoConIntCell = row.insertCell(6);
            var cuotaMesCell = row.insertCell(7);
            var actionCell = row.insertCell(8);

            var costoSinInt = item.price * item.quantity;

            productCell.innerHTML = item.product;
            priceCell.innerHTML = item.price.toFixed(2);
            quantityCell.innerHTML = item.quantity;
            costoSinIntCell.innerHTML = costoSinInt.toFixed(2);
            interesCell.innerHTML = interes.toFixed(2) + "%";
            plazoCell.innerHTML = (plazo > 0 ? plazo + " meses" : "-");
            costoConIntCell.innerHTML = (montoTotalInteres > 0 ? montoTotalInteres.toFixed(2) : "0.00");
            cuotaMesCell.innerHTML = (cuota > 0 ? cuota.toFixed(2) : "0.00");

            actionCell.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeItem(this)"><i class="fa-solid fa-trash"></i></button>';
        });

        if (cart.length > 0) {
            document.getElementById("cartContainer").style.display = "block";
        } else {
            document.getElementById("cartContainer").style.display = "none";
        }
    }

    function removeItem(button) {
        var row = button.parentNode.parentNode;
        var index = row.rowIndex - 1;
        cart.splice(index, 1);
        updateCartTable();
        updatetotal();
    }

    function getCartTotal() {
        var total = 0;
        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            total += item.price * item.quantity;
        }
        return total;
    }

    function getPreviewTotal() {
        var cartTotal = getCartTotal();
        var selectedOption = document.getElementById("productSelect").selectedOptions[0];
        if (!selectedOption) return cartTotal;

        var quantity = parseInt(document.getElementById("txtcantidad").value) || 0;
        if (selectedOption.value === "" || quantity <= 0) {
            return cartTotal;
        }

        var selectedProductPrice = parseFloat(selectedOption.getAttribute("data-price")) || 0;
        var previewTotal = cartTotal + (selectedProductPrice * quantity);
        return previewTotal;
    }

    function updatePreviewTotals() {
        var previewTotal = getPreviewTotal();
        document.getElementById("total").value = previewTotal.toFixed(2);
        updateInterestTotal(previewTotal);
    }

    function updatetotal() {
        var cartTotal = getCartTotal();
        document.getElementById("total").value = cartTotal.toFixed(2);
        updateInterestTotal(cartTotal);
        updateCartTable(); // actualiza la tabla para reflejar cambios
    }

    function updateInterestTotal(baseTotal) {
        const plazoSelect = document.getElementById('plazo');
        const tasaInteresInput = document.getElementById('tasa_interes');
        const montoTotalInput = document.getElementById('monto_total_interes');

        if (!tasaInteresInput.value || tasaInteresInput.value === "") {
            montoTotalInput.value = "0.00";
            updateInstallmentsTable(0,0);
            return;
        }

        const tasaInteres = parseFloat(tasaInteresInput.value.replace('%','')) || 0;
        const interes = tasaInteres / 100;
        let montoTotal = 0.00;

        if (baseTotal > 0 && interes >= 0) {
            montoTotal = baseTotal + (baseTotal * interes);
            montoTotalInput.value = montoTotal.toFixed(2);
        } else {
            montoTotalInput.value = "0.00";
        }

        const plazo = parseInt(plazoSelect.value) || 0;
        updateInstallmentsTable(plazo, montoTotal);
    }

    function updateInstallmentsTable(plazo, montoTotal) {
        const installmentsContainer = document.getElementById('installmentsContainer');
        const installmentsTableBody = document.querySelector('#installmentsTable tbody');
        installmentsTableBody.innerHTML = "";

        if (plazo > 0 && montoTotal > 0) {
            installmentsContainer.style.display = "block";
            const cuota = montoTotal / plazo;

            for (let i = 1; i <= plazo; i++) {
                const row = installmentsTableBody.insertRow();
                const cuotaCell = row.insertCell(0);
                const montoCell = row.insertCell(1);

                cuotaCell.textContent = i;
                montoCell.textContent = cuota.toFixed(2);
            }
        } else {
            installmentsContainer.style.display = "none";
        }
    }
    </script>
</body>
</html>
