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

    // Rutas para almacenar archivos subidos
    $basePath = realpath(__DIR__ . '/../uploads/cliente/');
    $ruta_ine = $basePath . '/ine/' . basename($_FILES['ine']['name']);
    $ruta_comprobante = $basePath . '/comprobante/' . basename($_FILES['comprobante_domicilio']['name']);
    $ruta_foto = $basePath . '/perfil/' . basename($_FILES['foto_perfil']['name']);

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

    // Insertar datos en la base
    $query = "INSERT INTO Cliente (nombre, apellido_p, apellido_m, email, contraseña, numero, direccion, ine, comprobante_domicilio, foto_perfil) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$email', '$password', '$numero', '$direccion', '$ruta_ine', '$ruta_comprobante', '$ruta_foto')";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
    }
}
?>
