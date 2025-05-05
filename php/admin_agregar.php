<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include __DIR__ . '/conexion.php';

// Procesar el formulario de agregar asiento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_asiento = $_POST['numero_asiento'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO asientos (numero_asiento, estado, precio) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssd", $numero_asiento, $estado, $precio);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Error al agregar el asiento.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Asiento</title>
    <link rel="stylesheet" href="http://localhost/Paginaweb-main/css/styles.css">
</head>
<body>
    <main class="main-container">
        <h2>Agregar Nuevo Asiento</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="admin_agregar.php" method="POST" class="form">
            <label for="numero_asiento">Número de Asiento:</label>
            <input type="text" name="numero_asiento" id="numero_asiento" placeholder="Ejemplo: A1" required>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="disponible">Disponible</option>
                <option value="ocupado">Ocupado</option>
            </select>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" step="0.01" placeholder="Ejemplo: 100.00" required>

            <button type="submit" class="admin-btn">Agregar Asiento</button>
        </form>
    </main>
</body>
</html>