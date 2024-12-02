<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud de Servicio</title>
</head>
<body>
    <h1>Editar Solicitud de Servicio</h1>

    <?php
    session_start();
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

    <form action="c-editar-soli-servicio-procesar.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_solicitud" value="<?php echo $solicitud['id_solicitud_servicio']; ?>">

        <label for="titulo">Título del Servicio:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $solicitud['titulo']; ?>" required>
        <br><br>

        <label for="descripcion">Descripción del Servicio:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $solicitud['descripcion']; ?></textarea>
        <br><br>

        <label for="foto">Fotografía (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <br><br>
        <?php if ($solicitud['foto']): ?>
            <p>Foto actual:</p>
            <img src="../<?php echo $solicitud['foto']; ?>" alt="Foto del servicio" style="max-width: 200px;">
        <?php endif; ?>
        <br><br>

        <label for="horarios">Horarios Preferidos:</label>
        <input type="text" id="horarios" name="horarios" value="<?php echo $solicitud['horarios']; ?>" required>
        <br><br>

        <label for="metodo_pago">Método de Pago:</label>
        <select id="metodo_pago" name="metodo_pago" required>
            <option value="efectivo" <?php echo $solicitud['metodo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
            <option value="tarjeta" <?php echo $solicitud['metodo_pago'] == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta de Crédito/Débito</option>
            <option value="transferencia" <?php echo $solicitud['metodo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia Bancaria</option>
        </select>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
