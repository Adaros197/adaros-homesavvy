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

    // Insertar la solicitud en la base de datos
    $query = "INSERT INTO SolicitudTrabajo (id_profesional, titulo, descripcion, categoria, tarifa) 
              VALUES ('$profesional_id', '$titulo', '$descripcion', '$categoria', '$tarifa')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $id_solicitud = mysqli_insert_id($conexion); // Obtener el ID del trabajo insertado

        // Crear directorio si no existe
        if (!is_dir("../../uploads/trabajos")) {
            mkdir("../../uploads/trabajos", 0777, true);
        }

        // Guardar la imagen con el ID del trabajo seguido de la extensión original
        if (!empty($_FILES['foto']['name'])) {
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $ruta_foto = "uploads/trabajos/$id_solicitud.$extension";
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], "../../$ruta_foto")) {
                die(json_encode(['error' => 'Error al mover el archivo de foto']));
            }

            // Actualizar la ruta de la foto en la base de datos
            $query = "UPDATE SolicitudTrabajo SET foto = '$ruta_foto' WHERE id_solicitud_trabajo = '$id_solicitud'";
            mysqli_query($conexion, $query);
        }

        echo json_encode(['success' => true, 'message' => 'Solicitud de trabajo subida con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la solicitud de trabajo: ' . mysqli_error($conexion)]);
    }
}
?>