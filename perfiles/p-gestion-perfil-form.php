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
    
    <form action="p-gestion-perfil.php" method="POST" id="gestion-profesional-form">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
        <br><br>

        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" placeholder="Ingrese su apellido paterno" required>
        <br><br>

        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m" placeholder="Ingrese su apellido materno" required>
        <br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" placeholder="Ingrese su correo" required>
        <br><br>

        <label for="numero">Número de Teléfono:</label>
        <input type="tel" id="numero" name="numero" placeholder="Ingrese su número" required>
        <br><br>

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" placeholder="Ingrese su dirección" required></textarea>
        <br><br>

        <label for="profesion">Profesión:</label>
        <input type="text" id="profesion" name="profesion" placeholder="Ingrese su profesión" required>
        <br><br>

        <label for="rfc">RFC:</label>
        <input type="text" id="rfc" name="rfc" placeholder="Ingrese su RFC" required>
        <br><br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>