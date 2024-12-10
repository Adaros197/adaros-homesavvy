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
    <title>Ver Trabajos</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Trabajos</h1>
    <ul>
        <?php foreach ($trabajos as $trabajo): ?>
            <li>
                <p><strong>Título:</strong> <?= $trabajo['titulo'] ?></p>
                <p><strong>Descripción:</strong> <?= $trabajo['descripcion'] ?></p>
                <p><strong>Categoría:</strong> <?= $trabajo['categoria'] ?></p>
                <p><strong>Tarifa:</strong> <?= $trabajo['tarifa'] ?></p>
                <p><strong>Estado:</strong> <?= $trabajo['estado'] ?></p>
                <?php if ($trabajo['foto']): ?>
                    <p><strong>Foto:</strong></p>
                    <img src="../<?= $trabajo['foto'] ?>" alt="Foto del trabajo" style="max-width: 200px;">
                <?php endif; ?>
                <a href="a-editar-trabajo.php?id=<?= $trabajo['id_solicitud_trabajo'] ?>">Editar</a>
                <a href="a-eliminar-trabajo.php?id=<?= $trabajo['id_solicitud_trabajo'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este trabajo?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>