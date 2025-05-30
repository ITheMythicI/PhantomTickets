<?php
session_start();
include __DIR__ . '/conexion.php';

if (!isset($_SESSION['asientos_seleccionados']) || !is_array($_SESSION['asientos_seleccionados'])) {
    echo "No hay asientos por procesar.";
    exit();
}

$asientos_ids = $_SESSION['asientos_seleccionados'];
$placeholders = implode(',', array_fill(0, count($asientos_ids), '?'));

// Cambiar estado a ocupado
$sql = "UPDATE asientos SET estado = 'ocupado' WHERE id IN ($placeholders)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param(str_repeat('i', count($asientos_ids)), ...$asientos_ids);
$stmt->execute();

// Guardar info para recibo
$_SESSION['asientos_comprados'] = $asientos_ids;

header("Location: recibo.php");
exit();
?>
