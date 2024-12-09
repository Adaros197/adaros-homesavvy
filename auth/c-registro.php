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

    // Insertar el cliente en la base de datos
    $query = "INSERT INTO Cliente (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$numero', '$email', '$direccion', '$contraseña')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $cliente_id = mysqli_insert_id($conexion); // Obtener el ID del cliente insertado

        // Verificar si los archivos existen en el array $_FILES
        $extension_ine = isset($_FILES['ine']) ? pathinfo($_FILES['ine']['name'], PATHINFO_EXTENSION) : '';
        $extension_comprobante = isset($_FILES['comprobante_domicilio']) ? pathinfo($_FILES['comprobante_domicilio']['name'], PATHINFO_EXTENSION) : '';
        $extension_perfil = isset($_FILES['foto_perfil']) ? pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION) : '';

        // Guardar las imágenes con el ID del cliente seguido de la extensión original
        $ruta_ine = "uploads/clientes/ine/$cliente_id.$extension_ine";
        $ruta_comprobante = "uploads/clientes/comprobante/$cliente_id.$extension_comprobante";
        $ruta_perfil = "uploads/clientes/perfil/$cliente_id.$extension_perfil";

        // Crear directorios si no existen
        if (!is_dir("../uploads/clientes/ine")) {
            mkdir("../uploads/clientes/ine", 0777, true);
        }
        if (!is_dir("../uploads/clientes/comprobante")) {
            mkdir("../uploads/clientes/comprobante", 0777, true);
        }
        if (!is_dir("../uploads/clientes/perfil")) {
            mkdir("../uploads/clientes/perfil", 0777, true);
        }

        // Mover los archivos subidos a las rutas especificadas
        if (isset($_FILES['ine']) && !move_uploaded_file($_FILES['ine']['tmp_name'], "../$ruta_ine")) {
            die(json_encode(['error' => 'Error al mover el archivo INE']));
        }
        if (isset($_FILES['comprobante_domicilio']) && !move_uploaded_file($_FILES['comprobante_domicilio']['tmp_name'], "../$ruta_comprobante")) {
            die(json_encode(['error' => 'Error al mover el archivo de comprobante de domicilio']));
        }
        if (isset($_FILES['foto_perfil']) && !move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../$ruta_perfil")) {
            die(json_encode(['error' => 'Error al mover el archivo de foto de perfil']));
        }

        // Actualizar rutas de archivos en la base de datos
        $query = "UPDATE Cliente SET 
                    ine = '$ruta_ine', 
                    comprobante_domicilio = '$ruta_comprobante', 
                    foto_perfil = '$ruta_perfil' 
                  WHERE id_cliente = $cliente_id";
        mysqli_query($conexion, $query);

        // Redireccionar a la página de login
        header('Location: login.html');
        exit();
    }
}
?>