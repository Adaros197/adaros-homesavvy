<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$categoria = isset($_GET['categoria']) && $_GET['categoria'] !== "todas" ? mysqli_real_escape_string($conexion, $_GET['categoria']) : null;

// Consultar solicitudes de trabajo
$query = "SELECT id_solicitud_trabajo, titulo, descripcion, categoria, tarifa, foto 
          FROM SolicitudTrabajo";
if ($categoria) {
    $query .= " WHERE categoria = '$categoria'";
}
$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las solicitudes: ' . mysqli_error($conexion)]);
}
?>
