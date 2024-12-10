<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud de Trabajo - Profesional</title>
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
    <?php include '../../includes/navbar-profesional.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #a2a2f4;">Editar Solicitud de Trabajo</h1>

    <?php
    session_start();
    require("../../conexion.php");

    $conexion = retornarConexion();

    // Verificar autenticación
    if (!isset($_SESSION['profesional_id'])) {
        echo "<p>Usuario no autenticado. Por favor, inicia sesión.</p>";
        exit;
    }

    // Obtener ID de la solicitud desde la URL
    if (!isset($_GET['id_solicitud'])) {
        echo "<p>Solicitud no especificada.</p>";
        exit;
    }

    $id_solicitud = $_GET['id_solicitud'];
    $profesional_id = $_SESSION['profesional_id'];

    // Consultar datos de la solicitud
    $query = "SELECT * FROM SolicitudTrabajo WHERE id_solicitud_trabajo = '$id_solicitud' AND id_profesional = '$profesional_id'";
    $result = mysqli_query($conexion, $query);
    $solicitud = mysqli_fetch_assoc($result);

    if (!$solicitud) {
        echo "<p>Solicitud no encontrada o no pertenece al usuario.</p>";
        exit;
    }
    ?>

        <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label" style="font-family: nexa;">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo $solicitud['titulo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label" style="font-family: nexa;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo $solicitud['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label" style="font-family: nexa;">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $solicitud['categoria']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label" style="font-family: nexa;">Foto (opcional):</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                <?php if ($solicitud['foto']): ?>
                    <div class="mt-3">
                        <p style="font-family: nexa;">Foto actual:</p>
                        <img src="../../<?php echo $solicitud['foto']; ?>" alt="Foto del trabajo" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="horarios" class="form-label" style="font-family: nexa;">Horarios Preferidos:</label>
                <input type="text" id="horarios" name="horarios" class="form-control" value="<?php echo $solicitud['horarios']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label" style="font-family: nexa;">Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                    <option value="efectivo" <?php echo $solicitud['metodo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                    <option value="tarjeta" <?php echo $solicitud['metodo_pago'] == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta de Crédito/Débito</option>
                    <option value="transferencia" <?php echo $solicitud['metodo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia Bancaria</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #a2a2f4; border-color: #a2a2f4; font-family: nexa;">Actualizar Solicitud</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
