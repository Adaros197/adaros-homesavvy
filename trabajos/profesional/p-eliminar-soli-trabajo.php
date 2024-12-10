<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);
$profesional_id = $_SESSION['profesional_id'];

// Eliminar la solicitud si pertenece al profesional autenticado
$query = "DELETE FROM SolicitudTrabajo WHERE id_solicitud_trabajo = '$id_solicitud' AND id_profesional = '$profesional_id'";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Solicitud eliminada con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la solicitud: ' . mysqli_error($conexion)]);
}
?>
