<?php
session_start();
require("../conexion.php");
$conexion = retornarConexion();

if (isset($_SESSION['admin_id'])) {
    $id = $_SESSION['admin_id'];
    $query = "DELETE FROM Admin WHERE id_admin = '$id'";
    mysqli_query($conexion, $query);
    session_destroy();
    header("Location: ../index.php");
    exit;
} elseif (isset($_SESSION['profesional_id'])) {
    $id = $_SESSION['profesional_id'];
    $query = "DELETE FROM Profesional WHERE id_profesional = '$id'";
    mysqli_query($conexion, $query);
    session_destroy();
    header("Location: ../index.php");
    exit;
} elseif (isset($_SESSION['cliente_id'])) {
    $id = $_SESSION['cliente_id'];
    $query = "DELETE FROM Cliente WHERE id_cliente = '$id'";
    mysqli_query($conexion, $query);
    session_destroy();
    header("Location: ../index.html");
    exit;
} else {
    echo "Error: No se pudo eliminar la cuenta.";
}
?>