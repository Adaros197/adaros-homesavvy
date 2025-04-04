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
$query = "DELETE FROM PeticionTrabajo WHERE id_peticion_trabajo = '$id_peticion_trabajo'";
mysqli_query($conexion, $query);

header("Location: a-ver-peticiones.php");
exit;
?>