<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || 
   ($_SESSION['rol'] != "Administrador" && $_SESSION['rol'] != "Vendedor")) {
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
include "../models/VentaCreditoModel.php";
include "../models/UsuarioModel.php";
include_once "../models/InteresesModel.php";
$con = connection();

// Obtener productos con su stock y precio de venta
$sqlProductos = "SELECT p.id, p.nombre, p.codigo, i.stok, i.precio_venta, i.idInventario 
                FROM productos AS p
                INNER JOIN inventario AS i ON i.producto_id = p.id";
$queryProductos = mysqli_query($con, $sqlProductos);

// Obtener clientes jurídicos
$sqlClientesJuridicos = "SELECT * FROM clientesjuridicos";
$cjquery = mysqli_query($con, $sqlClientesJuridicos);

// Obtener clientes naturales
$sqlClientesNaturales = "SELECT * FROM clientesnaturales";
$cnquery = mysqli_query($con, $sqlClientesNaturales);

// Obtener intereses
$intereses = InteresesModel::listar();

// Obtener ID del usuario actual
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
    <title>Registrar Venta al Crédito</title>
    <?php include '../layouts/headerStyles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                                        class="form-selectgroup-input" onclick="mostrarSelectCliente('juridico')">
                                    <span class="form-selectgroup-label">Cliente Jurídico</span>
                                </label>
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="cliente" value="cliente-natural"
                                        class="form-selectgroup-input" checked onclick="mostrarSelectCliente('natural')">
                                    <span class="form-selectgroup-label">Cliente Natural</span>
                                </label>
                            </div>

                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" name="tipo_venta" value="credito">
                            <input type="hidden" id="usuario_id" name="usuario_id"
                                value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
                            <input type="hidden" id="data_array" name="data_array">
                            <input type="hidden" name="tipo_cliente" id="tipo_cliente" value="natural">
                            
                            <div id="cliente" class="col-lg-5">
                                <label>Cliente</label>
                                <input type="hidden" id="tipo-cliente" name="tipo-cliente" value="cliente-natural">
                                <select class="form-select" id="clienteSelect" name="clienteSelect"
                                    placeholder="Seleccione un cliente..." required>
                                    <option value="">Seleccione un cliente...</option>
                                    <?php foreach ($cnquery as $row): ?>
                                    <option value="<?= htmlspecialchars($row['id']) ?>" data-id="<?= htmlspecialchars($row['id']) ?>">
                                        <?= htmlspecialchars($row['id']) ?> <?= htmlspecialchars($row['nombre']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label>Fecha</label>
                                <?php date_default_timezone_set("America/El_Salvador");
                                $fecha = date("Y-m-d"); ?>
                                <input type="date" class="form-control" value="<?= htmlspecialchars($fecha) ?>" id="fecha_venta"
                                    name="fecha_venta" readonly>
                            </div>

                            <div class="col-lg-4">
                                <label>Contrato de Venta al Crédito (Aval)</label>
                                <input type="file" class="form-control" id="aval" name="aval" accept=".pdf" required>
                            </div>
                        </div>

                        <div class="row mt-4 align-items-end">
                            <div class="col-lg-4">
                                <label>Producto</label>
                                <select class="form-select" id="productSelect" name="productSelect" required>
                                    <option value="">Seleccione</option>
                                    <?php foreach ($queryProductos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['id']) ?>" data-code="<?= htmlspecialchars($row['codigo']) ?>"
                                        data-stock="<?= htmlspecialchars($row['stok']) ?>" data-price="<?= htmlspecialchars($row['precio_venta']) ?>"
                                        data-inv="<?= htmlspecialchars($row['idInventario'] ?? '') ?>" data-product="<?= htmlspecialchars($row['id']) ?>">
                                        <?= htmlspecialchars($row['codigo']) ?> | <?= htmlspecialchars($row['nombre']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <label>Precio ($)</label>
                                <input readonly class="form-control" id="txtprecio" name="txtprecio"
                                    type="number" step="0.01" />
                            </div>

                            <div class="col-lg-2">
                                <label>Stock</label>
                                <input readonly class="form-control" id="txtstock" name="txtstock" type="number" />
                            </div>

                            <div class="col-lg-2">
                                <label>Cantidad</label>
                                <input class="form-control" id="txtcantidad" name="txtcantidad" type="number" min="1" required/>
                            </div>
                            <!-- Removed the 'Agregar' button next to 'Cantidad' -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label for="plazo">Plazo de Pago (Meses)</label>
                                <select id="plazo" name="plazo" class="form-select" required>
                                    <option value="" disabled selected>Seleccione el plazo</option>
                                    <?php
                                    // Obtener intereses
                                    if ($intereses && mysqli_num_rows($intereses) > 0) {
                                        while ($row = mysqli_fetch_assoc($intereses)) {
                                            echo "<option value='" . htmlspecialchars($row['plazo_meses']) . "' data-interes='" . htmlspecialchars($row['tasa_interes']) . "'>
                                                " . htmlspecialchars($row['plazo_meses']) . " meses
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
                                <label>PRECIO TOTAL ($)</label>
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

                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <a class="btn btn-danger" id="btncancelar">Cancelar</a>
                                <button class="btn btn-primary" type="submit">Guardar Venta al Crédito</button>
                            </div>
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
        </div>
        <?php include '../layouts/Footer.php'; ?>
    </div>

    <!-- Scripts de Bootstrap 5 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>
    <script src="../public/assets/js/toast.js"></script>
    <!-- END content-page -->

    <script>
    var availableStock = {};
    var cart = [];

    function mostrarSelectCliente(tipo) {
        if (tipo == 'juridico') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-juridico'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...' required> <option value=''>Seleccione un cliente...</option><?php foreach ($cjquery as $row): ?><option value='<?= htmlspecialchars($row['id']) ?>' data-id='<?= htmlspecialchars($row['id']) ?>'><?= htmlspecialchars($row['id']) ?> <?= htmlspecialchars($row['nombre']) ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {create: false, sortField: {field: "text", direction: "asc"}}));
            document.getElementById('tipo_cliente').value = "juridico";
        } else if (tipo == 'natural') {
            document.getElementById('cliente').innerHTML =
                "<label>Cliente</label><input type='hidden' id='tipo-cliente' name='tipo-cliente' value='cliente-natural'><select class='form-select' id='clienteSelect' name='clienteSelect' placeholder='Seleccione un cliente...' required> <option value=''>Seleccione un cliente...</option><?php foreach ($cnquery as $row): ?><option value='<?= htmlspecialchars($row['id']) ?>' data-id='<?= htmlspecialchars($row['id']) ?>'><?= htmlspecialchars($row['id']) ?> <?= htmlspecialchars($row['nombre']) ?></option><?php endforeach; ?></select>";
            window.TomSelect && (new TomSelect("#clienteSelect", {create: false, sortField: {field: "text", direction: "asc"}}));
            document.getElementById('tipo_cliente').value = "natural";
        }
    }

    $(document).ready(function() {
        // Inicializar TomSelect si está disponible
        window.TomSelect && (new TomSelect("#clienteSelect", {create: false, sortField: {field:"text", direction:"asc"}}));
        window.TomSelect && (new TomSelect("#productSelect", {create: false, sortField: {field:"text", direction:"asc"}}));

        // Mostrar mensajes de éxito o error
        <?php if (isset($_SESSION['success_messageC'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?php echo htmlspecialchars($_SESSION['success_messageC']); ?>',
            timer: 3000,
            timerProgressBar: true,
            willClose: () => {
                // Reiniciar el formulario al cerrar la alerta
                document.getElementById('form').reset();
                cart = [];
                availableStock = {};
                updateCartTable();
                updatetotal();
                document.getElementById('installmentsContainer').style.display = "none";
                document.querySelector('#installmentsTable tbody').innerHTML = "";
            }
        });
        <?php unset($_SESSION['success_messageC']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo htmlspecialchars($_SESSION['error_message']); ?>'
            });
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        // Evento al cambiar el producto
        $('#productSelect').on('change', function() {
            var selectedPrice = parseFloat($('option:selected', this).data('price')) || 0;
            $('#txtprecio').val(selectedPrice.toFixed(2));

            var selectedStock = parseInt($('option:selected', this).data('stock')) || 0;
            $('#txtstock').val(selectedStock);

            updatePreviewTotals();
        });

        // Evento al cambiar la cantidad
        $('#txtcantidad').on('input', function() {
            updatePreviewTotals();
        });

        // Evento al cambiar el plazo
        $('#plazo').on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tasaInteres = selectedOption.getAttribute('data-interes') || 0;
            document.getElementById('tasa_interes').value = tasaInteres + '%';
            updatePreviewTotals();
        });

        // Evento al enviar el formulario
        document.getElementById('form').addEventListener('submit', function(event) {
            if (cart.length === 0) {
                event.preventDefault();
                Swal.fire('El carrito está vacío. Agrega al menos un producto antes de guardar.', '', 'warning');
                return;
            }
            var serializedArray = JSON.stringify(cart);
            document.getElementById('data_array').value = serializedArray;
        });

        // Evento al hacer clic en "Agregar" (btnagregar)
        document.getElementById("btnagregar").addEventListener("click", function() {
            // Agregar el producto seleccionado al carrito
            var selectElement = document.getElementById("productSelect");
            var selectedIndex = selectElement.selectedIndex;
            var quantityInput = document.getElementById("txtcantidad");

            if (selectedIndex !== -1 && selectElement.options[selectedIndex].value !== "") {
                var selectedOption = selectElement.options[selectedIndex];
                var selectedProductId = selectedOption.value;
                var selectedProductCode = selectedOption.getAttribute("data-code");
                var selectedProductPrice = parseFloat(selectedOption.getAttribute("data-price")) || 0;
                var selectedProductName = selectedOption.textContent.trim();
                var cantidad = parseInt(quantityInput.value) || 0;
                var stock = parseInt(selectedOption.getAttribute("data-stock")) || 0;
                var inv_id = parseInt(selectedOption.getAttribute("data-inv")) || 0;
                var product = parseInt(selectedOption.getAttribute("data-product")) || 0;

                if (!availableStock[selectedProductId]) {
                    availableStock[selectedProductId] = stock;
                }

                var totalQuantityInCart = cart.filter(item => item.id === selectedProductId)
                    .reduce((total, item) => total + item.cantidad, 0);

                if (cantidad > 0 && (totalQuantityInCart + cantidad) <= availableStock[selectedProductId]) {
                    var existingItem = cart.find(item => item.id === selectedProductId);
                    if (existingItem) {
                        existingItem.cantidad += cantidad;
                    } else {
                        cart.push({
                            id: selectedProductId,
                            code: selectedProductCode,
                            product: selectedProductName,
                            price: selectedProductPrice,
                            cantidad: cantidad,
                            inv: inv_id,
                        });
                    }
                    updateCartTable();
                    updatetotal(); // Recalcular totales del carrito

                    var totalVal = getCartTotal();
                    var plazo = parseInt(document.getElementById('plazo').value) || 0;

                    // Validación de selección de plazo
                    if (plazo === 0) {
                        Swal.fire('Seleccione un plazo de pago para calcular intereses.', '', 'warning');
                        cart.pop(); // Remover el último agregado
                        updateCartTable();
                        updatetotal();
                        return;
                    }

                    // Actualizar el stock mostrado en el formulario
                    var remainingStock = availableStock[selectedProductId] - cantidad;
                    availableStock[selectedProductId] = remainingStock;
                    $('#txtstock').val(remainingStock);

                    // Limpiar la cantidad
                    // $('#txtcantidad').val(''); // Removed to prevent clearing the quantity field
                } else if (cantidad > (availableStock[selectedProductId] - totalQuantityInCart)) {
                    alert("No hay suficiente stock. Cantidad disponible: " + (availableStock[selectedProductId] - totalQuantityInCart));
                } else {
                    alert("Por favor, ingrese una cantidad válida.");
                }
            } else {
                alert("Seleccione un producto.");
            }
        });

        // Botón Cancelar
        document.getElementById("btncancelar").addEventListener("click", function() {
            // Limpiar el carrito
            cart = [];
            availableStock = {};
            updateCartTable();
            updatetotal();
            // Limpiar otros campos
            document.getElementById("form").reset();
            // Ocultar secciones adicionales
            document.getElementById('installmentsContainer').style.display = "none";
            document.querySelector('#installmentsTable tbody').innerHTML = "";
        });
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
        if (plazo > 0 && interesDecimal > 0) {
            montoTotalInteres = totalVal + (totalVal * interesDecimal);
        }

        var cuota = (plazo > 0 && montoTotalInteres > 0) ? (montoTotalInteres / plazo) : 0;

        cart.forEach(function(item, index) {
            var row = tableBody.insertRow();
            var productCell = row.insertCell(0);
            var priceCell = row.insertCell(1);
            var cantidadCell = row.insertCell(2);
            var costoSinIntCell = row.insertCell(3);
            var interesCell = row.insertCell(4);
            var plazoCell = row.insertCell(5);
            var costoConIntCell = row.insertCell(6);
            var cuotaMesCell = row.insertCell(7);
            var actionCell = row.insertCell(8);

            var costoSinInt = item.price * item.cantidad;

            productCell.innerHTML = item.product;
            priceCell.innerHTML = item.price.toFixed(2);
            cantidadCell.innerHTML = item.cantidad;
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
        var removedItem = cart.splice(index, 1)[0];
        updateCartTable();
        updatetotal();

        // Actualizar el stock mostrado en el formulario
        if (removedItem) {
            var productId = removedItem.id;
            var remainingStock = availableStock[productId] + removedItem.cantidad;
            availableStock[productId] = remainingStock;
            var selectedProduct = document.querySelector("#productSelect option[value='" + productId + "']");
            if (selectedProduct) {
                selectedProduct.setAttribute("data-stock", remainingStock);
            }

            // Si el producto actualmente seleccionado, actualizar el stock mostrado
            var currentSelected = document.getElementById("productSelect").value;
            if (currentSelected === productId) {
                $('#txtstock').val(remainingStock);
            }
        }
    }

    function getCartTotal() {
        var total = 0;
        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            total += item.price * item.cantidad;
        }
        return total;
    }

    function updatetotal() {
        var cartTotal = getCartTotal();
        document.getElementById("total").value = cartTotal.toFixed(2);
        updateInterestTotal(cartTotal);
        updateCartTable(); // actualiza la tabla para reflejar cambios
    }

    function updateInterestTotal(baseTotal) {
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

        if (baseTotal > 0 && interes > 0) {
            montoTotal = baseTotal + (baseTotal * interes);
            montoTotalInput.value = montoTotal.toFixed(2);
        } else {
            montoTotalInput.value = "0.00";
        }

        const plazo = parseInt(document.getElementById('plazo').value) || 0;
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

    function updatePreviewTotals() {
        var totalVal = getCartTotal();
        var selectedOption = document.getElementById("productSelect").selectedOptions[0];
        var quantity = parseInt(document.getElementById("txtcantidad").value) || 0;
        var selectedPrice = parseFloat(document.getElementById("txtprecio").value) || 0;

        if (selectedOption && selectedOption.value !== "" && quantity > 0) {
            totalVal += selectedPrice * quantity;
        }

        document.getElementById("total").value = totalVal.toFixed(2);

        var tasaInteres = 0;
        var plazoSelect = document.getElementById('plazo');
        var selectedPlazo = plazoSelect.options[plazoSelect.selectedIndex];
        if (selectedPlazo && selectedPlazo.getAttribute('data-interes')) {
            tasaInteres = parseFloat(selectedPlazo.getAttribute('data-interes')) || 0;
            document.getElementById('tasa_interes').value = tasaInteres + '%';
        } else {
            document.getElementById('tasa_interes').value = '';
        }

        if (plazoSelect.value) {
            var montoTotalInteres = totalVal + (totalVal * (tasaInteres / 100));
            document.getElementById("monto_total_interes").value = montoTotalInteres.toFixed(2);
            updateInstallmentsTable(parseInt(plazoSelect.value), montoTotalInteres);
        } else {
            document.getElementById("monto_total_interes").value = "0.00";
            document.getElementById('installmentsContainer').style.display = "none";
            document.querySelector('#installmentsTable tbody').innerHTML = "";
        }
    }
    </script>
</body>
</html>
