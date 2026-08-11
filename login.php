<?php
session_start();
include 'conexion.php';

$mensaje_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se recibe el input (puede ser correo o usuario)
    $email_o_usuario = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password']; // Contraseña en texto plano

    // Consultar si el correo o el usuario existen en la base de datos
    $sql = "SELECT * FROM users WHERE email = '$email_o_usuario' OR username = '$email_o_usuario'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        
        // El usuario existe, ahora verificamos que la contraseña coincida
        if ($password === $row['password']) {
            // Guardar datos en la sesión
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            // Alerta de éxito y redirección
            $mensaje_alerta = "swal({
                title: '¡Bienvenido!',
                text: 'Iniciando sesión en Bia PowerTrack...',
                icon: 'success',
                buttons: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'dashboard.php';
            });";
        } else {
            // Contraseña incorrecta
            $mensaje_alerta = "swal('Datos incorrectos', 'La contraseña ingresada no es válida.', 'error');";
        }
    } else {
        // El usuario no está registrado
        $mensaje_alerta = "swal({
            title: 'Usuario no registrado',
            text: 'Los datos ingresados no coinciden con ninguna cuenta. ¿Deseas registrarte?',
            icon: 'warning',
            buttons: ['Cancelar', 'Ir a Registro'],
            dangerMode: false,
        }).then((willRegister) => {
            if (willRegister) {
                window.location.href = 'registro.php';
            }
        });";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Bia PowerTrack</title>
    <link rel="stylesheet" href="estilos.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <div class="main-wrapper">
        <!-- Panel lateral con la marca -->
        <div class="brand-panel">
            <div class="brand-content">
                <img src="logo-bia.jpg" alt="Bia Energy Logo" class="side-logo">
                <h2>Bia PowerTrack</h2>
                <p>Microservicio de gestión y consulta de consumos energéticos.</p>
            </div>
        </div>

        <!-- Panel del formulario de inicio de sesión -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Iniciar Sesión</h2>
                    <p>Ingrese sus credenciales para acceder al sistema.</p>
                </div>

                <!-- Asegúrate de que el action apunte a este mismo archivo -->
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Correo Electrónico o Usuario</label>
                        <input type="text" id="email" name="email" required placeholder="correo@bia.energy o usuario_bia">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                            <button type="button" id="togglePassword" aria-label="Mostrar contraseña">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Ingresar</button>

                    <div class="login-redirect">
                        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>

    <!-- Script para inyectar la alerta de SweetAlert si PHP detecta algún evento -->
    <script>
        <?php if (!empty($mensaje_alerta)) { echo $mensaje_alerta; } ?>
    </script>

</body>
</html>