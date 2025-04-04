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
$query = "DELETE FROM SolicitudTrabajo WHERE id_solicitud_trabajo = '$id_solicitud_trabajo'";
mysqli_query($conexion, $query);

header("Location: a-ver-trabajos.php");
exit;
?>