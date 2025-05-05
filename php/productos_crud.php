<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Productos</title>
    <link rel="stylesheet" href="http://localhost/Paginaweb-main/css/styles.css">
</head>
<body>

<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: php/login.php");
    exit();
}

include("conexion.php"); // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $descripcion = $conexion->real_escape_string($_POST["descripcion"]);
    $precio = floatval($_POST["precio"]);
    $disponibilidad = intval($_POST["disponibilidad"]);

    $sql = "INSERT INTO productos (nombre, descripcion, precio, disponibilidad) 
            VALUES ('$nombre', '$descripcion', $precio, $disponibilidad)";

if ($conexion->query($sql) === TRUE) {
        echo "<div class='alert'>Producto agregado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-error'>Error: " . $conexion->error . "</div>";
    }
}

// Obtener productos
$resultado = $conexion->query("SELECT * FROM productos");
?>

<!-- Barra de Navegación -->
<header class="header">
    <nav class="nav">
        <h1 class="h1-imagen4"></h1>
        <ul class="nav-links">
            <li><a href="admin_dashboard.php">← Volver al Panel</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>

<main class="main">

    <!-- Sección Inventario -->
    <section id="inventario-de-productos" class="section">
        <h2 class="body-qs">Agregar Nuevo Producto</h2>
        <form class="form" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="disponibilidad">Disponibles:</label>
            <input type="number" id="disponibilidad" name="disponibilidad" required>

            <button type="submit">Agregar Producto</button>
        </form>
    </section>

    <!-- Sección Lista de Productos -->
    <section id="lista-productos" class="section">
        <h2 class="body-qs">Lista de Productos</h2>
        <div class="grid">
            <table style="width:100%; text-align:center; color: black">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['descripcion']; ?></td>
                        <td>$<?php echo number_format($fila['precio'], 2); ?></td>
                        <td><?php echo $fila['disponibilidad']; ?></td>
                        <td>
                            <a class="btn-edit" href="editar_producto.php?id=<?php echo $fila['id']; ?>">Editar</a>
<a class="btn-delete" href="eliminar_producto.php?id=<?php echo $fila['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<!-- Pie de página -->
<footer class="footer">
    <p>&copy; 2025 Phantom Tickets. Panel de Administración.</p>
</footer>

</body>
</html>
