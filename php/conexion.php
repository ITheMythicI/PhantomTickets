<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "datos";

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error); // Registrar el error
    die("Error al conectar con la base de datos. Por favor, inténtelo más tarde.");
}

// Establecer el conjunto de caracteres
if (!$conexion->set_charset("utf8")) {
    error_log("Error al establecer el conjunto de caracteres: " . $conexion->error);
    die("Error al configurar la base de datos.");
}
?>

