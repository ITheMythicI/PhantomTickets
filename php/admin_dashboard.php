<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include __DIR__ . '/conexion.php';

// Obtener inventario
$sql = "SELECT * FROM asientos";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Administrador</title>
    <link rel="stylesheet" href="http://localhost/Paginaweb-main/css/styles.css">
</head>
<body>
    <header class="header">
        <p class="logo">Panel Admin</p>
    </header>

    <!-- Sección principal -->
    <section id="admin-panel" class="section">
        <h2 class="body-unete">Panel del Administrador</h2>
        <div class="admin-menu">
            <a href="admin_agregar.php" class="admin-btn">➕ Agregar Nuevo Producto</a><br><br>
            <a href="logout.php" class="admin-btn">🔒 Cerrar Sesión</a>
        </div>

        <h3>Inventario Actual</h3>
        <table border="1" style="width: 100%; margin-top: 20px; text-align: center; color: black;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número de Asiento</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['id']) ?></td>
                        <td><?= htmlspecialchars($fila['numero_asiento']) ?></td>
                        <td><?= htmlspecialchars($fila['estado']) ?></td>
                        <td>$<?= htmlspecialchars($fila['precio']) ?></td>
                        <td>
                            <a href="admin_editar.php?id=<?= $fila['id'] ?>" class="admin-btn">✏️ Editar</a>
                            <a href="admin_eliminar.php?id=<?= $fila['id'] ?>" class="admin-btn" style="color: white;">❌ Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <!-- Pie de página -->
    <footer class="footer">
        <p>Panel de Administrador | © Phantom Tickets</p>
    </footer>
</body>
</html>