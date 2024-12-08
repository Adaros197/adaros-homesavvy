<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfil - Profesional</title>
</head>
<body>
    <?php include '../includes/navbar-profesional.php'; ?>
    <h1>Gestión de Perfil - Profesional</h1>
    <form action="../auth/logout.php" method="POST">
        <button type="submit">Cerrar Sesión</button>
    </form>

    <?php include 'editar-perfil.php'; ?>
    <?php include 'p-formulario-perfil.php'; ?>
</body>
</html>