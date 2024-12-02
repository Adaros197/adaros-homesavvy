<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$profesional_id = $_SESSION['profesional_id'];

// Consultar historial de solicitudes del profesional
$query = "SELECT id_solicitud_trabajo, titulo, descripcion, categoria, tarifa, estado 
          FROM SolicitudTrabajo 
          WHERE id_profesional = '$profesional_id'";
$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener el historial: ' . mysqli_error($conexion)]);
}
?>
