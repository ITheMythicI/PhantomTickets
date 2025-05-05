<?php
session_start();
include __DIR__ . '/conexion.php'; // Incluye la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario_data = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario_data['contraseña'])) {
            // Guardar datos en la sesión
            $_SESSION['usuario_id'] = $usuario_data['id'];
            $_SESSION['usuario_correo'] = $usuario_data['correo'];
            $_SESSION['usuario_rol'] = $usuario_data['rol'];

            // Redirigir según el rol
            if ($usuario_data['rol'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: http://localhost/Paginaweb-main/index.html");
                exit();
            }
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <main class="main-container">
        <h2>Inicio de Sesión</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST" class="form">
            <input type="text" name="correo" placeholder="Correo" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </main>
</body>
</html>





