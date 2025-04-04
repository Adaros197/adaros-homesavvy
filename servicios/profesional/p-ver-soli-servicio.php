<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$estado = isset($_GET['estado']) && $_GET['estado'] !== "todas" ? mysqli_real_escape_string($conexion, $_GET['estado']) : null;

// Consultar solicitudes de servicio
$query = "SELECT id_solicitud_servicio, titulo, descripcion, foto, horarios, metodo_pago, estado 
          FROM SolicitudServicio";
if ($estado) {
    $query .= " WHERE estado = '$estado'";
}
$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las solicitudes: ' . mysqli_error($conexion)]);
}
?>
