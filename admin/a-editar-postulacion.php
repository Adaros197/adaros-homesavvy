<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-postulaciones.php");
    exit;
}

$id_postulacion_servicio = $_GET['id'];
$query = "SELECT ps.*, ss.titulo AS servicio_titulo, p.nombre AS profesional_nombre, c.nombre AS cliente_nombre 
          FROM PostulacionServicio ps
          JOIN SolicitudServicio ss ON ps.id_solicitud_servicio = ss.id_solicitud_servicio
          JOIN Profesional p ON ps.id_profesional = p.id_profesional
          JOIN Cliente c ON ss.id_cliente = c.id_cliente
          WHERE ps.id_postulacion_servicio = '$id_postulacion_servicio'";
$result = mysqli_query($conexion, $query);
$postulacion = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'];

    $update_query = "UPDATE PostulacionServicio SET estado='$estado' WHERE id_postulacion_servicio='$id_postulacion_servicio'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-postulaciones.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Postulación - Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: nexa;
            src: url('../assets/fonts/title.ttf');
        }
        body {
            font-family: nexa;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Postulación</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_postulacion_servicio; ?>" method="POST">
            <div class="mb-3">
                <label for="estado" class="form-label" style="font-family: nexa;">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" value="<?= htmlspecialchars($postulacion['estado']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Postulación</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>