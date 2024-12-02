<?php
session_start();  // Inicia la sesión del usuario
header('Content-Type: application/json');
require("../conexion.php");

$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar usuario en Cliente
    $query_cliente = "SELECT * FROM Cliente WHERE email = '$email' AND contraseña = '$password'";
    $result_cliente = mysqli_query($conexion, $query_cliente);

    // Consulta para verificar usuario en Profesional
    $query_profesional = "SELECT * FROM Profesional WHERE email = '$email' AND contraseña = '$password'";
    $result_profesional = mysqli_query($conexion, $query_profesional);

    if (mysqli_num_rows($result_cliente) == 1) {
        $user = mysqli_fetch_assoc($result_cliente);
        $_SESSION['cliente_id'] = $user['id_cliente'];
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso como Cliente', 'redirect' => '../trabajos/cliente/c-ver-soli-trabajo-form.php']);
    } elseif (mysqli_num_rows($result_profesional) == 1) {
        $user = mysqli_fetch_assoc($result_profesional);
        $_SESSION['profesional_id'] = $user['id_profesional'];
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso como Profesional', 'redirect' => '../servicios/profesional/p-ver-soli-servicio-form.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Correo o contraseña incorrectos']);
    }
}
?>