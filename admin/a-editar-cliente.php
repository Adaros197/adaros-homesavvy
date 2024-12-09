<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-clientes.php");
    exit;
}

$id_cliente = $_GET['id'];
$query = "SELECT * FROM Cliente WHERE id_cliente = '$id_cliente'";
$result = mysqli_query($conexion, $query);
$cliente = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $direccion = $_POST['direccion'];

    $update_query = "UPDATE Cliente SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m', email='$email', numero='$numero', direccion='$direccion' WHERE id_cliente='$id_cliente'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-clientes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Cliente</h1>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $cliente['nombre'] ?>" required>
        <br><br>
        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" value="<?= $cliente['apellido_p'] ?>" required>
        <br><br>
        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m" value="<?= $cliente['apellido_m'] ?>" required>
        <br><br>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?= $cliente['email'] ?>" required>
        <br><br>
        <label for="numero">Número de Teléfono:</label>
        <input type="tel" id="numero" name="numero" value="<?= $cliente['numero'] ?>" required>
        <br><br>
        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?= $cliente['direccion'] ?></textarea>
        <br><br>
        <button type="submit">Actualizar Cliente</button>
    </form>
</body>
</html>