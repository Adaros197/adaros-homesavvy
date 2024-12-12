<?php
session_start();
header('Content-Type: application/json');
require("../conexion.php");
$conexion = retornarConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre'] ?? '');
    $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellido_p'] ?? '');
    $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellido_m'] ?? '');
    $numero = mysqli_real_escape_string($conexion, $_POST['numero'] ?? '');
    $email = mysqli_real_escape_string($conexion, $_POST['email'] ?? '');
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion'] ?? '');
    $contraseña = mysqli_real_escape_string($conexion, $_POST['password'] ?? '');

    $query_check_email = "
        SELECT email FROM Cliente WHERE email = '$email'
        UNION
        SELECT email FROM Profesional WHERE email = '$email'
        UNION
        SELECT email FROM Admin WHERE email = '$email'
    ";
    $result_check_email = mysqli_query($conexion, $query_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado en otra cuenta']);
    } else {
        $query = "INSERT INTO Cliente (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña) 
                  VALUES ('$nombre', '$apellido_p', '$apellido_m', '$numero', '$email', '$direccion', '$contraseña')";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $cliente_id = mysqli_insert_id($conexion);

            $extension_ine = isset($_FILES['ine']) ? pathinfo($_FILES['ine']['name'], PATHINFO_EXTENSION) : '';
            $extension_comprobante = isset($_FILES['comprobante_domicilio']) ? pathinfo($_FILES['comprobante_domicilio']['name'], PATHINFO_EXTENSION) : '';
            $extension_perfil = isset($_FILES['foto_perfil']) ? pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION) : '';

            $ruta_ine = "uploads/clientes/ine/$cliente_id.$extension_ine";
            $ruta_comprobante = "uploads/clientes/comprobante/$cliente_id.$extension_comprobante";
            $ruta_perfil = "uploads/clientes/perfil/$cliente_id.$extension_perfil";

            if (!is_dir("../uploads/clientes/ine")) {
                mkdir("../uploads/clientes/ine", 0777, true);
            }
            if (!is_dir("../uploads/clientes/comprobante")) {
                mkdir("../uploads/clientes/comprobante", 0777, true);
            }
            if (!is_dir("../uploads/clientes/perfil")) {
                mkdir("../uploads/clientes/perfil", 0777, true);
            }

            if (isset($_FILES['ine']) && !move_uploaded_file($_FILES['ine']['tmp_name'], "../$ruta_ine")) {
                header('Location: error.html?message=Error al mover el archivo INE');
                exit();
            }
            if (isset($_FILES['comprobante_domicilio']) && !move_uploaded_file($_FILES['comprobante_domicilio']['tmp_name'], "../$ruta_comprobante")) {
                header('Location: error.html?message=Error al mover el archivo de comprobante de domicilio');
                exit();
            }
            if (isset($_FILES['foto_perfil']) && !move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../$ruta_perfil")) {
                header('Location: error.html?message=Error al mover el archivo de foto de perfil');
                exit();
            }

            $query = "UPDATE Cliente SET 
                        ine = '$ruta_ine', 
                        comprobante_domicilio = '$ruta_comprobante', 
                        foto_perfil = '$ruta_perfil' 
                      WHERE id_cliente = $cliente_id";
            mysqli_query($conexion, $query);

            echo json_encode(['success' => true, 'message' => 'Cliente registrado exitosamente']);
            header('Location: login.html');
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($conexion)]);
        }
    }
}
?>
