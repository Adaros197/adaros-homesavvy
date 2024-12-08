<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!$conexion) {
    error_log("Error de conexión a la base de datos");
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

error_log("Conexión a la base de datos exitosa");

if (!isset($_SESSION['cliente_id'])) {
    error_log("Usuario no autenticado");
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

error_log("Usuario autenticado: " . $_SESSION['cliente_id']);

if (!isset($_GET['id_solicitud']) || empty($_GET['id_solicitud'])) {
    error_log("ID de solicitud no proporcionado");
    echo json_encode(['success' => false, 'message' => 'ID de solicitud no proporcionado']);
    exit;
}

$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);
error_log("ID de solicitud: " . $id_solicitud);

$query = "SELECT p.id_postulacion_servicio, p.estado, p.fecha_postulacion, prof.nombre 
          FROM PostulacionServicio p
          JOIN Profesional prof ON p.id_profesional = prof.id_profesional
          WHERE p.id_solicitud_servicio = '$id_solicitud'";

error_log("Consulta SQL: " . $query);

$result = mysqli_query($conexion, $query);

if ($result) {
    error_log("Consulta SQL ejecutada correctamente");
    $postulaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);
    error_log("Número de postulaciones encontradas: " . count($postulaciones));
    echo json_encode(['success' => true, 'postulaciones' => $postulaciones]);
} else {
    $error_message = mysqli_error($conexion);
    error_log("Error al obtener las postulaciones: " . $error_message);
    echo json_encode(['success' => false, 'message' => 'Error al obtener las postulaciones: ' . $error_message]);
}
?>