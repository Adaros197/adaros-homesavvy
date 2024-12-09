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
    <title>Ver Servicios</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Servicios</h1>
    <ul>
        <?php foreach ($servicios as $servicio): ?>
            <li>
                <p><strong>Título:</strong> <?= $servicio['titulo'] ?></p>
                <p><strong>Descripción:</strong> <?= $servicio['descripcion'] ?></p>
                <p><strong>Horarios:</strong> <?= $servicio['horarios'] ?></p>
                <p><strong>Método de Pago:</strong> <?= $servicio['metodo_pago'] ?></p>
                <p><strong>Estado:</strong> <?= $servicio['estado'] ?></p>
                <?php if ($servicio['foto']): ?>
                    <p><strong>Foto:</strong></p>
                    <img src="../<?= $servicio['foto'] ?>" alt="Foto del servicio" style="max-width: 200px;">
                <?php endif; ?>
                <a href="a-editar-servicio.php?id=<?= $servicio['id_solicitud_servicio'] ?>">Editar</a>
                <a href="a-eliminar-servicio.php?id=<?= $servicio['id_solicitud_servicio'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>