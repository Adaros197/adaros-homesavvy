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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $horarios = mysqli_real_escape_string($conexion, $_POST['horarios']);
    $metodo_pago = mysqli_real_escape_string($conexion, $_POST['metodo_pago']);

    // Procesar la foto si se cargó
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = "uploads/servicios/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../" . $foto);
    }

    // Insertar la solicitud en la base de datos
    $query = "INSERT INTO SolicitudServicio (id_cliente, titulo, descripcion, foto, horarios, metodo_pago, estado)
              VALUES ('$cliente_id', '$titulo', '$descripcion', '$foto', '$horarios', '$metodo_pago', 'pendiente')";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Solicitud de servicio subida con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la solicitud: ' . mysqli_error($conexion)]);
    }
}
?>