<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-postulaciones.php");
    exit;
}

$id_postulacion_servicio = $_GET['id'];
$query = "DELETE FROM PostulacionServicio WHERE id_postulacion_servicio = '$id_postulacion_servicio'";
mysqli_query($conexion, $query);

header("Location: a-ver-postulaciones.php");
exit;
?>