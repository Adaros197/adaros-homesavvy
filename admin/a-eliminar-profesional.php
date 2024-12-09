<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-profesionales.php");
    exit;
}

$id_profesional = $_GET['id'];
$query = "DELETE FROM Profesional WHERE id_profesional = '$id_profesional'";
mysqli_query($conexion, $query);

header("Location: a-ver-profesionales.php");
exit;
?>