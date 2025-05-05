<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "datos");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar que se recibió el asiento
if (isset($_POST['asiento'])) {
    $asiento = $_POST['asiento'];

    // Marcar el asiento como vendido
    $sql = "UPDATE boletos SET disponible = 0 WHERE asiento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $asiento);
    $stmt->execute();

    // Disminuir la cantidad de boletos en el evento correspondiente
    // Suponiendo que el evento tiene un ID (puedes ajustar según tu estructura)
    $evento_id = 1; // Cambia este valor por el ID del evento adecuado
    $conexion->query("UPDATE eventos SET total_boletos = total_boletos - 1 WHERE id = $evento_id");

    // Generar el recibo en PDF
    require('fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Recibo de Compra');   
    $pdf->Ln(10);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Asiento comprado: ' . $asiento, 0, 1);
    $pdf->Cell(0,10,'Fecha: ' . date('d/m/Y H:i:s'), 0, 1);
    $pdf->Cell(0,10,'Gracias por tu compra!', 0, 1);

    $pdf->Output('I', 'recibo.pdf'); // 'I' para mostrar directamente en el navegador
    exit();
} else {
    echo "No se recibió el asiento.";
}

$conexion->close();
?>
