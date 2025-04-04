<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-trabajos.php");
    exit;
}

$id_solicitud_trabajo = $_GET['id'];
$query = "SELECT * FROM SolicitudTrabajo WHERE id_solicitud_trabajo = '$id_solicitud_trabajo'";
$result = mysqli_query($conexion, $query);
$trabajo = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $tarifa = $_POST['tarifa'];
    $estado = $_POST['estado'];

    $update_query = "UPDATE SolicitudTrabajo SET titulo='$titulo', descripcion='$descripcion', categoria='$categoria', tarifa='$tarifa', estado='$estado' WHERE id_solicitud_trabajo='$id_solicitud_trabajo'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-trabajos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trabajo - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Trabajo</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_solicitud_trabajo; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label" style="font-family: nexa;">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" value="<?= htmlspecialchars($trabajo['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label" style="font-family: nexa;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?= htmlspecialchars($trabajo['descripcion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label" style="font-family: nexa;">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?= htmlspecialchars($trabajo['categoria']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tarifa" class="form-label" style="font-family: nexa;">Tarifa:</label>
                <input type="number" step="0.01" id="tarifa" name="tarifa" class="form-control" value="<?= htmlspecialchars($trabajo['tarifa']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label" style="font-family: nexa;">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" value="<?= htmlspecialchars($trabajo['estado']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Trabajo</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../includes/footer-admin.php'; ?>
</body>
</html>