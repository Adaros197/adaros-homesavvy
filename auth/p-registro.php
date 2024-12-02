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

    // Insertar datos básicos en la base de datos
    $query = "INSERT INTO Profesional (nombre, apellido_p, apellido_m, email, contraseña, numero, direccion, profesion, rfc) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$email', '$password', '$numero', '$direccion', '$profesion', '$rfc')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $profesional_id = mysqli_insert_id($conexion);

        // Rutas para almacenar archivos subidos
        $basePath = realpath(__DIR__ . '/../uploads/profesional/');
        $ruta_ine = $basePath . '/ine/' . $profesional_id . '_ine.' . pathinfo($_FILES['ine']['name'], PATHINFO_EXTENSION);
        $ruta_comprobante = $basePath . '/comprobante/' . $profesional_id . '_comprobante.' . pathinfo($_FILES['comprobante_domicilio']['name'], PATHINFO_EXTENSION);
        $ruta_foto = $basePath . '/perfil/' . $profesional_id . '_foto.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $ruta_curriculum = $basePath . '/curriculum/' . $profesional_id . '_curriculum.' . pathinfo($_FILES['curriculum']['name'], PATHINFO_EXTENSION);
        $ruta_antecedentes = $basePath . '/antecedentes/' . $profesional_id . '_antecedentes.' . pathinfo($_FILES['antecedentes']['name'], PATHINFO_EXTENSION);
        $ruta_cartas_recomendacion = $basePath . '/cartas_recomendacion/' . $profesional_id . '_cartas_recomendacion.' . pathinfo($_FILES['cartas_recomendacion']['name'], PATHINFO_EXTENSION);
        $ruta_constancia_situacion_fiscal = $basePath . '/constancia_situacion_fiscal/' . $profesional_id . '_constancia_situacion_fiscal.' . pathinfo($_FILES['constancia_situacion_fiscal']['name'], PATHINFO_EXTENSION);

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
        if (!move_uploaded_file($_FILES['antecedentes']['tmp_name'], $ruta_antecedentes)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo de antecedentes']);
            exit;
        }
        if (!move_uploaded_file($_FILES['cartas_recomendacion']['tmp_name'], $ruta_cartas_recomendacion)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir las cartas de recomendación']);
            exit;
        }
        if (!move_uploaded_file($_FILES['constancia_situacion_fiscal']['tmp_name'], $ruta_constancia_situacion_fiscal)) {
            echo json_encode(['success' => false, 'message' => 'Error al subir la constancia de situación fiscal']);
            exit;
        }

        // Actualizar rutas de archivos en la base de datos
        $query = "UPDATE Profesional SET 
                    ine = '$ruta_ine', 
                    comprobante_domicilio = '$ruta_comprobante', 
                    foto_perfil = '$ruta_foto', 
                    curriculum = '$ruta_curriculum', 
                    antecedentes = '$ruta_antecedentes', 
                    cartas_recomendacion = '$ruta_cartas_recomendacion', 
                    constancia_situacion_fiscal = '$ruta_constancia_situacion_fiscal' 
                  WHERE id_profesional = '$profesional_id'";
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