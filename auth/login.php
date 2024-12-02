<?php
session_start();  // Inicia la sesión del usuario
header('Content-Type: application/json');
require("../conexion.php");

$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar usuario
    $query = "SELECT * FROM Cliente WHERE email = '$email' AND contraseña = '$password'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['cliente_id'] = $user['id_cliente'];
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Correo o contraseña incorrectos']);
    }
}
?>