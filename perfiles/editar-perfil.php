<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (isset($_SESSION['profesional_id'])) {
    $user_id = $_SESSION['profesional_id'];
    $table = "Profesional";
    $id_field = "id_profesional";
} elseif (isset($_SESSION['cliente_id'])) {
    $user_id = $_SESSION['cliente_id'];
    $table = "Cliente";
    $id_field = "id_cliente";
} else {
    echo "<p>Usuario no autenticado. Por favor, inicia sesión.</p>";
    exit;
}

// Actualizar perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $direccion = $_POST['direccion'];

    if ($table == "Profesional") {
        $profesion = $_POST['profesion'];
        $rfc = $_POST['rfc'];
        $update_query = "UPDATE $table SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m', email='$email', numero='$numero', direccion='$direccion', profesion='$profesion', rfc='$rfc' WHERE $id_field='$user_id'";
    } else {
        $update_query = "UPDATE $table SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m', email='$email', numero='$numero', direccion='$direccion' WHERE $id_field='$user_id'";
    }

    if (mysqli_query($conexion, $update_query)) {
        echo "<p>Perfil actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el perfil: " . mysqli_error($conexion) . "</p>";
    }
}

$query = "SELECT * FROM $table WHERE $id_field = '$user_id'";
$result = mysqli_query($conexion, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<p>Error al cargar los datos del usuario.</p>";
    exit;
}
?>