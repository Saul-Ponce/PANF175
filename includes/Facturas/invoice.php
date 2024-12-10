<?php
require "./code128.php";

class PDF extends FPDF {
    // Encabezado de la página
    function Header() {
        // Agregar logo en la parte superior derecha
        $this->Image('./img/logo.png', 170, 2, 30); // Ruta, posición X, Y, ancho

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'COMPROBANTE DE CREDITO FISCAL', 0, 1, 'C');
        $this->Ln(2);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}
$num = 1;
$Nfact = "COMPROBANTE DE CREDITO FISCAL No. ". $num;
// Configura la zona horaria (puedes cambiarla según tu ubicación)
date_default_timezone_set('America/Mexico_City');

// Obtén la fecha y hora actual
$fechaHoraActual = date('Y-m-d H:i:s');
$cliente = 'Nombre del cliente';
$direccion = 'Direccion del cliente';
$nrc = 'NRC del cliente';
$NIT = 'NIT del cliente';
$email = 'Correo del cliente';
$operacion = 'Operacion';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Bloque superior izquierdo
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(120, 5, 'NOMBRE O RAZON SOCIAL: PUNTO DIGITAL', 1, 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 5, $Nfact, 1, 1);

$pdf->Cell(120, 5, 'GIRO / ACTIVIDAD: Venta de Tecnologia', 1, 0);
$pdf->Cell(35, 5, 'N.I.T.', 1, 0);
$pdf->Cell(35, 5, 'N.R.C.', 1, 1);

$pdf->Cell(120, 5, 'DIRECCION: 2 CL. OTE. Y 4 AV. SUR, Cojutepeque, Cuscatlan', 1, 0);
$pdf->Cell(70, 5, 'FECHA: '.$fechaHoraActual, 1, 1);

$pdf->Ln(5);

// Bloque cliente
$pdf->Cell(190, 5, 'NOMBRE O RAZON SOCIAL DEL CLIENTE:'.$cliente, 1, 1);
$pdf->Cell(120, 5, 'DIRECCION: '.$direccion, 1, 0);
$pdf->Cell(70, 5, 'N.R.C.: '.$nrc, 1, 1);
$pdf->Cell(120, 5, 'N.I.T.: '.$NIT, 1, 0);
$pdf->Cell(70, 5, 'EMAIL: '. $email, 1, 1);

$pdf->Ln(5);

// Condiciones de la operación
$pdf->Cell(190, 5, 'CONDICIONES DE LA OPERACION: '.$operacion, 1, 1);

$pdf->Ln(5);

// Tabla de productos o servicios
$pdf->Cell(20, 5, 'CANTIDAD', 1, 0, 'C');
$pdf->Cell(70, 5, 'DESCRIPCION', 1, 0, 'C');
$pdf->Cell(30, 5, 'PRECIO UNITARIO', 1, 0, 'C');
$pdf->Cell(25, 5, 'V NO SUJETAS', 1, 0, 'C');
$pdf->Cell(25, 5, 'V EXENTAS', 1, 0, 'C');
$pdf->Cell(20, 5, 'V GRAVADAS', 1, 1, 'C');

for ($i = 0; $i < 5; $i++) {
    $pdf->Cell(20, 5, '', 1, 0);
    $pdf->Cell(70, 5, '', 1, 0);
    $pdf->Cell(30, 5, '', 1, 0);
    $pdf->Cell(25, 5, '', 1, 0);
    $pdf->Cell(25, 5, '', 1, 0);
    $pdf->Cell(20, 5, '', 1, 1);
}

$pdf->Ln(5);

// Totales
$pdf->Cell(120, 5, 'SUMAS:', 1, 0);
$pdf->Cell(35, 5, 'SUB TOTAL', 1, 0);
$pdf->Cell(35, 5, 'US$', 1, 1);

$pdf->Cell(120, 5, '', 0, 0);
$pdf->Cell(35, 5, 'IVA', 1, 0);
$pdf->Cell(35, 5, 'US$', 1, 1);

$pdf->Cell(120, 5, '', 0, 0);
$pdf->Cell(35, 5, 'TOTAL A PAGAR', 1, 0);
$pdf->Cell(35, 5, 'US$', 1, 1);

$pdf->Ln(5);

// Información adicional
$pdf->Cell(190, 5, 'LLENAR SI LA OPERACION ES SUPERIOR A $11,428.58', 1, 1, 'C');
$pdf->Cell(95, 5, 'ENTREGADO POR:', 1, 0);
$pdf->Cell(95, 5, 'RECIBIDO POR:', 1, 1);

$pdf->Cell(95, 5, 'NOMBRE:', 1, 0);
$pdf->Cell(95, 5, 'NOMBRE:', 1, 1);
$pdf->Cell(95, 5, 'D.U.I.:', 1, 0);
$pdf->Cell(95, 5, 'D.U.I.:', 1, 1);
$pdf->Cell(95, 5, 'FIRMA:', 1, 0);
$pdf->Cell(95, 5, 'FIRMA:', 1, 1);

$pdf->Ln(5);

// Información de la imprenta
$pdf->Cell(190, 5, 'DE LA IMPRENTA:', 1, 1, 'C');
$pdf->Cell(95, 5, 'NOMBRE, DENOMINACION O RAZON SOCIAL:', 1, 0);
$pdf->Cell(95, 5, 'NIT:', 1, 1);
$pdf->Cell(95, 5, 'DOMICILIO:', 1, 0);
$pdf->Cell(95, 5, 'NRC:', 1, 1);

// Generar y forzar la descarga en una ventana nueva
$pdf->Output('I', 'factura.pdf');
?>
