<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (isset($_SESSION['admin_id'])) {
    $user_id = $_SESSION['admin_id'];
    $table = 'Admin';
    $id_field = 'id_admin';
} elseif (isset($_SESSION['cliente_id'])) {
    $user_id = $_SESSION['cliente_id'];
    $table = 'Cliente';
    $id_field = 'id_cliente';
} elseif (isset($_SESSION['profesional_id'])) {
    $user_id = $_SESSION['profesional_id'];
    $table = 'Profesional';
    $id_field = 'id_profesional';
} else {
    echo "<p>Usuario no autenticado. Por favor, inicia sesión.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = !empty($_POST['password']) ? mysqli_real_escape_string($conexion, $_POST['password']) : null;

    $update_query = "UPDATE $table SET nombre='$nombre', email='$email'";
    if ($password) $update_query .= ", contraseña='$password'";

    if ($table == 'Cliente' || $table == 'Profesional') {
        $numero = isset($_POST['numero']) ? mysqli_real_escape_string($conexion, $_POST['numero']) : null;
        $direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conexion, $_POST['direccion']) : null;
        if ($numero) $update_query .= ", numero='$numero'";
        if ($direccion) $update_query .= ", direccion='$direccion'";
    }

    if ($table == 'Profesional') {
        $profesion = isset($_POST['profesion']) ? mysqli_real_escape_string($conexion, $_POST['profesion']) : null;
        $rfc = isset($_POST['rfc']) ? mysqli_real_escape_string($conexion, $_POST['rfc']) : null;
        if ($profesion) $update_query .= ", profesion='$profesion'";
        if ($rfc) $update_query .= ", rfc='$rfc'";
    }

    $update_query .= " WHERE $id_field='$user_id'";

    if (mysqli_query($conexion, $update_query)) {
        echo "<p>Perfil actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el perfil: " . mysqli_error($conexion) . "</p>";
    }

    // Procesar nueva foto de perfil si se subió (solo para clientes y profesionales)
    if (($table == 'Cliente' || $table == 'Profesional') && !empty($_FILES['foto_perfil']['name'])) {
        $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $ruta_foto = "uploads/perfil/$user_id.$extension";
        if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../$ruta_foto")) {
            die("<p>Error al mover el archivo de foto de perfil</p>");
        }
        // Actualizar la foto de perfil en la base de datos
        $query = "UPDATE $table SET foto_perfil = '$ruta_foto' WHERE $id_field = '$user_id'";
        mysqli_query($conexion, $query);
    }
}

$query = "SELECT * FROM $table WHERE $id_field = '$user_id'";
$result = mysqli_query($conexion, $query);
$user = mysqli_fetch_assoc($result);
if (!$user) {
    echo "<p>Error al cargar los datos del usuario.</p>";
    exit;
}

if (isset($_SESSION['admin_id'])) {
    $admin = $user;
}
?>