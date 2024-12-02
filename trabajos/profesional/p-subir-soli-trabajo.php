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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $tarifa = mysqli_real_escape_string($conexion, $_POST['tarifa']);

    // Procesar la foto si se cargó
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = "uploads/trabajos/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../" . $foto);
    }

    // Insertar la solicitud en la base de datos
    $query = "INSERT INTO SolicitudTrabajo (id_profesional, titulo, descripcion, categoria, tarifa, foto, estado, fecha_creacion)
              VALUES ('$profesional_id', '$titulo', '$descripcion', '$categoria', '$tarifa', '$foto', 'pendiente', NOW())";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Solicitud de trabajo subida con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la solicitud: ' . mysqli_error($conexion)]);
    }
}
?>