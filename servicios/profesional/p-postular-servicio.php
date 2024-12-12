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
$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);

// Insertar postulación
$query = "INSERT INTO PostulacionServicio (id_solicitud_servicio, id_profesional, estado, fecha_postulacion) 
          VALUES ('$id_solicitud', '$profesional_id', 'pendiente', NOW())";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Postulación realizada con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al postularse: ' . mysqli_error($conexion)]);
}
?>
