<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Solicitud de Servicio</title>
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>
    <h1>Subir Solicitud de Servicio</h1>

    <form action="c-subir-soli-servicio.php" method="POST" id="subir-solicitud-form" enctype="multipart/form-data">
        <label for="titulo">Título del Servicio:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ingrese el título del servicio" required>
        <br><br>

        <label for="descripcion">Descripción del Servicio:</label>
        <textarea id="descripcion" name="descripcion" placeholder="Describa el servicio que necesita" required></textarea>
        <br><br>

        <label for="foto">Fotografía (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <br><br>

        <label for="horarios">Horarios Preferidos:</label>
        <input type="text" id="horarios" name="horarios" placeholder="Indique sus horarios preferidos" required>
        <br><br>

        <label for="metodo_pago">Método de Pago:</label>
        <select id="metodo_pago" name="metodo_pago" required>
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta de Crédito/Débito</option>
            <option value="transferencia">Transferencia Bancaria</option>
        </select>
        <br><br>

        <button type="submit">Subir Solicitud</button>
    </form>
</body>
</html>