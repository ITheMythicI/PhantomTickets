<?php
session_start();
require __DIR__ . '/../fpdf/fpdf.php'; 
include __DIR__ . '/conexion.php';

// Validar datos de asientos
if (!isset($_SESSION['asientos_comprados']) || !is_array($_SESSION['asientos_comprados'])) {
    echo "No hay datos para generar el recibo.";
    exit();
}

$asientos_ids = $_SESSION['asientos_comprados'];
$total = 0;

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Recibo de Compra',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Asientos comprados:', 0, 1);

// Obtener info de cada asiento
$placeholders = implode(',', array_fill(0, count($asientos_ids), '?'));
$stmt = $conexion->prepare("SELECT numero_asiento, precio FROM asientos WHERE id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($asientos_ids)), ...$asientos_ids);
$stmt->execute();
$res = $stmt->get_result();

while ($fila = $res->fetch_assoc()) {
    $pdf->Cell(0,10, "- Asiento: {$fila['numero_asiento']} | Precio: $" . number_format($fila['precio'], 2), 0, 1);
    $total += $fila['precio'];
}

$pdf->Ln(5);
$pdf->Cell(0,10,'Total: $' . number_format($total, 2), 0, 1);
$pdf->Cell(0,10,'Fecha: ' . date('d/m/Y H:i:s'), 0, 1);
$pdf->Cell(0,10,'Gracias por tu compra!', 0, 1);

$pdf->Output('I', 'recibo.pdf');
?>
