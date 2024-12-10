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
    <title>Editar Profesional - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Profesional</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_profesional; ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label" style="font-family: nexa;">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($profesional['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_p" class="form-label" style="font-family: nexa;">Apellido Paterno:</label>
                <input type="text" id="apellido_p" name="apellido_p" class="form-control" value="<?= htmlspecialchars($profesional['apellido_p']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido_m" class="form-label" style="font-family: nexa;">Apellido Materno:</label>
                <input type="text" id="apellido_m" name="apellido_m" class="form-control" value="<?= htmlspecialchars($profesional['apellido_m']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="font-family: nexa;">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($profesional['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label" style="font-family: nexa;">Número de Teléfono:</label>
                <input type="tel" id="numero" name="numero" class="form-control" value="<?= htmlspecialchars($profesional['numero']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label" style="font-family: nexa;">Dirección:</label>
                <textarea id="direccion" name="direccion" class="form-control" required><?= htmlspecialchars($profesional['direccion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="profesion" class="form-label" style="font-family: nexa;">Profesión:</label>
                <input type="text" id="profesion" name="profesion" class="form-control" value="<?= htmlspecialchars($profesional['profesion']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="rfc" class="form-label" style="font-family: nexa;">RFC:</label>
                <input type="text" id="rfc" name="rfc" class="form-control" value="<?= htmlspecialchars($profesional['rfc']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Profesional</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>