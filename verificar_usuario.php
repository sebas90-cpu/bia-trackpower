<?php
include 'conexion.php';

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        echo "existe";
    } else {
        echo "disponible";
    }
}
?>