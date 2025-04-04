<?php
session_start();  
require("../conexion.php");

$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    session_unset();
    session_destroy();
    session_start();

    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password']; 

    function verificarUsuario($conexion, $email, $password, $tabla, $id_campo) {
        $query = "SELECT * FROM $tabla WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['contraseña'])) {
                return $user[$id_campo]; 
            }
        }
        return false;
    }

    // Intentar iniciar sesión en cada tipo de usuario
    if ($cliente_id = verificarUsuario($conexion, $email, $password, "Cliente", "id_cliente")) {
        $_SESSION['cliente_id'] = $cliente_id;
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso como Cliente', 'redirect' => '../trabajos/cliente/c-ver-soli-trabajo-form.php']);
        exit();
    } elseif ($profesional_id = verificarUsuario($conexion, $email, $password, "Profesional", "id_profesional")) {
        $_SESSION['profesional_id'] = $profesional_id;
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso como Profesional', 'redirect' => '../servicios/profesional/p-ver-soli-servicio-form.php']);
        exit();
    } elseif ($admin_id = verificarUsuario($conexion, $email, $password, "Admin", "id_admin")) {
        $_SESSION['admin_id'] = $admin_id;
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso como Admin', 'redirect' => '../admin/a-principal.php']);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Correo o contraseña incorrectos']);
        exit();
    }
}
?>
