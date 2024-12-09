<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

// Verificar autenticación
if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);
$cliente_id = $_SESSION['cliente_id'];

// Eliminar la solicitud si pertenece al cliente autenticado
$query = "DELETE FROM SolicitudServicio WHERE id_solicitud_servicio = '$id_solicitud' AND id_cliente = '$cliente_id'";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Solicitud eliminada con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la solicitud: ' . mysqli_error($conexion)]);
}
?>
