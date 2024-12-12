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
    <title>Editar Servicio - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Servicio</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_solicitud_servicio; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label" style="font-family: nexa;">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" value="<?= htmlspecialchars($servicio['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label" style="font-family: nexa;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?= htmlspecialchars($servicio['descripcion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="horarios" class="form-label" style="font-family: nexa;">Horarios:</label>
                <input type="text" id="horarios" name="horarios" class="form-control" value="<?= htmlspecialchars($servicio['horarios']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label" style="font-family: nexa;">Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                    <option value="efectivo" <?= $servicio['metodo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                    <option value="tarjeta" <?= $servicio['metodo_pago'] == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta de Crédito/Débito</option>
                    <option value="transferencia" <?= $servicio['metodo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia Bancaria</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label" style="font-family: nexa;">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" value="<?= htmlspecialchars($servicio['estado']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label" style="font-family: nexa;">Foto (opcional):</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                <?php if ($servicio['foto']): ?>
                    <div class="mt-3">
                        <p style="font-family: nexa;">Foto actual:</p>
                        <img src="../<?= $servicio['foto'] ?>" alt="Foto del servicio" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Servicio</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../includes/footer-admin.php'; ?>
</body>
</html>