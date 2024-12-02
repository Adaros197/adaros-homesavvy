<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);

$query = "SELECT p.id_postulacion_servicio, p.descripcion, prof.nombre 
          FROM PostulacionServicio p
          JOIN Profesional prof ON p.id_profesional = prof.id_profesional
          WHERE p.id_solicitud_servicio = '$id_solicitud'";
$result = mysqli_query($conexion, $query);

if ($result) {
    $postulaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'postulaciones' => $postulaciones]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las postulaciones: ' . mysqli_error($conexion)]);
}
?>
