<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_peticion = mysqli_real_escape_string($conexion, $_GET['id_peticion']);

$query = "UPDATE PeticionTrabajo SET estado = 'aceptada' WHERE id_peticion_trabajo = '$id_peticion'";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Petición aceptada exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al aceptar la petición: ' . mysqli_error($conexion)]);
}
?>