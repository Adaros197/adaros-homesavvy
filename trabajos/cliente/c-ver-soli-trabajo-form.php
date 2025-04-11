<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Solicitudes de Trabajo - Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: nexa;
            src: url('../../assets/fonts/title.ttf');
        }

        body {
            font-family: nexa;
            background-color: #e2f2ff !important;
        }

        .custom-input {
            border-radius: 30px !important;
            padding: 10px 15px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            border-radius: 50px !important;
            background-color: #3E93D6 !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3278a7 !important;
        }

        /* Tarjetas estilo HomeSavvy */
        .tarjeta-solicitud {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .tarjeta-solicitud h5 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .tarjeta-solicitud p {
            margin-bottom: 5px;
            color: #555;
        }

        .tarjeta-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .tarjeta-usuario {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tarjeta-usuario img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #3E93D6;
        }       


        .btn-trabajo {
            background-color: #3E93D6 !important;
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: bold;
            border: none;
            border-radius: 20px !important;
            color: white !important;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        .btn-trabajo:hover {
            background-color: #3278a7 !important;
            color: white;
        }

    </style>

    <link rel="stylesheet" href="../../includes/footer-styles.css">
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4" style="color: #3e93d6;">Ver Solicitudes de Trabajo</h1>

        <!-- Filtros -->
        <form id="filtro-form" class="mb-4">
            <label for="categoria" class="fw-bold mb-2">Filtrar</label>
            <div class="input-group">
                <select id="categoria" name="categoria" class="form-control custom-input">
                    <option value="todas">Todas</option>
                    <option value="electricidad">Electricidad</option>
                    <option value="plomería">Plomería</option>
                    <option value="carpintería">Carpintería</option>
                    <option value="limpieza">Limpieza</option>
                </select>
                <button type="button" class="btn btn-primary ms-3" onclick="cargarSolicitudes()">Filtrar</button>
            </div>
        </form>

        <!-- Contenedor de tarjetas -->
        <div id="solicitudes"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        async function cargarSolicitudes() {
            const categoria = document.getElementById("categoria").value;

            try {
                const response = await fetch(`c-ver-soli-trabajo.php?categoria=${categoria}`);
                const data = await response.json();
                const solicitudesDiv = document.getElementById("solicitudes");

                if (data.success) {
                    let html = "";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <div class="tarjeta-solicitud">
                                <h5>${solicitud.titulo}</h5>
                                <p>${solicitud.descripcion}</p>
                                <div class="tarjeta-footer mt-3">
                                    <div class="tarjeta-usuario">
                                        <img src="../../${solicitud.foto_perfil ?? 'assets/img/default.png'}" alt="Foto Profesional">
                                        <div>
                                            <strong>${solicitud.nombre_usuario ?? 'User name'}</strong><br>
                                            <small>${new Date(solicitud.fecha_creacion).toLocaleDateString('es-MX')}</small>

                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-1"><strong>Tarifa:</strong> $${solicitud.tarifa}</p>
                                        <button class="btn btn-trabajo" onclick="pedirTrabajo(${solicitud.id_solicitud_trabajo})">Pedir Trabajo</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    solicitudesDiv.innerHTML = html;
                } else {
                    solicitudesDiv.innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                document.getElementById("solicitudes").innerHTML = "<p>Error al cargar las solicitudes</p>";
            }
        }

        async function pedirTrabajo(idSolicitud) {
            try {
                const response = await fetch(`c-pedir-trabajo.php?id_solicitud=${idSolicitud}`, { method: 'POST' });
                const data = await response.json();
                alert(data.message);
                cargarSolicitudes();
            } catch (error) {
                alert("Error al pedir el trabajo");
            }
        }

        // Cargar automáticamente al abrir
        cargarSolicitudes();
    </script>
    

    <script>
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
            window.location.href = '/adaros-homesavvy/trabajos/cliente/c-ver-soli-trabajo-form.php';
            };
        }
    </script>


    <?php include '../../includes/footer-cliente.php'; ?>
</body>
</html>
