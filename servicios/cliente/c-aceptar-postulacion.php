<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

$id_postulacion = mysqli_real_escape_string($conexion, $_GET['id_postulacion']);

$query = "UPDATE PostulacionServicio SET estado = 'aceptada' WHERE id_postulacion_servicio = '$id_postulacion'";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Postulación aceptada exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al aceptar la postulación: ' . mysqli_error($conexion)]);
}
?>
