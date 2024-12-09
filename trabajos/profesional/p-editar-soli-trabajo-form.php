<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud de Trabajo</title>
</head>
<body>
    <h1>Editar Solicitud de Trabajo</h1>

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

    <form action="p-editar-soli-trabajo.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_solicitud" value="<?php echo $solicitud['id_solicitud_trabajo']; ?>">

        <label for="titulo">Título del Trabajo:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $solicitud['titulo']; ?>" required>
        <br><br>

        <label for="descripcion">Descripción del Trabajo:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $solicitud['descripcion']; ?></textarea>
        <br><br>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="electricidad" <?php echo $solicitud['categoria'] == 'electricidad' ? 'selected' : ''; ?>>Electricidad</option>
            <option value="plomería" <?php echo $solicitud['categoria'] == 'plomería' ? 'selected' : ''; ?>>Plomería</option>
            <option value="carpintería" <?php echo $solicitud['categoria'] == 'carpintería' ? 'selected' : ''; ?>>Carpintería</option>
            <option value="limpieza" <?php echo $solicitud['categoria'] == 'limpieza' ? 'selected' : ''; ?>>Limpieza</option>
        </select>
        <br><br>

        <label for="tarifa">Tarifa:</label>
        <input type="number" id="tarifa" name="tarifa" value="<?php echo $solicitud['tarifa']; ?>" required>
        <br><br>

        <label for="foto">Fotografía (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <br><br>
        <?php if ($solicitud['foto']): ?>
            <p>Foto actual:</p>
            <img src="../../<?php echo $solicitud['foto']; ?>" alt="Foto del trabajo" style="max-width: 200px;">
        <?php endif; ?>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
