<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud de Servicio - Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: nexa;
            src: url('../../assets/fonts/title.ttf');
        }

        body {
            font-family: nexa;
            background-color:#e2f2ff !important;
        }

        .card-form {
            border-radius: 20px !important;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: none;
            background-color: white;
        }

        .card-form h1 {
            font-weight: bold;
            color: #3e93d6;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-label {
            font-weight: bold;
            color: #3e93d6;
        }

        .btn-primary {
            background-color: #3e93d6 !important;
            border-color: #3e93d6 !important;
            border-radius: 20px !important;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #3278a7 !important;
            border-color: #3278a7 !important;
        }
    </style>

    <link rel="stylesheet" href="../../includes/footer-styles.css">
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="card card-form mx-auto" style="max-width: 700px;">
            <h1>Editar Solicitud de Servicio</h1>

            <?php
            require("../../conexion.php");
            $conexion = retornarConexion();

            if (!isset($_SESSION['cliente_id'])) {
                echo "<p>Usuario no autenticado. Por favor, inicia sesión.</p>";
                exit;
            }

            if (!isset($_GET['id_solicitud'])) {
                echo "<p>Solicitud no especificada.</p>";
                exit;
            }

            $id_solicitud = $_GET['id_solicitud'];
            $cliente_id = $_SESSION['cliente_id'];

            $query = "SELECT * FROM SolicitudServicio WHERE id_solicitud_servicio = '$id_solicitud' AND id_cliente = '$cliente_id'";
            $result = mysqli_query($conexion, $query);
            $solicitud = mysqli_fetch_assoc($result);

            if (!$solicitud) {
                echo "<p>Solicitud no encontrada o no pertenece al usuario.</p>";
                exit;
            }
            ?>

        <form id="form-editar-solicitud" enctype="multipart/form-data">

            <input type="hidden" name="id_solicitud" value="<?php echo $id_solicitud; ?>">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo $solicitud['titulo']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required><?php echo $solicitud['descripcion']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $solicitud['categoria']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (opcional):</label>
                    <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                    <?php if ($solicitud['foto']): ?>
                        <div class="mt-3 text-center">
                            <p class="form-label">Foto actual:</p>
                            <img src="../../<?php echo $solicitud['foto']; ?>" alt="Foto del servicio" style="max-width: 200px; border-radius: 10px;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="horarios" class="form-label">Horarios Preferidos:</label>
                    <input type="text" id="horarios" name="horarios" class="form-control" value="<?php echo $solicitud['horarios']; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="metodo_pago" class="form-label">Método de Pago:</label>
                    <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                        <option value="efectivo" <?php echo $solicitud['metodo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                        <option value="tarjeta" <?php echo $solicitud['metodo_pago'] == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta de Crédito/Débito</option>
                        <option value="transferencia" <?php echo $solicitud['metodo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia Bancaria</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar Solicitud</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("form-editar-solicitud").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("c-editar-soli-servicio.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Solicitud actualizada!',
                text: data.message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });

            setTimeout(() => {
                window.location.href = "c-historial-soli-servicio-form.php";
            }, 2500);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ups...',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar la solicitud.'
        });
    });
});
</script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../../includes/footer-cliente.php'; ?>
</body>
</html>
