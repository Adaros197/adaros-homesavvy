<?php
session_start();
header('Content-Type: application/json');
require("../conexion.php");

$conexion = retornarConexion();

$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email = mysqli_real_escape_string($conexion, $_POST['email']);
$contraseña = mysqli_real_escape_string($conexion, $_POST['password']);

// Verificar si el correo ya existe en alguna de las tablas
$query_check_email = "
    SELECT email FROM Cliente WHERE email = '$email'
    UNION
    SELECT email FROM Profesional WHERE email = '$email'
    UNION
    SELECT email FROM Admin WHERE email = '$email'
";
$result_check_email = mysqli_query($conexion, $query_check_email);

if (mysqli_num_rows($result_check_email) > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo ya está registrado en otra cuenta']);
    header('Location: error.html?message=El correo ya está registrado en otra cuenta');
    exit();
} else {
    $query = "INSERT INTO Admin (nombre, email, contraseña) VALUES ('$nombre', '$email', '$contraseña')";
    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Administrador registrado exitosamente']);
        header('Location: login.html');
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
        header('Location: error.html?message=Error al registrar: ' . mysqli_error($conexion));
        exit();
    }
}
?>