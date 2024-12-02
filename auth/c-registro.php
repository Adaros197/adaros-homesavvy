<?php
header('Content-Type: application/json');
require("../conexion.php");
$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellido_p']);
    $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellido_m']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $numero = mysqli_real_escape_string($conexion, $_POST['numero']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

    // Insertar datos básicos en la base de datos
    $query = "INSERT INTO Cliente (nombre, apellido_p, apellido_m, email, contraseña, numero, direccion) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$email', '$password', '$numero', '$direccion')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $cliente_id = mysqli_insert_id($conexion);

        // Rutas para almacenar archivos subidos
        $basePath = realpath(__DIR__ . '/../uploads/cliente/');
        $ruta_ine = $basePath . '/ine/' . $cliente_id . '_ine.' . pathinfo($_FILES['ine']['name'], PATHINFO_EXTENSION);
        $ruta_comprobante = $basePath . '/comprobante/' . $cliente_id . '_comprobante.' . pathinfo($_FILES['comprobante_domicilio']['name'], PATHINFO_EXTENSION);
        $ruta_foto = $basePath . '/perfil/' . $cliente_id . '_foto.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);

        // Mover archivos a sus respectivas carpetas
        if (!move_uploaded_file($_FILES['ine']['tmp_name'], $ruta_ine)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo de INE']);
            exit;
        }
        if (!move_uploaded_file($_FILES['comprobante_domicilio']['tmp_name'], $ruta_comprobante)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo del Comprobante']);
            exit;
        }
        if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_foto)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir la foto de perfil']);
            exit;
        }

        // Actualizar rutas de archivos en la base de datos
        $query = "UPDATE Cliente SET 
                    ine = '$ruta_ine', 
                    comprobante_domicilio = '$ruta_comprobante', 
                    foto_perfil = '$ruta_foto' 
                  WHERE id_cliente = '$cliente_id'";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar las rutas de los archivos: ' . mysqli_error($conexion)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
    }
}
?>