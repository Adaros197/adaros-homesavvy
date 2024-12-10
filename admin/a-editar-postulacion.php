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
    <title>Editar Postulación</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Postulación</h1>
    <form action="" method="POST">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?= $postulacion['estado'] ?>" required>
        <br><br>
        <button type="submit">Actualizar Postulación</button>
    </form>
</body>
</html>