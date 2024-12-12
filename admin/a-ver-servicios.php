<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT * FROM SolicitudServicio";
$result = mysqli_query($conexion, $query);
$servicios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Servicios - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Ver Servicios</h1>
        <ul class="list-group">
            <?php foreach ($servicios as $servicio): ?>
                <li class="list-group-item">
                    <p><strong>Título:</strong> <?= $servicio['titulo'] ?></p>
                    <p><strong>Descripción:</strong> <?= $servicio['descripcion'] ?></p>
                    <p><strong>Horarios:</strong> <?= $servicio['horarios'] ?></p>
                    <p><strong>Método de Pago:</strong> <?= $servicio['metodo_pago'] ?></p>
                    <p><strong>Estado:</strong> <?= $servicio['estado'] ?></p>
                    <?php if ($servicio['foto']): ?>
                        <p><strong>Foto:</strong></p>
                        <img src="../<?= $servicio['foto'] ?>" alt="Foto del servicio" style="max-width: 200px;">
                    <?php endif; ?>
                    <a href="a-editar-servicio.php?id=<?= $servicio['id_solicitud_servicio'] ?>" class="btn btn-warning" style="font-family: nexa;">Editar</a>
                    <a href="a-eliminar-servicio.php?id=<?= $servicio['id_solicitud_servicio'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')" style="font-family: nexa;">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../includes/footer-admin.php'; ?>
</body>
</html>