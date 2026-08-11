<?php
// Parámetros de conexión a la base de datos via_energy
$host = "127.0.0.1";
$user = "root";
$password = ""; 
$database = "bia_energy";

// Crear la conexión usando mysqli
$conexion = mysqli_connect($host, $user, $password, $database);

// Verificar si la conexión falló
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer el conjunto de caracteres a utf8
mysqli_set_charset($conexion, "utf8");

// Opcional: Mensaje de éxito
// echo "¡Conexión exitosa a via_energy!";
?>