// 1. Validación de directrices de seguridad para la contraseña en tiempo real
function validarPassword() {
    const p = document.getElementById('password').value;
    
    const checks = {
        'req-len': p.length >= 8,
        'req-upper': /[A-Z]/.test(p),
        'req-lower': /[a-z]/.test(p),
        'req-num': /[0-9]/.test(p),
        'req-special': /[!@#$%^&*(),.?":{}|<_\-]/.test(p)
    };

    for (const [id, isValid] of Object.entries(checks)) {
        const el = document.getElementById(id);
        if (el) {
            if (isValid) {
                el.classList.add('valid');
                el.classList.remove('invalid');
            } else {
                el.classList.remove('valid');
                el.classList.add('invalid');
            }
        }
    }
}

// 2. Verificación asíncrona de disponibilidad del usuario contra la base de datos
function verificarUsuario() {
    const username = document.getElementById('username').value;
    const statusDiv = document.getElementById('user-status');

    if (!statusDiv) return;

    if (username.length === 0) {
        statusDiv.innerHTML = "";
        statusDiv.className = "";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "verificar_usuario.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText.trim() === "existe") {
                statusDiv.className = "status-error";
                statusDiv.innerHTML = "Este usuario ya está en uso";
            } else {
                statusDiv.className = "status-success";
                statusDiv.innerHTML = "✓ Usuario disponible";
            }
        }
    };
    xhr.send("username=" + encodeURIComponent(username));
}

// 3. Control de visibilidad del campo de contraseña (Mostrar / Ocultar con SVG)
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Icono de ojo tachado (ocultar)
        eyeIcon.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
    } else {
        passwordInput.type = 'password';
        // Icono de ojo abierto (mostrar)
        eyeIcon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
}