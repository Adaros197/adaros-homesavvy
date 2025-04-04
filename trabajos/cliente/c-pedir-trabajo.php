<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);

// Insertar petición de trabajo
$query = "INSERT INTO PeticionTrabajo (id_solicitud_trabajo, id_cliente, estado, fecha_peticion) 
          VALUES ('$id_solicitud', '$cliente_id', 'pendiente', NOW())";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Petición de trabajo realizada con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al pedir el trabajo: ' . mysqli_error($conexion)]);
}
?>
