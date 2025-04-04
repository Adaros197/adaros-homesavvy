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
    <title>Ver Peticiones - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Ver Peticiones</h1>
        <ul class="list-group">
            <?php foreach ($peticiones as $peticion): ?>
                <li class="list-group-item">
                    <p><strong>Título:</strong> <?= $peticion['trabajo_titulo'] ?></p>
                    <p><strong>Cliente:</strong> <?= $peticion['cliente_nombre'] ?></p>
                    <p><strong>Profesional:</strong> <?= $peticion['profesional_nombre'] ?></p>
                    <p><strong>Estado:</strong> <?= $peticion['estado'] ?></p>
                    <p><strong>Fecha de Petición:</strong> <?= $peticion['fecha_peticion'] ?></p>
                    <a href="a-editar-peticion.php?id=<?= $peticion['id_peticion_trabajo'] ?>" class="btn btn-warning" style="font-family: nexa;">Editar</a>
                    <a href="a-eliminar-peticion.php?id=<?= $peticion['id_peticion_trabajo'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta petición?')" style="font-family: nexa;">Eliminar</a>
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