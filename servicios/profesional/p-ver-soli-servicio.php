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
$estado = isset($_GET['estado']) && $_GET['estado'] !== "todas" ? mysqli_real_escape_string($conexion, $_GET['estado']) : null;

$query = "
    SELECT s.id_solicitud_servicio, s.titulo, s.descripcion, s.foto, s.horarios, s.metodo_pago, s.estado, s.categoria
    FROM SolicitudServicio s
    WHERE NOT EXISTS (
        SELECT 1 FROM PostulacionServicio p 
        WHERE p.id_solicitud_servicio = s.id_solicitud_servicio 
        AND p.id_profesional = '$profesional_id'
    )
";

if ($estado) {
    $query .= " AND s.estado = '$estado'";
}

$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las solicitudes: ' . mysqli_error($conexion)]);
}

?>
