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
    <title>Editar Cliente - Admin</title>
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
    <link rel="stylesheet" href="../includes/footer-styles.css">
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Cliente</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_cliente; ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label" style="font-family: nexa;">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_p" class="form-label" style="font-family: nexa;">Apellido Paterno:</label>
                <input type="text" id="apellido_p" name="apellido_p" class="form-control" value="<?= htmlspecialchars($cliente['apellido_p']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_m" class="form-label" style="font-family: nexa;">Apellido Materno:</label>
                <input type="text" id="apellido_m" name="apellido_m" class="form-control" value="<?= htmlspecialchars($cliente['apellido_m']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="font-family: nexa;">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label" style="font-family: nexa;">Número de Teléfono:</label>
                <input type="tel" id="numero" name="numero" class="form-control" value="<?= htmlspecialchars($cliente['numero']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label" style="font-family: nexa;">Dirección:</label>
                <textarea id="direccion" name="direccion" class="form-control" required><?= htmlspecialchars($cliente['direccion']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Cliente</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../includes/footer-admin.php'; ?>
</body>
</html>