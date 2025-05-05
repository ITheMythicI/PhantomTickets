<?php
session_start();
include __DIR__ . '/conexion.php'; // Ruta absoluta para evitar problemas

// Habilitar registro de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanitizar entradas
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
    $correo = filter_var(trim($_POST['correo']), FILTER_VALIDATE_EMAIL);
    $contraseña = $_POST['contraseña'];

    if (empty($nombre) || empty($correo) || empty($contraseña)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    if (!$correo) {
        echo "Correo inválido.";
        exit();
    }

    $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar contraseña

    // Verificar si el correo ya existe
    $sql = "SELECT id FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El correo ya está registrado.";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, correo, contraseña, registrado) VALUES (?, ?, ?, 1)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $nombre, $correo, $contraseña);

        if ($stmt->execute()) {
            $_SESSION['usuario_id'] = $stmt->insert_id;
            $_SESSION['usuario_nombre'] = $nombre;
            echo "Redirigiendo a asientos.php...";
            header("Location: asientos.php");
            exit();
        } else {
            echo "Error en la consulta: " . $stmt->error;
        }
    }

    $stmt->close();
    $conexion->close();
}
?>

