<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-profesionales.php");
    exit;
}

$id_profesional = $_GET['id'];
$query = "SELECT * FROM Profesional WHERE id_profesional = '$id_profesional'";
$result = mysqli_query($conexion, $query);
$profesional = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $direccion = $_POST['direccion'];
    $profesion = $_POST['profesion'];
    $rfc = $_POST['rfc'];

    $update_query = "UPDATE Profesional SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m', email='$email', numero='$numero', direccion='$direccion', profesion='$profesion', rfc='$rfc' WHERE id_profesional='$id_profesional'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-profesionales.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesional</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Profesional</h1>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $profesional['nombre'] ?>" required>
        <br><br>
        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" value="<?= $profesional['apellido_p'] ?>" required>
        <br><br>
        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m" value="<?= $profesional['apellido_m'] ?>" required>
        <br><br>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?= $profesional['email'] ?>" required>
        <br><br>
        <label for="numero">Número de Teléfono:</label>
        <input type="tel" id="numero" name="numero" value="<?= $profesional['numero'] ?>" required>
        <br><br>
        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?= $profesional['direccion'] ?></textarea>
        <br><br>
        <label for="profesion">Profesión:</label>
        <input type="text" id="profesion" name="profesion" value="<?= $profesional['profesion'] ?>" required>
        <br><br>
        <label for="rfc">RFC:</label>
        <input type="text" id="rfc" name="rfc" value="<?= $profesional['rfc'] ?>" required>
        <br><br>
        <button type="submit">Actualizar Profesional</button>
    </form>
</body>
</html>