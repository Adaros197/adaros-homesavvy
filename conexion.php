<?php
function retornarConexion() {
    $host = "localhost";       // Servidor
    $user = "root";            // Usuario de MySQL
    $password = "";            // Contraseña (vacío para XAMPP por defecto)
    $database = "homesavvy";   // Nombre de la base de datos

    // Crear conexión
    $conexion = mysqli_connect($host, $user, $password, $database);

    // Verificar conexión
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    return $conexion;
}
?>