<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomeSavvy - Navbar Profesional</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        @font-face {
            font-family: nexa;
            src: url('/adaros-homesavvy/assets/fonts/title.ttf');
        }

        body {
            font-family: nexa;
            background-color: #e7e7f9;
        }

        .navbar-rounded {
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: border-radius 0.2s ease-in-out;
        }

        .sticky-active {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 10px !important;
            border-bottom-left-radius: 10px !important;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            transition: all 0.3s ease-in-out;
        }

        .nav-link i {
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .nav-link:hover,
        .nav-link:hover i {
            color: #A2A2F4 !important;
        }

        .nav-link.active,
        .nav-link.active i {
            color: #A2A2F4 !important;
            font-weight: bold;
        }

        .logo-container img {
            height: 40px;
            width: 50px;
            margin-right: 10px;
        }

        .profile-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<header class="navbar-sticky sticky-top container px-2 mt-3">
    <div class="navbar navbar-expand-lg navbar-light bg-light navbar-rounded shadow-lg ps-0 mx-1 border" style="border-color: #A2A2F4 !important;">
        <button type="button" class="navbar-toggler ms-3" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand position-relative ms-4 logo-container">
            <img src="/adaros-homesavvy/assets/img/hdpro.png" alt="Logo">
            <span style="color: #A2A2F4;">PROFESIONAL</span>
        </a>

        <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header py-3">
                <h5 class="offcanvas-title" id="navbarNavLabel">PROFESIONAL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
                <ul class="navbar-nav position-relative">
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/servicios/profesional/p-ver-soli-servicio-form.php">
                            <i class="bi bi-list-task"></i> Ver solicitudes
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/trabajos/profesional/p-historial-soli-trabajo-form.php">
                            <i class="bi bi-journal-text"></i> Historial
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fs-sm" href="/adaros-homesavvy/trabajos/profesional/p-subir-soli-trabajo-form.php">
                            <i class="bi bi-file-earmark-plus"></i> Subir trabajo
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="me-3">
            <a href="/adaros-homesavvy/perfiles/p-gestion-perfil.php">
                <img src="/adaros-homesavvy/assets/img/perfiltra.png" alt="Perfil" class="profile-img">
            </a>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentUrl = window.location.pathname;
        document.querySelectorAll(".nav-link").forEach(link => {
            if (link.getAttribute("href") === currentUrl) {
                link.classList.add("active");
            }
        });

        const navbar = document.querySelector(".navbar-rounded");
        const navbarOffset = navbar.offsetTop;
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
