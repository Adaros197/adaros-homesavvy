<style>
    h3 {
        color: #3e93d6 !important;
    }

    .form-container form {
        transition: all 0.4s ease-in-out !important;
        opacity: 0;
        max-height: 0;
        overflow: hidden;
    }

    .form-container form.show {
        opacity: 1;
        max-height: 1000px;
    }

    .btn-link {
        position: relative;
        text-decoration: none !important;
    }

    .btn-link::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 2px;
        background-color: #3e93d6;
        transition: all 0.3s ease-in-out;
        transform: translateX(-50%);
    }

    .btn-link:hover::after {
        width: 100%;
        left: 0;
        transform: translateX(0);
    }

    .guardar{
        background-color: #3e93d6;
        color: #fff;
        border-radius: 20px !important;
        padding: 5px 20px 5px 20px; 
    }

    .guardar:hover{
        background-color:#1f79be;
        color: #fff;
        transition: .5s;
        
    }

    .cerrar{
        background-color: #3e93d6 !important;
    }
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }

    .editar{
        color: #3e93d6 !important;
    }


</style>


<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0 rounded-4 p-4" style="font-family: nexa;">
        <h3 class="mb-4 fw-bold">Información Personal</h3>

        <!-- Información Básica -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <div>
                <p class="mb-1"><strong>Nombre:</strong> <?php echo $user['nombre']; ?></p>
                <p class="mb-1"><strong>Apellido Paterno:</strong> <?php echo $user['apellido_p']; ?></p>
                <p class="mb-1"><strong>Apellido Materno:</strong> <?php echo $user['apellido_m']; ?></p>
            </div>
            <button class="btn btn-link fw-bold editar" onclick="toggleEdit('editBasico')">Editar</button>
        </div>

        <div class="form-container">
            <form id="editBasico" class="mb-4" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="formulario" value="basico">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="nombre" class="form-control" value="<?php echo $user['nombre']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="apellido_p" class="form-control" value="<?php echo $user['apellido_p']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="apellido_m" class="form-control" value="<?php echo $user['apellido_m']; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="foto_perfil" class="form-label">Foto de Perfil:</label>
                    <input type="file" name="foto_perfil" class="form-control" accept="image/*">
                </div>
                <?php if (!empty($user['foto_perfil'])): ?>
                    <div class="mb-3">
                        <img src="../<?php echo $user['foto_perfil']; ?>" alt="Foto de perfil" class="img-thumbnail" style="max-width: 150px;">
                    </div>
                <?php endif; ?>
                <button class="btn btn-sm rounded-pill guardar">Guardar</button>
            </form>
        </div>

        <!-- Contacto -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mt-4 mb-3">
            <div>
                <p class="mb-1"><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p class="mb-1"><strong>Teléfono:</strong> <?php echo $user['numero']; ?></p>
                <p class="mb-1"><strong>Dirección:</strong> <?php echo $user['direccion']; ?></p>
            </div>
            <button class="btn btn-link text-primary fw-bold editar" onclick="toggleEdit('editContacto')">Editar</button>
        </div>

        <div class="form-container">
            <form id="editContacto" class="mb-4" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="formulario" value="contacto">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="tel" name="numero" class="form-control" value="<?php echo $user['numero']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="direccion" class="form-control" value="<?php echo $user['direccion']; ?>" required>
                    </div>
                </div>
                <button class="btn btn-sm guardar">Guardar</button>
            </form>
        </div>

        <!-- Contraseña -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mt-4 mb-3">
            <div>
                <p class="mb-1"><strong>Contraseña:</strong> ************</p>
            </div>
            <button class="btn btn-link text-primary fw-bold editar" onclick="toggleEdit('editPassword')">Editar</button>
        </div>

        <div class="form-container">
            <form id="editPassword" class="mb-4" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="formulario" value="password">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Nueva contraseña">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="password" name="confirmar_password" class="form-control" placeholder="Confirmar contraseña">
                    </div>
                </div>
                <button class="btn btn-sm rounded-pill guardar">Guardar</button>
            </form>
        </div>

        <!-- Eliminar cuenta -->
        <!-- Eliminar cuenta -->
<div class="mt-4 text-center">
  <button type="button" class="btn btn-outline-danger rounded-pill" data-toggle="modal" data-target="#deleteModal">
      Eliminar Cuenta
  </button>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form action="delete-account.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirmación de Eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Eliminar Cuenta</button>
      </div>
    </form>
  </div>
</div>

    </div>
</div>

<script>
function toggleEdit(id) {
    const form = document.getElementById(id);
    if (form.classList.contains('show')) {
        form.classList.remove('show');
        setTimeout(() => {
            form.classList.add('d-none');
        }, 400);
    } else {
        form.classList.remove('d-none');
        setTimeout(() => {
            form.classList.add('show');
        }, 10);
    }
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

