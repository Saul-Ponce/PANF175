<?php
require "./code128.php";
include '..\..\models\conexion.php';

class PDF extends FPDF
{
    // Encabezado de la página
    function Header()
    {
        // Agregar logo en la parte superior derecha
        $this->Image('./img/logo.png', 170, 2, 30); // Ruta, posición X, Y, ancho

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'COMPROBANTE DE COMPRA AL CREDITO', 0, 1, 'C');
        $this->Ln(2);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}
$id = $_POST['id'];
$nombre;
$cantidad;
$fecha;
$direccion;
$telefono;
$dui;
$nrc = 'N/A';
$ncliente;
$contador;
$plazo;
$precio;
$representante;
$duir;
$c = 0;
$con = connection();
$sql = "SELECT
 p.nombre AS producto, 
 d.cantidad,
 d.precio_unitario,
 c.plazo_cobro AS plazo,
 i.tasa_interes AS interes,
 c.monto AS total_con_interes,
 v.total_venta AS total,
 v.fecha,
 cn.nombre AS cnombre,
 cn.direccion,
 cn.telefono,
 cn.dui
FROM
 detalleventa AS d
INNER JOIN
 ventas AS v ON v.id = d.venta_id
 INNER JOIN
 clientesnaturales AS cn ON v.cliente_natural_id=cn.id
INNER JOIN
 productos AS p ON d.producto_id = p.id
LEFT JOIN
 cuentasporcobrar AS c ON c.venta_id = v.id
LEFT JOIN
 intereses AS i ON i.id = c.interes_id
WHERE
 d.venta_id = '$id'";
$datos = mysqli_query($con, $sql);
foreach ($datos as $row) {
    $nombre = $row['producto'];
    $cantidad = $row['cantidad'];
    $fecha = $row['fecha'];
    $direccion = $row['direccion'];
    $telefono = $row['telefono'];
    $dui = $row['dui'];
    $ncliente = $row['cnombre'];
    $plazo = $row['plazo'];
    $precio = $row['precio_unitario'];
    $rdui=$dui;
}
$con2 = connection();
$sql2 = "SELECT COUNT(d.id) AS contador FROM detalleventa AS d INNER JOIN ventas AS v ON v.id = d.venta_id INNER JOIN clientesnaturales AS cn ON v.cliente_natural_id=cn.id INNER JOIN productos AS p ON d.producto_id = p.id LEFT JOIN cuentasporcobrar AS c ON c.venta_id = v.id LEFT JOIN intereses AS i ON i.id = c.interes_id WHERE d.venta_id = '$id' GROUP BY d.id";
$contador = mysqli_query($con2, $sql2);
foreach ($contador as $row) {
    $c = $row['contador'];
}
if ($c < 1) {
    $con = connection();
    $sql = "SELECT p.nombre AS producto, d.cantidad, d.precio_unitario, c.plazo_cobro AS plazo, i.tasa_interes AS interes, c.monto AS total_con_interes, v.total_venta AS total, v.fecha, cj.nombre AS cnombre, cj.direccion, cj.telefono, cj.nit, cj.nrc, rl.nombre as rnombre, rl.dui as rdui FROM detalleventa AS d INNER JOIN ventas AS v ON v.id = d.venta_id INNER JOIN clientesjuridicos AS cj ON v.cliente_juridico_id=cj.id INNER JOIN representante_legal AS rl ON cj.representante_legal=rl.id JOIN productos AS p ON d.producto_id = p.id LEFT JOIN cuentasporcobrar AS c ON c.venta_id = v.id LEFT JOIN intereses AS i ON i.id = c.interes_id WHERE d.venta_id = '$id'";
    $datos = mysqli_query($con, $sql);
    foreach ($datos as $row) {
        $nombre = $row['producto'];
        $cantidad = $row['cantidad'];
        $fecha = $row['fecha'];
        $direccion = $row['direccion'];
        $telefono = $row['telefono'];
        $dui = $row['nit'];
        $nrc = $row['nrc'];
        $ncliente = $row['cnombre'];
        $plazo = $row['plazo'];
        $precio = $row['precio_unitario'];
        $representante = $row['rnombre'];
        $rdui = $row['rdui'];
    }
}
$interes;
switch ($plazo) {
    case 2:
        $interes = 0.70;
        break;
    case 3:
        $interes = 0.75;
        break;
    case 4:
        $interes = 0.80;
        break;
    case 5:
        $interes = 0.85;
        break;
    case 6:
        $interes = 0.90;
        break;
    case 7:
        $interes = 0.92;
        break;
    case 8:
        $interes = 0.94;
        break;
    case 9:
        $interes = 0.96;
        break;
    case 10:
        $interes = 0.98;
        break;
    case 11:
        $interes = 1.00;
        break;
    case 12:
        $interes = 1.05;
        break;
    case 13:
        $interes = 1.10;
        break;
    case 14:
        $interes = 1.15;
        break;
    case 15:
        $interes = 1.20;
        break;
    case 16:
        $interes = 1.25;
        break;
    case 17:
        $interes = 1.30;
        break;
    case 18:
        $interes = 1.35;
        break;
    case 19:
        $interes = 1.40;
        break;
    case 20:
        $interes = 1.45;
        break;
    case 21:
        $interes = 1.50;
        break;
    case 22:
        $interes = 1.55;
        break;
    case 23:
        $interes = 1.60;
        break;
    case 24:
        $interes = 1.65;
        break;
}
date_default_timezone_set('America/Mexico_City');
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Bloque superior izquierdo
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(120, 5, 'NOMBRE O RAZON SOCIAL: PUNTO DIGITAL', 1, 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 5, $id, 1, 1);

$pdf->Cell(120, 5, 'GIRO / ACTIVIDAD: Venta de Tecnologia', 1, 0);
$pdf->Cell(35, 5, 'N.I.T. 0614-210597-167-3', 1, 0);
$pdf->Cell(35, 5, 'N.R.C. 556874-9', 1, 1);

$pdf->Cell(120, 5, 'DIRECCION: 2 CL. OTE. Y 4 AV. SUR, Cojutepeque, Cuscatlan', 1, 0);
$pdf->Cell(70, 5, 'FECHA: ' . $fecha, 1, 1);

$pdf->Ln(5);

// Bloque cliente
$pdf->Cell(190, 5, 'NOMBRE O RAZON SOCIAL DEL CLIENTE: ' . $ncliente, 1, 1);
$pdf->Cell(120, 5, 'DIRECCION: ' . $direccion, 1, 0);
$pdf->Cell(70, 5, 'N.R.C.: ' . $nrc, 1, 1);
$pdf->Cell(120, 5, 'D.U.I / N.I.T.: ' . $dui, 1, 0);
$pdf->Cell(70, 5, 'TELEFONO: ' . $telefono, 1, 1);

$pdf->Ln(5);

// Condiciones de la operación
$pdf->Cell(190, 5, 'CONDICIONES DE LA OPERACION: CREDITO', 1, 1);

$pdf->Ln(5);

// Tabla de productos o servicios
$pdf->Cell(20, 5, 'CANTIDAD', 1, 0, 'C');
$pdf->Cell(70, 5, 'NOMBRE', 1, 0, 'C');
$pdf->Cell(30, 5, 'PRECIO UNITARIO', 1, 0, 'C');
$pdf->Cell(25, 5, 'V NO SUJETAS', 1, 0, 'C');
$pdf->Cell(25, 5, 'V EXENTAS', 1, 0, 'C');
$pdf->Cell(20, 5, 'V GRAVADAS', 1, 1, 'C');
$total = 0;
foreach ($datos as $row) {
    $nombre = $row["producto"];
    $cantidad = $row["cantidad"];
    $precio = $row["precio_unitario"];
    $subtotal = $cantidad * $precio;
    $total = $total + $subtotal;


    $pdf->Cell(20, 5, '' . $cantidad, 1, 0, 'C');
    $pdf->Cell(70, 5, '' . $nombre, 1, 0, 'C');
    $pdf->Cell(30, 5, '$ ' . $precio, 1, 0, 'C');
    $pdf->Cell(25, 5, '$ 0.00', 1, 0, 'C');
    $pdf->Cell(25, 5, '$ 0.00', 1, 0, 'C');
    $pdf->Cell(20, 5, '$ ' . $subtotal, 1, 1, 'C');
}
$totalint = ($total*$interes)+$total;
$pdf->Ln(5);

// Totales
$pdf->Cell(120, 5, 'PLAZOS A PAGAR: ' . $plazo . ' meses', 1, 0);
$pdf->Cell(35, 5, 'SUB TOTAL', 1, 0);
$pdf->Cell(35, 5, '$ '.$total, 1, 1);

$pdf->Cell(120, 5, '', 0, 0);
$pdf->Cell(35, 5, 'INTERESES: ', 1, 0);
$pdf->Cell(35, 5, ''.$interes.'%', 1, 1);

$pdf->Cell(120, 5, '', 0, 0);
$pdf->Cell(35, 5, 'TOTAL A PAGAR', 1, 0);
$pdf->Cell(35, 5, '$ '.$totalint, 1, 1);

$pdf->Ln(5);
$condnombre=' ';
$condnombrec=' ';
$duic=' ';
$duie=' '; 
$nimprenta=' ';
$nrazon=' ';
$nnit=' ';
$ndomicilio=' ';
$nnrec=' ';
if($totalint>11428.58)
{
    $condnombre = "Punto Digital";
    $condnombrec = $ncliente;
    $duic = $rdui;
    $duie = '05556018-6';
    $nimprenta='Tipcom';
    $nrazon='Imprenta de papeleria IVA';
    $nnit='0415-221222-174-8';
    $ndomicilio='1 Calle Oriente y 7 Avenida Sur #18 Santa Ana, El Salvador';
    $nnrec='782161-5';
}
// Información adicional
$pdf->Cell(190, 5, 'LLENAR SI LA OPERACION ES SUPERIOR A $11,428.58', 1, 1, 'C');
$pdf->Cell(95, 5, 'ENTREGADO POR:', 1, 0);
$pdf->Cell(95, 5, 'RECIBIDO POR:', 1, 1);

$pdf->Cell(95, 5, 'NOMBRE: '.$condnombre, 1, 0);
$pdf->Cell(95, 5, 'NOMBRE: '.$condnombrec, 1, 1);
$pdf->Cell(95, 5, 'D.U.I.: '.$duie, 1, 0);
$pdf->Cell(95, 5, 'D.U.I.: '.$duic, 1, 1);
$pdf->Cell(95, 5, 'FIRMA:', 1, 0);
$pdf->Cell(95, 5, 'FIRMA:', 1, 1);

$pdf->Ln(5);

// Información de la imprenta
$pdf->Cell(190, 5, 'DE LA IMPRENTA: ', 1, 1, 'C');
$pdf->Cell(95, 5, 'NOMBRE O RAZON SOCIAL: '.$nimprenta, 1, 0);
$pdf->Cell(95, 5, 'NIT: '.$nnit, 1, 1);
$pdf->Cell(95, 5, 'DOMICILIO: '.$ndomicilio, 1, 0);
$pdf->Cell(95, 5, 'NRC: '.$nnrec, 1, 1);

// Generar y forzar la descarga en una ventana nueva
$pdf->Output('I', 'factura.pdf');
?>
<script>
    $interes;
    f
</script>