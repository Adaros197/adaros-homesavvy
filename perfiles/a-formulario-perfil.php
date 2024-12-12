<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" id="gestion-perfil-form" class="container mt-5">
    <div class="mb-3">
        <label for="nombre" class="form-label" style="font-family: nexa;">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo isset($admin['nombre']) ? $admin['nombre'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label" style="font-family: nexa;">Correo Electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($admin['email']) ? $admin['email'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label" style="font-family: nexa;">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su nueva contraseña">
    </div>
    <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Perfil</button>
</form>
<form action="delete-account.php" method="POST" class="container mt-3">
    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')" style="font-family: nexa;">Eliminar Cuenta</button>
</form>