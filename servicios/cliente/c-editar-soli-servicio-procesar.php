<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

// Verificar autenticación
if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitud = mysqli_real_escape_string($conexion, $_POST['id_solicitud']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $horarios = mysqli_real_escape_string($conexion, $_POST['horarios']);
    $metodo_pago = mysqli_real_escape_string($conexion, $_POST['metodo_pago']);

    // Procesar nueva foto si se subió
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = "uploads/servicios/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../" . $foto);

        // Actualizar foto en la base de datos
        $query = "UPDATE SolicitudServicio SET foto = '$foto' WHERE id_solicitud_servicio = '$id_solicitud' AND id_cliente = '$cliente_id'";
        mysqli_query($conexion, $query);
    }

    // Actualizar campos restantes
    $query = "UPDATE SolicitudServicio 
              SET titulo = '$titulo', descripcion = '$descripcion', horarios = '$horarios', metodo_pago = '$metodo_pago' 
              WHERE id_solicitud_servicio = '$id_solicitud' AND id_cliente = '$cliente_id'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Solicitud actualizada con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la solicitud: ' . mysqli_error($conexion)]);
    }
}
?>
