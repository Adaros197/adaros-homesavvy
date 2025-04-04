<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-servicios.php");
    exit;
}

$id_solicitud_servicio = $_GET['id'];
$query = "DELETE FROM SolicitudServicio WHERE id_solicitud_servicio = '$id_solicitud_servicio'";
mysqli_query($conexion, $query);

header("Location: a-ver-servicios.php");
exit;
?>