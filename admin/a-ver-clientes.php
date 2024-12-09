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
    <title>Ver Clientes</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Clientes</h1>
    <ul>
        <?php foreach ($clientes as $cliente): ?>
            <li>
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
                    <button onclick="window.open('../<?= $cliente['ine'] ?>', '_blank')">Ver INE</button>
                <?php endif; ?>
                <?php if ($cliente['comprobante_domicilio']): ?>
                    <p><strong>Comprobante de Domicilio:</strong></p>
                    <button onclick="window.open('../<?= $cliente['comprobante_domicilio'] ?>', '_blank')">Ver Comprobante de Domicilio</button>
                <?php endif; ?>
                <a href="a-editar-cliente.php?id=<?= $cliente['id_cliente'] ?>">Editar</a>
                <a href="a-eliminar-cliente.php?id=<?= $cliente['id_cliente'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>