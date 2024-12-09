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
    $estado = $_POST['estado'];

    $update_query = "UPDATE PeticionTrabajo SET estado='$estado' WHERE id_peticion_trabajo='$id_peticion_trabajo'";
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
    <title>Editar Petición</title>
</head>
<body>
    <?php include '../includes/navbar-admin.php'; ?>
    <h1>Editar Petición</h1>
    <form action="" method="POST">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?= $peticion['estado'] ?>" required>
        <br><br>
        <button type="submit">Actualizar Petición</button>
    </form>
</body>
</html>