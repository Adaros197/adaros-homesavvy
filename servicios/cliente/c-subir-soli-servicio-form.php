<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Solicitud de Servicio - Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: nexa;
            src: url('../../assets/fonts/title.ttf');
        }
        body {
            font-family: nexa;
        }
    </style>
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #3e93d6;">Subir Solicitud de Servicio</h1>
        <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label" style="font-family: nexa;">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label" style="font-family: nexa;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label" style="font-family: nexa;">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label" style="font-family: nexa;">Foto (opcional):</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="horarios" class="form-label" style="font-family: nexa;">Horarios Preferidos:</label>
                <input type="text" id="horarios" name="horarios" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label" style="font-family: nexa;">Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #3e93d6; border-color: #3e93d6; font-family: nexa;">Subir Solicitud</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>