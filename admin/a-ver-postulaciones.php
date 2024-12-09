<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT ps.*, ss.titulo AS servicio_titulo, p.nombre AS profesional_nombre, c.nombre AS cliente_nombre 
          FROM PostulacionServicio ps
          JOIN SolicitudServicio ss ON ps.id_solicitud_servicio = ss.id_solicitud_servicio
          JOIN Profesional p ON ps.id_profesional = p.id_profesional
          JOIN Cliente c ON ss.id_cliente = c.id_cliente";
$result = mysqli_query($conexion, $query);
$postulaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Postulaciones</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Postulaciones</h1>
    <ul>
        <?php foreach ($postulaciones as $postulacion): ?>
            <li>
                <p><strong>Servicio:</strong> <?= $postulacion['servicio_titulo'] ?></p>
                <p><strong>Profesional:</strong> <?= $postulacion['profesional_nombre'] ?></p>
                <p><strong>Cliente:</strong> <?= $postulacion['cliente_nombre'] ?></p>
                <p><strong>Estado:</strong> <?= $postulacion['estado'] ?></p>
                <p><strong>Fecha de Postulación:</strong> <?= $postulacion['fecha_postulacion'] ?></p>
                <a href="a-editar-postulacion.php?id=<?= $postulacion['id_postulacion_servicio'] ?>">Editar</a>
                <a href="a-eliminar-postulacion.php?id=<?= $postulacion['id_postulacion_servicio'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta postulación?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>