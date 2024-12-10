<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" id="gestion-perfil-form" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo isset($user['nombre']) ? $user['nombre'] : ''; ?>" required>
    <br><br>

    <label for="apellido_p">Apellido Paterno:</label>
    <input type="text" id="apellido_p" name="apellido_p" value="<?php echo isset($user['apellido_p']) ? $user['apellido_p'] : ''; ?>" required>
    <br><br>

    <label for="apellido_m">Apellido Materno:</label>
    <input type="text" id="apellido_m" name="apellido_m" value="<?php echo isset($user['apellido_m']) ? $user['apellido_m'] : ''; ?>" required>
    <br><br>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
    <br><br>

    // para contraseña
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" placeholder="Ingrese su nueva contraseña">

    <label for="numero">Número de Teléfono:</label>
    <input type="tel" id="numero" name="numero" value="<?php echo isset($user['numero']) ? $user['numero'] : ''; ?>" required>
    <br><br>

    <label for="direccion">Dirección:</label>
    <textarea id="direccion" name="direccion" required><?php echo isset($user['direccion']) ? $user['direccion'] : ''; ?></textarea>
    <br><br>

    <label for="profesion">Profesión:</label>
    <input type="text" id="profesion" name="profesion" value="<?php echo isset($user['profesion']) ? $user['profesion'] : ''; ?>" required>
    <br><br>

    <label for="rfc">RFC:</label>
    <input type="text" id="rfc" name="rfc" value="<?php echo isset($user['rfc']) ? $user['rfc'] : ''; ?>" required>
    <br><br>

    <label for="foto_perfil">Foto de Perfil (opcional):</label>
    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
    <br><br>
    <?php if ($user['foto_perfil']): ?>
        <p>Foto actual:</p>
        <img src="../<?php echo $user['foto_perfil']; ?>" alt="Foto de perfil" style="max-width: 200px;">
    <?php endif; ?>
    <br><br>

    <button type="submit">Actualizar Perfil</button>
</form>

<form action="delete-account.php" method="POST">
    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')">Eliminar Cuenta</button>
</form>