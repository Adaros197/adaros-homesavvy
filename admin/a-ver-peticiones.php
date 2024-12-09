<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT pt.*, st.titulo AS trabajo_titulo, c.nombre AS cliente_nombre, p.nombre AS profesional_nombre 
          FROM PeticionTrabajo pt
          JOIN SolicitudTrabajo st ON pt.id_solicitud_trabajo = st.id_solicitud_trabajo
          JOIN Cliente c ON pt.id_cliente = c.id_cliente
          JOIN Profesional p ON st.id_profesional = p.id_profesional";
$result = mysqli_query($conexion, $query);
$peticiones = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Peticiones</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Peticiones</h1>
    <ul>
        <?php foreach ($peticiones as $peticion): ?>
            <li>
                <p><strong>Trabajo:</strong> <?= $peticion['trabajo_titulo'] ?></p>
                <p><strong>Cliente:</strong> <?= $peticion['cliente_nombre'] ?></p>
                <p><strong>Profesional:</strong> <?= $peticion['profesional_nombre'] ?></p>
                <p><strong>Estado:</strong> <?= $peticion['estado'] ?></p>
                <p><strong>Fecha de Petición:</strong> <?= $peticion['fecha_peticion'] ?></p>
                <a href="a-editar-peticion.php?id=<?= $peticion['id_peticion_trabajo'] ?>">Editar</a>
                <a href="a-eliminar-peticion.php?id=<?= $peticion['id_peticion_trabajo'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta petición?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>