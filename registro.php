<?php
include 'conexion.php';

$mensaje_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password']; // Contraseña en texto plano para demostración

    $check_user = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $res = mysqli_query($conexion, $check_user);

    if (mysqli_num_rows($res) > 0) {
        $mensaje_alerta = "swal('Error', 'El nombre de usuario o correo ya se encuentran registrados.', 'error');";
    } else {
        // Se elimina password_hash y se guarda directamente la variable $password en texto plano
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conexion, $sql)) {
            $mensaje_alerta = "swal('¡Éxito!', 'Registro exitoso. Por favor inicie sesión.', 'success').then(() => { window.location = 'login.php'; });";
        } else {
            $mensaje_alerta = "swal('Error', 'Hubo un problema al registrar el usuario.', 'error');";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Bia PowerTrack</title>
    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="estilos.css">
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<div class="main-wrapper">
    <!-- Panel lateral con la marca (Bia PowerTrack) -->
    <div class="brand-panel">
        <div class="brand-content">
            <img src="logo-bia.jpg" alt="Bia Energy Logo" class="side-logo">
            <h2>Bia PowerTrack</h2>
            <p>Microservicio de gestión y consulta de consumos energéticos</p>
        </div>
    </div>

    <!-- Panel del formulario de registro -->
    <div class="form-panel">
        <div class="form-container">
            <div class="form-header">
                <h2>Crear Cuenta</h2>
                <p>Crear nueva cuenta técnica</p>
            </div>
            
            <form action="registro.php" method="POST" autocomplete="off" id="registerForm">
                <div class="form-group">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ej. usuario_bia" required onkeyup="verificarUsuario()">
                    <div id="user-status"></div>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="correo@bia.energy" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required oninput="validarPassword()">
                        <!-- Botón que activa la función JavaScript -->
                        <button type="button" id="toggle-password" onclick="togglePasswordVisibility()" title="Mostrar u ocultar contraseña">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    
                    <ul id="password-requirements">
                        <li id="req-len" class="invalid">Mínimo 8 caracteres</li>
                        <li id="req-upper" class="invalid">Una letra mayúscula</li>
                        <li id="req-lower" class="invalid">Una letra minúscula</li>
                        <li id="req-num" class="invalid">Un número</li>
                        <li id="req-special" class="invalid">Un signo de puntuación</li>
                    </ul>
                </div>

                <button type="submit" class="btn-submit" id="btn-submit">REGISTRARSE</button>
            </form>

            <div class="login-redirect">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Enlace fundamental para que funcionen las validaciones y el botón del ojo -->
<script src="registro.js"></script>

<script>
    <?php if (!empty($mensaje_alerta)) { echo $mensaje_alerta; } ?>
</script>

</body>
</html>