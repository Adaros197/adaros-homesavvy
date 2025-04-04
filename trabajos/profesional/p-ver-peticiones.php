<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_solicitud = mysqli_real_escape_string($conexion, $_GET['id_solicitud']);

$query = "SELECT p.id_peticion_trabajo, p.estado, p.fecha_peticion, c.nombre AS nombre_cliente 
          FROM PeticionTrabajo p
          JOIN Cliente c ON p.id_cliente = c.id_cliente
          WHERE p.id_solicitud_trabajo = '$id_solicitud'";
$result = mysqli_query($conexion, $query);

if ($result) {
    $peticiones = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'peticiones' => $peticiones]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las peticiones: ' . mysqli_error($conexion)]);
}
?>