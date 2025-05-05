<?php
session_start();
include __DIR__ . '/conexion.php'; // Ruta absoluta para evitar problemas

// Verificar si la conexión se estableció correctamente
if (!isset($conexion) || $conexion->connect_error) {
    die("Error al conectar con la base de datos.");
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión o hacer compra rápida.";
    exit();
}

// Verificar si se recibió un asiento válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['asiento'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $asiento_id = $_POST['asiento'];

    // Verifica si el asiento sigue disponible
    $sql = "SELECT estado FROM asientos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $asiento_id);
    $stmt->execute();
    $stmt->bind_result($estado);
    $stmt->fetch();
    $stmt->close();

    if ($estado !== 'disponible') {
        echo "Ese asiento ya no está disponible.";
        exit();
    }

    // Marcar asiento como ocupado
    $sql = "UPDATE asientos SET estado = 'ocupado' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $asiento_id);
    $stmt->execute();

    // Guardar la venta
    $sql = "INSERT INTO ventas (usuario_id, asiento_id) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $asiento_id);
    $stmt->execute();

    // Guardar en sesión para el recibo
    $_SESSION['asiento_id'] = $asiento_id;
    $_SESSION['venta_id'] = $stmt->insert_id;

    $stmt->close();
    $conexion->close();

    header("Location: recibo.php"); // siguiente paso: generar PDF
    exit();
} else {
    echo "No se recibió un asiento válido.";
}
?>