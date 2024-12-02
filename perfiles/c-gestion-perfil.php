<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfil - Cliente</title>
</head>
<body>
    <h1>Gestión de Perfil - Cliente</h1>

    <?php
    session_start();
    require("../conexion.php");
    $conexion = retornarConexion();

    // Validar si el usuario está autenticado
    if (!isset($_SESSION['cliente_id'])) {
        echo "<p>Usuario no autenticado. Por favor, inicia sesión.</p>";
        exit;
    }

    $cliente_id = $_SESSION['cliente_id'];
    $query = "SELECT * FROM Cliente WHERE id_cliente = '$cliente_id'";
    $result = mysqli_query($conexion, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo "<p>Error al cargar los datos del cliente.</p>";
        exit;
    }
    ?>

    <form action="c-gestion-perfil.php" method="POST" id="gestion-cliente-form">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $user['nombre']; ?>" required>
        <br><br>

        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" value="<?php echo $user['apellido_p']; ?>" required>
        <br><br>

        <label for="apellido_m">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m" value="<?php echo $user['apellido_m']; ?>" required>
        <br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        <br><br>

        <label for="numero">Número de Teléfono:</label>
        <input type="tel" id="numero" name="numero" value="<?php echo $user['numero']; ?>" required>
        <br><br>

        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion" required><?php echo $user['direccion']; ?></textarea>
        <br><br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>