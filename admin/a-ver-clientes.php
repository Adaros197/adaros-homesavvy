<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT * FROM Cliente";
$result = mysqli_query($conexion, $query);
$clientes = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Clientes - Admin</title>
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
        <h1 class="mb-4" style="color: #ec6cb2;">Ver Clientes</h1>
        <ul class="list-group">
            <?php foreach ($clientes as $cliente): ?>
                <li class="list-group-item">
                    <p><strong>Nombre:</strong> <?= $cliente['nombre'] ?></p>
                    <p><strong>Apellido Paterno:</strong> <?= $cliente['apellido_p'] ?></p>
                    <p><strong>Apellido Materno:</strong> <?= $cliente['apellido_m'] ?></p>
                    <p><strong>Email:</strong> <?= $cliente['email'] ?></p>
                    <p><strong>Número de Teléfono:</strong> <?= $cliente['numero'] ?></p>
                    <p><strong>Dirección:</strong> <?= $cliente['direccion'] ?></p>
                    <?php if ($cliente['foto_perfil']): ?>
                        <p><strong>Foto de Perfil:</strong></p>
                        <img src="../<?= $cliente['foto_perfil'] ?>" alt="Foto de perfil" style="max-width: 200px;">
                    <?php endif; ?>
                    <?php if ($cliente['ine']): ?>
                        <p><strong>INE:</strong></p>
                        <button class="btn btn-link" onclick="window.open('../<?= $cliente['ine'] ?>', '_blank')">Ver INE</button>
                    <?php endif; ?>
                    <?php if ($cliente['comprobante_domicilio']): ?>
                        <p><strong>Comprobante de Domicilio:</strong></p>
                        <button class="btn btn-link" onclick="window.open('../<?= $cliente['comprobante_domicilio'] ?>', '_blank')">Ver Comprobante de Domicilio</button>
                    <?php endif; ?>
                    <a href="a-editar-cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning" style="font-family: nexa;">Editar</a>
                    <a href="a-eliminar-cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')" style="font-family: nexa;">Eliminar</a>
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