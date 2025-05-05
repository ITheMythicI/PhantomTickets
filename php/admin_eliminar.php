<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include __DIR__ . '/conexion.php';

// Verificar si se recibió el ID del asiento
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

// Eliminar el asiento
$sql = "DELETE FROM asientos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    $error = "Error al eliminar el asiento.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Asiento</title>
    <link rel="stylesheet" href="http://localhost/Paginaweb-main/css/styles.css">
</head>
<body>
    <main class="main-container">
        <h2>Eliminar Asiento</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <p>El asiento ha sido eliminado correctamente.</p>
        <a href="admin_dashboard.php" class="admin-btn">Volver al Panel</a>
    </main>
</body>
</html>