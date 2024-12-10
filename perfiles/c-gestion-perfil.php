<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfil - Cliente</title>
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
</head>
<body>
    <?php include '../includes/navbar-cliente.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #3e93d6;">Gestión de Perfil - Cliente</h1>
        <form action="../auth/logout.php" method="POST">
            <button type="submit" class="btn btn-secondary" style="font-family: nexa;">Cerrar Sesión</button>
        </form>
        <?php include 'editar-perfil.php'; ?>
        <?php include 'c-formulario-perfil.php'; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>