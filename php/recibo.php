<?php
session_start();
require __DIR__ . '/../fpdf/fpdf.php'; // Ruta corregida
include __DIR__ . '/conexion.php';

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['asiento_id']) || !isset($_SESSION['venta_id'])) {
    echo "No hay datos para generar el recibo.";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$asiento_id = $_SESSION['asiento_id'];
$venta_id = $_SESSION['venta_id'];

// Obtener datos del usuario
$usuario_sql = "SELECT nombre, correo FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($usuario_sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nombre, $correo);
$stmt->fetch();
$stmt->close();

// Obtener datos del asiento
$asiento_sql = "SELECT numero_asiento FROM asientos WHERE id = ?";
$stmt = $conexion->prepare($asiento_sql);
$stmt->bind_param("i", $asiento_id);
$stmt->execute();
$stmt->bind_result($numero_asiento);
$stmt->fetch();
$stmt->close();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Recibo de Compra',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(50,10,'Cliente: '.$nombre,0,1);
$pdf->Cell(50,10,'Correo: '.$correo,0,1);
$pdf->Cell(50,10,'Asiento comprado: '.$numero_asiento,0,1);
$pdf->Cell(50,10,'Venta ID: '.$venta_id,0,1);
$pdf->Cell(50,10,'Fecha: '.date('d/m/Y H:i'),0,1);

$pdf->Output('I', 'recibo.pdf');
?>