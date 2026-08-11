<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bia PowerTrack - Monitoreo de Consumos Energéticos</title>
    <link rel="stylesheet" href="estilos.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav>
    <div class="logo-container">
        <img src="logo-bia.jpg" alt="Bia Logo" class="nav-logo-img">
        <span class="logo-divider">|</span>
        <span class="logo-text">Bia PowerTrack</span>
    </div>

    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#acerca">Acerca</a></li>
        <li><a href="#contacto">Contacto</a></li>
    </ul>
</nav>

<!-- ================= HERO ================= -->
<section class="hero" id="inicio">
    <div class="hero-text">
        <h1>Microservicio de Consulta y Gestión de Consumos Energéticos</h1>
        <p>
            Plataforma backend especializada en procesar, integrar y consultar el consumo de energía de medidores e instalaciones de clientes mediante endpoints optimizados por periodos mensuales, semanales y diarios.
        </p>
        <a href="login.php" class="btn">
            Acceder al sistema
        </a>
    </div>

    <div class="hero-img">
        <div class="hero-card-brand">
            <img src="logo-bia.jpg" alt="Bia Energy" class="hero-logo-large">
            <i class="fa-solid fa-bolt lightning-icon"></i>
        </div>
    </div>
</section>

<!-- ================= ACERCA ================= -->
<section class="acerca" id="acerca">
    <div class="contenedor">
        <h2>¿Qué es Bia PowerTrack?</h2>
        <p>
            Bia PowerTrack[cite: 1] es un microservicio en Golang conectado a bases de datos relacionales, diseñado para interactuar de forma eficiente con la gestión de medidores y direcciones de clientes[cite: 1]. Especializado en el análisis escalable de métricas energéticas bajo principios de arquitectura limpia y código robusto[cite: 1].
        </p>

        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-database"></i>
                <h3>Datos de Consumo</h3>
                <p>
                    Procesamiento de registros históricos de medidores[cite: 1], abarcando energía activa, reactiva inductiva, capacitiva y energía exportada.
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Consultas Dinámicas</h3>
                <p>
                    Endpoints especializados[cite: 1] para la obtención y agregación de consumos acumulados por rangos de fecha mensuales, semanales y diarios.
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-server"></i>
                <h3>Arquitectura Backend</h3>
                <p>
                    Desarrollado bajo estándares profesionales de código limpio, patrones de diseño, pruebas unitarias y de integración orientadas a microservicios[cite: 1].
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTACTO ================= -->
<footer id="contacto">
    <h2>Contacto</h2>
    <p>
        Prueba técnica backend desarrollada para la optimización de infraestructura y analítica en Bia Energy
    </p>
    <br>
    <p>
        <i class="fa-solid fa-envelope"></i>
        contacto@bia.energy
    </p>
    <p>
        <i class="fa-solid fa-code"></i>
        Desarrollado por: Sebastian Peñaloza Robayo
    </p>
    <p>
        <i class="fa-solid fa-graduation-cap"></i>
        SENA - Programación de Software / Prueba Bia Energy
    </p>
    <br>
    <p>
        © 2026 Bia PowerTrack - Todos los derechos reservados.
    </p>
</footer>

</body>
</html>