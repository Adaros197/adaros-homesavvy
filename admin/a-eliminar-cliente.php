<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: a-ver-clientes.php");
    exit;
}

$id_cliente = $_GET['id'];
$query = "DELETE FROM Cliente WHERE id_cliente = '$id_cliente'";
mysqli_query($conexion, $query);

header("Location: a-ver-clientes.php");
exit;
?>