<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

$query = "SELECT * FROM Profesional";
$result = mysqli_query($conexion, $query);
$profesionales = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Profesionales</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Profesionales</h1>
    <ul>
        <?php foreach ($profesionales as $profesional): ?>
            <li>
                <p><strong>Nombre:</strong> <?= $profesional['nombre'] ?></p>
                <p><strong>Apellido Paterno:</strong> <?= $profesional['apellido_p'] ?></p>
                <p><strong>Apellido Materno:</strong> <?= $profesional['apellido_m'] ?></p>
                <p><strong>Email:</strong> <?= $profesional['email'] ?></p>
                <p><strong>Número de Teléfono:</strong> <?= $profesional['numero'] ?></p>
                <p><strong>Dirección:</strong> <?= $profesional['direccion'] ?></p>
                <p><strong>Profesión:</strong> <?= $profesional['profesion'] ?></p>
                <p><strong>RFC:</strong> <?= $profesional['rfc'] ?></p>
                <?php if ($profesional['foto_perfil']): ?>
                    <p><strong>Foto de Perfil:</strong></p>
                    <img src="../<?= $profesional['foto_perfil'] ?>" alt="Foto de perfil" style="max-width: 200px;">
                <?php endif; ?>
                <?php if ($profesional['ine']): ?>
                    <p><strong>INE:</strong></p>
                    <button onclick="window.open('../<?= $profesional['ine'] ?>', '_blank')">Ver INE</button>
                <?php endif; ?>
                <?php if ($profesional['comprobante_domicilio']): ?>
                    <p><strong>Comprobante de Domicilio:</strong></p>
                    <button onclick="window.open('../<?= $profesional['comprobante_domicilio'] ?>', '_blank')">Ver Comprobante de Domicilio</button>
                <?php endif; ?>
                <?php if ($profesional['curriculum']): ?>
                    <p><strong>Currículum:</strong></p>
                    <button onclick="window.open('../<?= $profesional['curriculum'] ?>', '_blank')">Ver Currículum</button>
                <?php endif; ?>
                <?php if ($profesional['antecedentes']): ?>
                    <p><strong>Antecedentes:</strong></p>
                    <button onclick="window.open('../<?= $profesional['antecedentes'] ?>', '_blank')">Ver Antecedentes</button>
                <?php endif; ?>
                <?php if ($profesional['cartas_recomendacion']): ?>
                    <p><strong>Cartas de Recomendación:</strong></p>
                    <button onclick="window.open('../<?= $profesional['cartas_recomendacion'] ?>', '_blank')">Ver Cartas de Recomendación</button>
                <?php endif; ?>
                <?php if ($profesional['constancia_situacion_fiscal']): ?>
                    <p><strong>Constancia de Situación Fiscal:</strong></p>
                    <button onclick="window.open('../<?= $profesional['constancia_situacion_fiscal'] ?>', '_blank')">Ver Constancia de Situación Fiscal</button>
                <?php endif; ?>
                <a href="a-editar-profesional.php?id=<?= $profesional['id_profesional'] ?>">Editar</a>
                <a href="a-eliminar-profesional.php?id=<?= $profesional['id_profesional'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este profesional?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>