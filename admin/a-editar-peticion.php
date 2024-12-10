<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-peticiones.php");
    exit;
}

$id_peticion_trabajo = $_GET['id'];
$query = "SELECT pt.*, st.titulo AS trabajo_titulo, c.nombre AS cliente_nombre, p.nombre AS profesional_nombre 
          FROM PeticionTrabajo pt
          JOIN SolicitudTrabajo st ON pt.id_solicitud_trabajo = st.id_solicitud_trabajo
          JOIN Cliente c ON pt.id_cliente = c.id_cliente
          JOIN Profesional p ON st.id_profesional = p.id_profesional
          WHERE pt.id_peticion_trabajo = '$id_peticion_trabajo'";
$result = mysqli_query($conexion, $query);
$peticion = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    $update_query = "UPDATE PeticionTrabajo SET titulo='$titulo', descripcion='$descripcion', estado='$estado' WHERE id_peticion_trabajo='$id_peticion_trabajo'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-peticiones.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Petición - Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: nexa;
            src: url('../assets/fonts/title.ttf');
        }
        body {
            font-family: nexa;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #ec6cb2;">Editar Petición</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id_peticion_trabajo; ?>" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label" style="font-family: nexa;">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" value="<?= htmlspecialchars($peticion['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label" style="font-family: nexa;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?= htmlspecialchars($peticion['descripcion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label" style="font-family: nexa;">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" value="<?= htmlspecialchars($peticion['estado']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #ec6cb2; border-color: #ec6cb2; font-family: nexa;">Actualizar Petición</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>