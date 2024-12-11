<?php
require "./code128.php";
include '..\..\models\conexion.php';

class PDF extends FPDF {
    function Header() {
        $this->Image('./img/logo.png', 170, 2, 30); // Ruta, posición X, Y, ancho
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'FACTURA CONSUMIDOR FINAL', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

$id=$_POST['id'];
$nombre;
$cantidad;
$nfilas;
$ncliente;
$dcliente;
$fecha;
$c;
$con = connection();

    $con = connection();
    $sql = "SELECT p.nombre as pnombre,d.cantidad,d.precio_unitario,cj.nombre as cnombre,cj.direccion,v.fecha FROM detalleventa AS d INNER JOIN ventas AS v ON  v.id = d.venta_id INNER JOIN productos AS p ON  d.producto_id = p.id INNER JOIN clientesnaturales AS	cj ON v.cliente_natural_id=cj.id WHERE d.venta_id='$id'";
    $datos = mysqli_query($con, $sql);
    foreach($datos as $row)
    {
        $nombre = $row['pnombre'];
        $cantidad = $row['cantidad'];
        $ncliente = $row['cnombre'];
        $dcliente = $row['direccion'];
        $fecha = $row['fecha'];
    }
    $con2 = connection();
    $sql2 = "SELECT COUNT(d.id) AS contador FROM detalleventa AS d INNER JOIN ventas AS v ON  v.id = d.venta_id INNER JOIN productos AS p ON  d.producto_id = p.id INNER JOIN clientesnaturales AS	cj ON v.cliente_natural_id=cj.id WHERE d.venta_id='$id'";
    $contador = mysqli_query($con2, $sql2);
    foreach($contador as $row)
    {
        $c = $row['contador'];
    }
    if($c<1)
    {
        $con = connection();
        $sql = "SELECT p.nombre as pnombre,d.cantidad,d.precio_unitario,cj.nombre as cnombre,cj.direccion,v.fecha FROM detalleventa AS d INNER JOIN ventas AS v ON  v.id = d.venta_id INNER JOIN productos AS p ON  d.producto_id = p.id INNER JOIN clientesjuridicos AS	cj ON v.cliente_juridico_id=cj.id WHERE d.venta_id='$id'";
        $datos = mysqli_query($con, $sql);
        foreach($datos as $row)
    {
        $nombre = $row['pnombre'];
        $cantidad = $row['cantidad'];
        $ncliente = $row['cnombre'];
        $dcliente = $row['direccion'];
        $fecha = $row['fecha'];
    }
    }


//$filas = mysqli_query($con2, $sql2);
//foreach ($filas as $row) {
//    $nfilas=$row["fila"];
//}


$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);

// Encabezado de la factura
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 5, 'NOMBRE DEL CONTRIBUYENTE EMISOR: Punto Digital', 1, 0);
$pdf->Cell(60, 5, 'FACTURA NUMERO '.$id, 1, 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(130, 5, 'GIRO: Venta de Tecnologia', 1, 0);
$pdf->Cell(35, 5, 'N.I.T.: 0614-210597-167-3', 1, 0);
$pdf->Cell(25, 5, 'N.R.C. : 556874-9', 1, 1);

$pdf->Cell(130, 5, 'DIRECCION: 2 CL. OTE. Y 4 AV. SUR, Cojutepeque, Cuscatlan', 1, 0);
$pdf->Cell(60, 5, 'FECHA:'. $fecha, 1, 1);

$pdf->Ln(5);

// Información del cliente
$pdf->Cell(190, 5, 'NOMBRE DEL CLIENTE: '.$ncliente, 1, 1);
$pdf->Cell(190, 5, 'DIRECCION: '.$dcliente, 1, 1);

$pdf->Ln(5);

// Exportación a cuenta de
$pdf->Cell(190, 5, 'CONDICIONES DE LA OPERACION: CONTADO', 1, 1);

// Encabezado de la tabla
$pdf->Cell(20, 5, 'CANTIDAD', 1, 0, 'C');
$pdf->Cell(80, 5, 'NOMBRE', 1, 0, 'C');
$pdf->Cell(40, 5, 'PRECIO UNITARIO', 1, 0, 'C');
$pdf->Cell(50, 5, 'VENTAS AFECTAS', 1, 1, 'C');
$total=0;
// Filas de la tabla
    foreach ($datos as $row) {
        $nombre=$row["pnombre"];
        $cantidad=$row["cantidad"];
        $precio=$row["precio_unitario"];
        $subtotal=$cantidad*$precio;
        $total=$total+$subtotal;
    
        $pdf->Cell(20, 10, ''.$cantidad, 1, 0, 'C');
        $pdf->Cell(80, 10, ''.$nombre, 1, 0, 'C');
        $pdf->Cell(40, 10, '$ '.$precio, 1, 0, 'C');
        $pdf->Cell(50, 10, '$ '.$subtotal, 1, 1, 'C');
    }

// Total
$pdf->Cell(140, 5, '', 1, 0);
$pdf->Cell(50, 5, 'TOTAL $ '.$total, 1, 1, 'C');

// Salida del PDF
$pdf->Output('D','factura'.$id.'.pdf');
?>
