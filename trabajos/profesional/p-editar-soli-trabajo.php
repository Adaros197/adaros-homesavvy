<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

// Verificar autenticación
if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$profesional_id = $_SESSION['profesional_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitud = mysqli_real_escape_string($conexion, $_POST['id_solicitud']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $tarifa = mysqli_real_escape_string($conexion, $_POST['tarifa']);

    // Procesar nueva foto si se subió
    if (!empty($_FILES['foto']['name'])) {
        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $ruta_foto = "uploads/trabajos/$id_solicitud.$extension";
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], "../../$ruta_foto")) {
            die(json_encode(['error' => 'Error al mover el archivo de foto']));
        }

        // Actualizar la foto en la base de datos
        $query = "UPDATE SolicitudTrabajo SET foto = '$ruta_foto' WHERE id_solicitud_trabajo = '$id_solicitud' AND id_profesional = '$profesional_id'";
        mysqli_query($conexion, $query);
    }

    // Actualizar campos restantes
    $query = "UPDATE SolicitudTrabajo 
              SET titulo = '$titulo', descripcion = '$descripcion', categoria = '$categoria', tarifa = '$tarifa' 
              WHERE id_solicitud_trabajo = '$id_solicitud' AND id_profesional = '$profesional_id'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Solicitud actualizada con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la solicitud: ' . mysqli_error($conexion)]);
    }
}
?>