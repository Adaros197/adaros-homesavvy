<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formulario = $_POST['formulario'] ?? '';
    $update_query = "";

    if ($formulario === 'basico') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellido_p']);
        $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellido_m']);
        $update_query = "UPDATE $table SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m'";

    } elseif ($formulario === 'contacto') {
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $numero = mysqli_real_escape_string($conexion, $_POST['numero']);
        $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
        $update_query = "UPDATE $table SET email='$email', numero='$numero', direccion='$direccion'";

    } elseif ($formulario === 'password') {
        $password = mysqli_real_escape_string($conexion, $_POST['password']);
        $confirmar = mysqli_real_escape_string($conexion, $_POST['confirmar_password']);

        if ($password === $confirmar && !empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $update_query = "UPDATE $table SET contraseña='$hash'";
        } else {
            echo "<p>Las contraseñas no coinciden o están vacías.</p>";
            exit;
        }
    }

    if (!empty($update_query)) {
        $update_query .= " WHERE $id_field='$user_id'";
        if (mysqli_query($conexion, $update_query)) {
            echo "
            <div class='container mt-4'>
                <div class='alert alert-success text-center rounded-pill shadow-sm'
                    style='background-color: #d4f4dd !important; color: #228b52 !important; font-family: nexa;'>
                    <strong>¡Perfil actualizado correctamente!</strong>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s ease-out';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>
            ";
        } else {
            echo "
            <div class='container mt-4'>
                <div class='alert alert-danger text-center rounded-pill shadow-sm'
                    style='background-color: #f8d7da !important; color: #842029 !important; font-family: nexa;'>
                    <strong>Error al actualizar el perfil:</strong> " . mysqli_error($conexion) . "
                </div>
            </div>
            ";
        }
    }
    

    if (($table == 'Cliente' || $table == 'Profesional') && !empty($_FILES['foto_perfil']['name'])) {
    $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);

    // Carpeta de destino según el tipo de usuario
    $carpeta = ($table == 'Cliente') ? "uploads/clientes/perfil" : "uploads/profesionales/perfil";

    // Ruta completa donde se almacenará la imagen
    $ruta_foto = "$carpeta/$user_id.$extension";

    // Asegurarse de que la carpeta exista
    if (!is_dir("../$carpeta")) {
        mkdir("../$carpeta", 0777, true);
    }

    // Subir la foto
    if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../$ruta_foto")) {
        die("<p>Error al mover el archivo de foto de perfil</p>");
    }

    // Guardar la ruta en la base de datos
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

ob_end_flush();
?>
