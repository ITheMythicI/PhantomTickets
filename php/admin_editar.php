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

// Obtener los datos actuales del asiento
$sql = "SELECT * FROM asientos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: admin_dashboard.php");
    exit();
}

$asiento = $resultado->fetch_assoc();

// Actualizar los datos del asiento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_asiento = $_POST['numero_asiento'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];

    $sql = "UPDATE asientos SET numero_asiento = ?, estado = ?, precio = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdi", $numero_asiento, $estado, $precio, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Error al actualizar el asiento.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asiento</title>
    <link rel="stylesheet" href="http://localhost/Paginaweb-main/css/styles.css">
</head>
<body>
    <main class="main-container">
        <h2>Editar Asiento</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="admin_editar.php?id=<?= htmlspecialchars($id) ?>" method="POST" class="form">
            <label for="numero_asiento">Número de Asiento:</label>
            <input type="text" name="numero_asiento" id="numero_asiento" value="<?= htmlspecialchars($asiento['numero_asiento']) ?>" required>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="disponible" <?= $asiento['estado'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                <option value="ocupado" <?= $asiento['estado'] === 'ocupado' ? 'selected' : '' ?>>Ocupado</option>
            </select>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" step="0.01" value="<?= htmlspecialchars($asiento['precio']) ?>" required>

            <button type="submit" class="admin-btn">Guardar Cambios</button>
        </form>
    </main>
</body>
</html>