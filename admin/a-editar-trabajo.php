<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-trabajos.php");
    exit;
}

$id_solicitud_trabajo = $_GET['id'];
$query = "SELECT * FROM SolicitudTrabajo WHERE id_solicitud_trabajo = '$id_solicitud_trabajo'";
$result = mysqli_query($conexion, $query);
$trabajo = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $tarifa = $_POST['tarifa'];
    $estado = $_POST['estado'];

    $update_query = "UPDATE SolicitudTrabajo SET titulo='$titulo', descripcion='$descripcion', categoria='$categoria', tarifa='$tarifa', estado='$estado' WHERE id_solicitud_trabajo='$id_solicitud_trabajo'";
    mysqli_query($conexion, $update_query);

    header("Location: a-ver-trabajos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trabajo</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Trabajo</h1>
    <form action="" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= $trabajo['titulo'] ?>" required>
        <br><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?= $trabajo['descripcion'] ?></textarea>
        <br><br>
        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" value="<?= $trabajo['categoria'] ?>" required>
        <br><br>
        <label for="tarifa">Tarifa:</label>
        <input type="number" step="0.01" id="tarifa" name="tarifa" value="<?= $trabajo['tarifa'] ?>" required>
        <br><br>
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?= $trabajo['estado'] ?>" required>
        <br><br>
        <button type="submit">Actualizar Trabajo</button>
    </form>
</body>
</html>