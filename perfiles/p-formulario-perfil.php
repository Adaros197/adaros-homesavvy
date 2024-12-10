<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" id="gestion-perfil-form" class="container mt-5" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label" style="font-family: nexa;">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo isset($user['nombre']) ? $user['nombre'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="apellido_p" class="form-label" style="font-family: nexa;">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" class="form-control" value="<?php echo isset($user['apellido_p']) ? $user['apellido_p'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="apellido_m" class="form-label" style="font-family: nexa;">Apellido Materno:</label>
        <input type="text" id="apellido_m" name="apellido_m" class="form-control" value="<?php echo isset($user['apellido_m']) ? $user['apellido_m'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label" style="font-family: nexa;">Correo Electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label" style="font-family: nexa;">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su nueva contraseña">
    </div>
    <div class="mb-3">
        <label for="numero" class="form-label" style="font-family: nexa;">Número de Teléfono:</label>
        <input type="tel" id="numero" name="numero" class="form-control" value="<?php echo isset($user['numero']) ? $user['numero'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label" style="font-family: nexa;">Dirección:</label>
        <textarea id="direccion" name="direccion" class="form-control" required><?php echo isset($user['direccion']) ? $user['direccion'] : ''; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="profesion" class="form-label" style="font-family: nexa;">Profesión:</label>
        <input type="text" id="profesion" name="profesion" class="form-control" value="<?php echo isset($user['profesion']) ? $user['profesion'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="rfc" class="form-label" style="font-family: nexa;">RFC:</label>
        <input type="text" id="rfc" name="rfc" class="form-control" value="<?php echo isset($user['rfc']) ? $user['rfc'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="foto_perfil" class="form-label" style="font-family: nexa;">Foto de Perfil (opcional):</label>
        <input type="file" id="foto_perfil" name="foto_perfil" class="form-control" accept="image/*">
    </div>
    <?php if ($user['foto_perfil']): ?>
        <div class="mb-3">
            <p style="font-family: nexa;">Foto actual:</p>
            <img src="../<?php echo $user['foto_perfil']; ?>" alt="Foto de perfil" style="max-width: 200px;">
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary" style="background-color: #a2a2f4; border-color: #a2a2f4; font-family: nexa;">Actualizar Perfil</button>
</form>
<form action="delete-account.php" method="POST" class="container mt-3">
    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')" style="font-family: nexa;">Eliminar Cuenta</button>
</form>