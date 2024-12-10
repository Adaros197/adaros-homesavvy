<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT * FROM SolicitudTrabajo";
$result = mysqli_query($conexion, $query);
$trabajos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Trabajos - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Ver Trabajos</h1>
        <ul class="list-group">
            <?php foreach ($trabajos as $trabajo): ?>
                <li class="list-group-item">
                    <p><strong>Título:</strong> <?= $trabajo['titulo'] ?></p>
                    <p><strong>Descripción:</strong> <?= $trabajo['descripcion'] ?></p>
                    <p><strong>Categoría:</strong> <?= $trabajo['categoria'] ?></p>
                    <p><strong>Tarifa:</strong> <?= $trabajo['tarifa'] ?></p>
                    <p><strong>Estado:</strong> <?= $trabajo['estado'] ?></p>
                    <?php if ($trabajo['foto']): ?>
                        <p><strong>Foto:</strong></p>
                        <img src="../<?= $trabajo['foto'] ?>" alt="Foto del trabajo" style="max-width: 200px;">
                    <?php endif; ?>
                    <a href="a-editar-trabajo.php?id=<?= $trabajo['id_solicitud_trabajo'] ?>" class="btn btn-warning" style="font-family: nexa;">Editar</a>
                    <a href="a-eliminar-trabajo.php?id=<?= $trabajo['id_solicitud_trabajo'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este trabajo?')" style="font-family: nexa;">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>