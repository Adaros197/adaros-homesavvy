<?php
session_start();
header('Content-Type: application/json');
require("../conexion.php");

$conexion = retornarConexion();

$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email = mysqli_real_escape_string($conexion, $_POST['email']);
$contraseña = mysqli_real_escape_string($conexion, $_POST['password']);

$query = "INSERT INTO Admin (nombre, email, contraseña) VALUES ('$nombre', '$email', '$contraseña')";

if (mysqli_query($conexion, $query)) {
    echo json_encode(['success' => true, 'message' => 'Administrador registrado exitosamente']);
    header('Location: login.html');
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
}
?>