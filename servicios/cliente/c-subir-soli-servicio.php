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

    // Insertar la solicitud en la base de datos
    $query = "INSERT INTO SolicitudServicio (id_cliente, titulo, descripcion, horarios, metodo_pago) 
              VALUES ('$cliente_id', '$titulo', '$descripcion', '$horarios', '$metodo_pago')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $id_solicitud = mysqli_insert_id($conexion); // Obtener el ID del servicio insertado

        // Crear directorio si no existe
        if (!is_dir("../../uploads/servicios")) {
            mkdir("../../uploads/servicios", 0777, true);
        }

        // Guardar la imagen con el ID del servicio seguido de la extensión original
        if (!empty($_FILES['foto']['name'])) {
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $ruta_foto = "uploads/servicios/$id_solicitud.$extension";
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], "../../$ruta_foto")) {
                die(json_encode(['error' => 'Error al mover el archivo de foto']));
            }

            // Actualizar la ruta de la foto en la base de datos
            $query = "UPDATE SolicitudServicio SET foto = '$ruta_foto' WHERE id_solicitud_servicio = '$id_solicitud'";
            mysqli_query($conexion, $query);
        }

        echo json_encode(['success' => true, 'message' => 'Solicitud de servicio subida con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la solicitud de servicio: ' . mysqli_error($conexion)]);
    }
}
?>