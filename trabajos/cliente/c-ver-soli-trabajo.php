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
$categoria = isset($_GET['categoria']) && $_GET['categoria'] !== "todas"
    ? mysqli_real_escape_string($conexion, $_GET['categoria'])
    : null;

// Construir consulta principal
$query = "SELECT st.id_solicitud_trabajo, st.titulo, st.descripcion, st.categoria, st.tarifa, st.foto, st.fecha_creacion,
                 p.nombre AS nombre_usuario, p.foto_perfil
          FROM SolicitudTrabajo st
          JOIN Profesional p ON st.id_profesional = p.id_profesional
          WHERE st.estado = 'activa' 
            AND st.id_solicitud_trabajo NOT IN (
                SELECT id_solicitud_trabajo 
                FROM PeticionTrabajo 
                WHERE id_cliente = '$cliente_id'
            )";


if ($categoria) {
    $query .= " AND st.categoria = '$categoria'";
}

$query .= " ORDER BY st.fecha_creacion DESC";

$result = mysqli_query($conexion, $query);

if ($result) {
    $solicitudes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'solicitudes' => $solicitudes]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al obtener las solicitudes: ' . mysqli_error($conexion)]);
}
?>
