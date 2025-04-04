<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomeSavvy - Navbar Animada</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: nexa;
        }

        .navbar-custom {
            font-family: nexa;
            border-bottom: 2px solid #3E93D6 !important;
        }

        .navbar-rounded {
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* 🔹 Contenedor del navbar */
        .navbar-nav {
            position: relative;
        }

        /* 🔹 Efecto de subrayado animado */
        .nav-link {
            position: relative;
            color: #333;
            padding-bottom: 5px;
            transition: color 0.3s ease-in-out;
        }

        /* 🔹 Línea animada */
        .nav-link::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 3px;
            background-color: #3E93D6 !important;
            transition: all 0.4s ease-in-out;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: #3E93D6 !important;
            font-weight: bold;
        }

        /* 🔹 Imagen del logo a la izquierda del texto */
        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 40px;
            width: 50px;
            margin-right: 10px;
        }

        /* 🔹 Estilos para la imagen de perfil */
        .profile-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }
        .navbar-rounded {
            transition: border-radius 0.2s ease-in-out;
        }
        
        .sticky-active {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 10px !important;
            border-bottom-left-radius: 10px !important;
        }


    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar-sticky sticky-top container px-2 mt-3">
    <div class="navbar navbar-expand-lg navbar-light bg-light navbar-rounded shadow-lg ps-0 mx-1 border" style="border-color: #3E93D6 !important ;">
        <button type="button" class="navbar-toggler ms-3" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 🔹 Logo + Texto -->
        <a class="navbar-brand position-relative ms-4 logo-container">
            <img src="/adaros-homesavvy/assets/img/hd.png" alt="Logo">
            <span style="color: #3E93D6;">CLIENTE</span>
        </a>

        <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header py-3">
                <h5 class="offcanvas-title" id="navbarNavLabel">CLIENTE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
                <ul class="navbar-nav position-relative">
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/trabajos/cliente/c-ver-soli-trabajo-form.php">Ver solicitudes de trabajo</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/servicios/cliente/c-historial-soli-servicio-form.php">Historial de Solicitudes de servicio</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/servicios/cliente/c-subir-soli-servicio-form.php">Subir solicitud de servicio</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="me-3">
            <a href="/adaros-homesavvy/perfiles/c-gestion-perfil.php">
            <img src="/adaros-homesavvy/assets/img/perfiltra.png" alt="Gestión de Perfil" class="profile-img">
            </a>
        </div>
    </div>
</header>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentUrl = window.location.pathname;
        let navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(link => {
            if (link.getAttribute("href") === currentUrl) {
                link.classList.add("active");
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let navbar = document.querySelector(".navbar-rounded");
    let navbarOffset = navbar.offsetTop; // Guarda la posición original

    window.addEventListener("scroll", function () {
        if (window.scrollY > navbarOffset) {
            navbar.classList.add("sticky-active");
        } else {
            navbar.classList.remove("sticky-active");
        }
    });
});

</script>

</body>
</html>
