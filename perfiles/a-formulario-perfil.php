<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" id="gestion-perfil-form">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo isset($admin['nombre']) ? $admin['nombre'] : ''; ?>" required>
    <br><br>
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($admin['email']) ? $admin['email'] : ''; ?>" required>
    <br><br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" placeholder="Ingrese su nueva contraseña">
    <br><br>
    <button type="submit">Actualizar Perfil</button>
</form>
<form action="delete-account.php" method="POST">
    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')">Eliminar Cuenta</button>
</form>