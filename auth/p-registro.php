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
    $profesion = mysqli_real_escape_string($conexion, $_POST['profesion']);
    $rfc = mysqli_real_escape_string($conexion, $_POST['rfc']);

    // Rutas para almacenar archivos subidos
    $basePath = realpath(__DIR__ . '/../uploads/profesional/');
    $ruta_ine = $basePath . '/ine/' . basename($_FILES['ine']['name']);
    $ruta_comprobante = $basePath . '/comprobante/' . basename($_FILES['comprobante_domicilio']['name']);
    $ruta_foto = $basePath . '/perfil/' . basename($_FILES['foto_perfil']['name']);
    $ruta_curriculum = $basePath . '/curriculum/' . basename($_FILES['curriculum']['name']);

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
    if (!move_uploaded_file($_FILES['curriculum']['tmp_name'], $ruta_curriculum)) {
        echo json_encode(['success' => false, 'message' => 'Error al subir el currículum']);
        exit;
    }

    // Insertar datos en la base
    $query = "INSERT INTO Profesional (nombre, apellido_p, apellido_m, email, contraseña, numero, direccion, profesion, rfc, ine, comprobante_domicilio, foto_perfil, curriculum) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$email', '$password', '$numero', '$direccion', '$profesion', '$rfc', '$ruta_ine', '$ruta_comprobante', '$ruta_foto', '$ruta_curriculum')";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
    }
}
?>
