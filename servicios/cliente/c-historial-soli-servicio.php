<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

// Validar si el cliente está autenticado
if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// Obtener las solicitudes del cliente
$query = "SELECT id_solicitud_servicio, titulo, descripcion, foto, horarios, metodo_pago, estado 
          FROM SolicitudServicio 
          WHERE id_cliente = '$cliente_id'";
$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener el historial: ' . mysqli_error($conexion)]);
}
?>
