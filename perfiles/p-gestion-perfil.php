<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfil - Profesional</title>
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
    <?php include '../includes/navbar-profesional.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #a2a2f4;">Gestión de Perfil - Profesional</h1>
        <form action="../auth/logout.php" method="POST">
            <button type="submit" class="btn btn-secondary" style="font-family: nexa;">Cerrar Sesión</button>
        </form>
        <?php include 'editar-perfil.php'; ?>
        <?php include 'p-formulario-perfil.php'; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../includes/footer-profesional.php'; ?>
</body>
</html>