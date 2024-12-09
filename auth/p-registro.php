<?php
session_start();
header('Content-Type: application/json');
require("../conexion.php");
$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si las claves existen en el array $_POST
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre'] ?? '');
    $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellido_p'] ?? '');
    $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellido_m'] ?? '');
    $numero = mysqli_real_escape_string($conexion, $_POST['numero'] ?? '');
    $email = mysqli_real_escape_string($conexion, $_POST['email'] ?? '');
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion'] ?? '');
    $contraseña = mysqli_real_escape_string($conexion, $_POST['password'] ?? '');
    $profesion = mysqli_real_escape_string($conexion, $_POST['profesion'] ?? '');
    $rfc = mysqli_real_escape_string($conexion, $_POST['rfc'] ?? '');

    // Insertar el profesional en la base de datos
    $query = "INSERT INTO Profesional (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña, profesion, rfc) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$numero', '$email', '$direccion', '$contraseña', '$profesion', '$rfc')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $profesional_id = mysqli_insert_id($conexion);

        // Verificar si los archivos existen en el array $_FILES
        $extension_ine = isset($_FILES['ine']) ? pathinfo($_FILES['ine']['name'], PATHINFO_EXTENSION) : '';
        $extension_comprobante = isset($_FILES['comprobante_domicilio']) ? pathinfo($_FILES['comprobante_domicilio']['name'], PATHINFO_EXTENSION) : '';
        $extension_perfil = isset($_FILES['foto_perfil']) ? pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION) : '';
        $extension_curriculum = isset($_FILES['curriculum']) ? pathinfo($_FILES['curriculum']['name'], PATHINFO_EXTENSION) : '';
        $extension_antecedentes = isset($_FILES['antecedentes']) ? pathinfo($_FILES['antecedentes']['name'], PATHINFO_EXTENSION) : '';
        $extension_cartas = isset($_FILES['cartas_recomendacion']) ? pathinfo($_FILES['cartas_recomendacion']['name'], PATHINFO_EXTENSION) : '';
        $extension_constancia = isset($_FILES['constancia_situacion_fiscal']) ? pathinfo($_FILES['constancia_situacion_fiscal']['name'], PATHINFO_EXTENSION) : '';

        // Definir rutas de archivos
        $ruta_ine = "uploads/profesionales/ine/$profesional_id.$extension_ine";
        $ruta_comprobante = "uploads/profesionales/comprobante/$profesional_id.$extension_comprobante";
        $ruta_perfil = "uploads/profesionales/perfil/$profesional_id.$extension_perfil";
        $ruta_curriculum = "uploads/profesionales/curriculum/$profesional_id.$extension_curriculum";
        $ruta_antecedentes = "uploads/profesionales/antecedentes/$profesional_id.$extension_antecedentes";
        $ruta_cartas = "uploads/profesionales/cartas/$profesional_id.$extension_cartas";
        $ruta_constancia = "uploads/profesionales/constancia/$profesional_id.$extension_constancia";

        // Crear directorios si no existen
        if (!is_dir("../uploads/profesionales/ine")) {
            mkdir("../uploads/profesionales/ine", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/comprobante")) {
            mkdir("../uploads/profesionales/comprobante", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/perfil")) {
            mkdir("../uploads/profesionales/perfil", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/curriculum")) {
            mkdir("../uploads/profesionales/curriculum", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/antecedentes")) {
            mkdir("../uploads/profesionales/antecedentes", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/cartas")) {
            mkdir("../uploads/profesionales/cartas", 0777, true);
        }
        if (!is_dir("../uploads/profesionales/constancia")) {
            mkdir("../uploads/profesionales/constancia", 0777, true);
        }

        // Mover archivos
        if (isset($_FILES['ine']) && !move_uploaded_file($_FILES['ine']['tmp_name'], "../$ruta_ine")) {
            die(json_encode(['error' => 'Error al mover el archivo INE']));
        }
        if (isset($_FILES['comprobante_domicilio']) && !move_uploaded_file($_FILES['comprobante_domicilio']['tmp_name'], "../$ruta_comprobante")) {
            die(json_encode(['error' => 'Error al mover el archivo de comprobante de domicilio']));
        }
        if (isset($_FILES['foto_perfil']) && !move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../$ruta_perfil")) {
            die(json_encode(['error' => 'Error al mover el archivo de foto de perfil']));
        }
        if (isset($_FILES['curriculum']) && !move_uploaded_file($_FILES['curriculum']['tmp_name'], "../$ruta_curriculum")) {
            die(json_encode(['error' => 'Error al mover el archivo de curriculum']));
        }
        if (isset($_FILES['antecedentes']) && !move_uploaded_file($_FILES['antecedentes']['tmp_name'], "../$ruta_antecedentes")) {
            die(json_encode(['error' => 'Error al mover el archivo de antecedentes']));
        }
        if (isset($_FILES['cartas_recomendacion']) && !move_uploaded_file($_FILES['cartas_recomendacion']['tmp_name'], "../$ruta_cartas")) {
            die(json_encode(['error' => 'Error al mover el archivo de cartas de recomendación']));
        }
        if (isset($_FILES['constancia_situacion_fiscal']) && !move_uploaded_file($_FILES['constancia_situacion_fiscal']['tmp_name'], "../$ruta_constancia")) {
            die(json_encode(['error' => 'Error al mover el archivo de constancia de situación fiscal']));
        }

        // Actualizar rutas en la base de datos
        $query = "UPDATE Profesional SET 
                    ine = '$ruta_ine',
                    comprobante_domicilio = '$ruta_comprobante',
                    foto_perfil = '$ruta_perfil',
                    curriculum = '$ruta_curriculum',
                    antecedentes = '$ruta_antecedentes',
                    cartas_recomendacion = '$ruta_cartas',
                    constancia_situacion_fiscal = '$ruta_constancia'
                  WHERE id_profesional = $profesional_id";
        mysqli_query($conexion, $query);

        // Redireccionar a login
        header('Location: login.html');
        exit();
    }
}
?>