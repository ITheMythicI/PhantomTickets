<?php
session_start();
include __DIR__ . '/conexion.php'; // Ruta absoluta para evitar errores

// Verificar si la conexión se estableció correctamente
if (!isset($conexion) || $conexion->connect_error) {
    die("Error al conectar con la base de datos. Por favor, inténtelo más tarde.");
}

// Obtener todos los asientos
$sql = "SELECT * FROM asientos";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al obtener los datos de los asientos. Por favor, inténtelo más tarde.");
}

// Procesar la selección de los asientos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asientos']) && is_array($_POST['asientos']) && count($_POST['asientos']) > 0) {
        $asientosSeleccionados = $_POST['asientos'];
        $asientosValidos = [];

        foreach ($asientosSeleccionados as $asientoId) {
            $asientoId = $conexion->real_escape_string($asientoId);
            $check = $conexion->query("SELECT estado FROM asientos WHERE id = '$asientoId' LIMIT 1");

            if ($check && $row = $check->fetch_assoc()) {
                if ($row['estado'] == 'disponible') {
                    $asientosValidos[] = $asientoId;
                }
            }
        }

        if (count($asientosValidos) > 0) {
            $_SESSION['asientos_seleccionados'] = $asientosValidos;
            header("Location: pago.php");
            exit();
        } else {
            $error = "Los asientos seleccionados ya no están disponibles. Intenta nuevamente.";
        }
    } else {
        $error = "Por favor, selecciona al menos un asiento.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tus asientos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="asientos.css">
</head>
<body>
    <header class="header">
        <h1>PHANTOM TICKETS</h1>
    </header>
    <main class="main-container">
        <h2>Selecciona tus asientos</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="asientos.php" method="POST" class="form-asientos" id="form-asientos">
            <div class="contenedor-asientos">
                <?php
                // Volver a ejecutar consulta para mostrar los asientos
                $resultado = $conexion->query($sql);
                while ($fila = $resultado->fetch_assoc()): ?>
                    <label class="asiento <?= htmlspecialchars($fila['estado']) ?>">
                        <input type="checkbox" name="asientos[]" value="<?= htmlspecialchars($fila['id']) ?>"
                            <?= $fila['estado'] === 'ocupado' ? 'disabled' : '' ?>>
                        <span><?= htmlspecialchars($fila['numero_asiento']) ?></span>
                    </label>
                <?php endwhile; ?>
            </div>
            <button type="submit" class="btn-continuar">Continuar</button>
        </form>
    </main>
    <footer class="footer">
        <p>&copy; 2025 PHANTOM TICKETS. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.getElementById("form-asientos").addEventListener("submit", function(e) {
            const seleccionados = document.querySelectorAll('input[name="asientos[]"]:checked');
            if (seleccionados.length === 0) {
                e.preventDefault();
                alert("Por favor, selecciona al menos un asiento antes de continuar.");
            }
        });
    </script>
</body>
</html>
