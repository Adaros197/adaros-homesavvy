<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-servicios.php");
    exit;
}

$id_solicitud_servicio = $_GET['id'];
$query = "SELECT * FROM SolicitudServicio WHERE id_solicitud_servicio = '$id_solicitud_servicio'";
$result = mysqli_query($conexion, $query);
$servicio = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $horarios = $_POST['horarios'];
    $metodo_pago = $_POST['metodo_pago'];
    $estado = $_POST['estado'];

    $update_query = "UPDATE SolicitudServicio SET titulo='$titulo', descripcion='$descripcion', horarios='$horarios', metodo_pago='$metodo_pago', estado='$estado' WHERE id_solicitud_servicio='$id_solicitud_servicio'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-servicios.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Servicio</h1>
    <form action="" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= $servicio['titulo'] ?>" required>
        <br><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?= $servicio['descripcion'] ?></textarea>
        <br><br>
        <label for="horarios">Horarios:</label>
        <input type="text" id="horarios" name="horarios" value="<?= $servicio['horarios'] ?>" required>
        <br><br>
        <label for="metodo_pago">Método de Pago:</label>
        <input type="text" id="metodo_pago" name="metodo_pago" value="<?= $servicio['metodo_pago'] ?>" required>
        <br><br>
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?= $servicio['estado'] ?>" required>
        <br><br>
        <button type="submit">Actualizar Servicio</button>
    </form>
</body>
</html>