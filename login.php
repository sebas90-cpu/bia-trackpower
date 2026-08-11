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
</head>

<body>

    <div class="main-wrapper">
        <!-- Panel lateral con la marca -->
        <div class="brand-panel">
            <div class="brand-content">
                <img src="logo-bia.jpg" alt="Bia Energy Logo" class="side-logo">
                <h2>Bia PowerTrack</h2>
                <p>Microservicio de gestión y consulta de consumos energéticos[cite: 1].</p>
            </div>
        </div>

        <!-- Panel del formulario de inicio de sesión -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Iniciar Sesión</h2>
                    <p>Ingrese sus credenciales para acceder al sistema.</p>
                </div>

                <form action="login_process.php" method="POST">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required placeholder="correo@bia.energy">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                            <button type="button" id="togglePassword" aria-label="Mostrar contraseña">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Ingresar</button>

                    <div class="login-redirect">
                        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                        <p style="margin-top: 8px;"><a href="index.php">← Volver al inicio</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script simple para mostrar/ocultar contraseña -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>

</body>

</html>