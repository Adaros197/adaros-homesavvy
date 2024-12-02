<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Solicitud de Trabajo</title>
</head>
<body>
    <?php include '../../includes/navbar-profesional.php'; ?>
    <h1>Subir Solicitud de Trabajo</h1>

    <form action="p-subir-soli-trabajo.php" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título del Trabajo:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ingrese el título del trabajo" required>
        <br><br>

        <label for="descripcion">Descripción del Trabajo:</label>
        <textarea id="descripcion" name="descripcion" placeholder="Describa el trabajo que ofrece" required></textarea>
        <br><br>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="electricidad">Electricidad</option>
            <option value="plomería">Plomería</option>
            <option value="carpintería">Carpintería</option>
            <option value="limpieza">Limpieza</option>
        </select>
        <br><br>

        <label for="tarifa">Tarifa:</label>
        <input type="number" id="tarifa" name="tarifa" placeholder="Ingrese la tarifa del trabajo" required>
        <br><br>

        <label for="foto">Fotografía (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <br><br>

        <button type="submit">Subir Solicitud</button>
    </form>
</body>
</html>