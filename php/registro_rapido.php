<?php
session_start();
include 'conexion.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

// Revisar si ya existe un usuario con ese correo
$sql = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Ya existe, tomar ese ID
    $stmt->bind_result($id_usuario);
    $stmt->fetch();
} else {
    // Crear usuario sin registro
    $sql = "INSERT INTO usuarios (nombre, correo, registrado) VALUES (?, ?, 0)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $correo);
    $stmt->execute();
    $id_usuario = $stmt->insert_id;
}

$_SESSION['usuario_id'] = $id_usuario;
header("Location: asientos.php");
?>