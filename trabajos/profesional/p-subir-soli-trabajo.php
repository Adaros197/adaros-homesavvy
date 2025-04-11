<?php
session_start();
header('Content-Type: application/json');
require("../../conexion.php");

$conexion = retornarConexion();

// Validar si el profesional está autenticado
if (!isset($_SESSION['profesional_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$profesional_id = $_SESSION['profesional_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar entradas
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo'] ?? '');
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion'] ?? '');
    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria'] ?? '');
    $tarifa = mysqli_real_escape_string($conexion, $_POST['tarifa'] ?? '');
    $horarios = mysqli_real_escape_string($conexion, $_POST['horarios'] ?? '');
    $metodo_pago = mysqli_real_escape_string($conexion, $_POST['metodo_pago'] ?? '');

    // Validar campos obligatorios
    if (!$titulo || !$descripcion || !$categoria || !$tarifa || !$horarios || !$metodo_pago) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Insertar la solicitud
    $query = "INSERT INTO SolicitudTrabajo (id_profesional, titulo, descripcion, categoria, tarifa, horarios, metodo_pago) 
              VALUES ('$profesional_id', '$titulo', '$descripcion', '$categoria', '$tarifa', '$horarios', '$metodo_pago')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $id_solicitud = mysqli_insert_id($conexion);

        // Crear directorio si no existe
        if (!is_dir("../../uploads/trabajos")) {
            mkdir("../../uploads/trabajos", 0777, true);
        }

        // Si hay imagen, guardarla
        if (!empty($_FILES['foto']['name'])) {
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $ruta_foto = "uploads/trabajos/$id_solicitud.$extension";

            if (move_uploaded_file($_FILES['foto']['tmp_name'], "../../$ruta_foto")) {
                $update = "UPDATE SolicitudTrabajo SET foto = '$ruta_foto' WHERE id_solicitud_trabajo = '$id_solicitud'";
                mysqli_query($conexion, $update);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Solicitud de trabajo subida con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir la solicitud: ' . mysqli_error($conexion)]);
    }
}
?>
