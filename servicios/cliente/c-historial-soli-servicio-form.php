<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Solicitudes de Servicio - Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: nexa;
            src: url('../../assets/fonts/title.ttf');
        }
        body {
            font-family: nexa;
        }
    </style>
    <link rel="stylesheet" href="../../includes/footer-styles.css">
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #3e93d6;">Historial de Solicitudes de Servicio</h1>
        <div id="historial">
            <!-- Aquí se cargarán las solicitudes mediante AJAX -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Cargar el historial de solicitudes
        async function cargarHistorial() {
            try {
                const response = await fetch("c-historial-soli-servicio.php");
                const data = await response.json();
                const historialDiv = document.getElementById("historial");

                if (data.success) {
                    let html = "<ul>";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <li>
                                <h3>${solicitud.titulo}</h3>
                                <p>${solicitud.descripcion}</p>
                                <p><strong>Estado:</strong> ${solicitud.estado}</p>
                                <p><strong>Horario:</strong> ${solicitud.horarios}</p>
                                <p><strong>Método de Pago:</strong> ${solicitud.metodo_pago}</p>
                                ${
                                    solicitud.foto
                                    ? `<img src="../../${solicitud.foto}" alt="Foto del servicio" style="max-width: 200px;">`
                                    : "<p>Sin imagen</p>"
                                }
                                <button onclick="verPostulaciones(${solicitud.id_solicitud_servicio})">Ver Postulaciones</button>
                                <button onclick="editarSolicitud(${solicitud.id_solicitud_servicio})">Editar</button>
                                <button onclick="eliminarSolicitud(${solicitud.id_solicitud_servicio})">Eliminar</button>
                            </li>
                            <hr>
                        `;
                    });
                    html += "</ul>";
                    historialDiv.innerHTML = html;
                } else {
                    historialDiv.innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                historialDiv.innerHTML = "<p>Error al cargar el historial</p>";
            }
        }

        // Ver postulaciones de una solicitud
        async function verPostulaciones(idSolicitud) {
            try {
                const response = await fetch(`c-ver-postulaciones.php?id_solicitud=${idSolicitud}`);
                const data = await response.json();
                if (data.success) {
                    let html = `<h3>Postulaciones para la Solicitud ${idSolicitud}</h3><ul>`;
                    data.postulaciones.forEach(postulacion => {
                        html += `
                            <li>
                                <p><strong>Profesional:</strong> ${postulacion.nombre}</p>
                                <p><strong>Estado:</strong> ${postulacion.estado}</p>
                                <button onclick="aceptarPostulacion(${postulacion.id_postulacion_servicio})">Aceptar</button>
                                <button onclick="rechazarPostulacion(${postulacion.id_postulacion_servicio})">Rechazar</button>
                            </li>
                            <hr>
                        `;
                    });
                    html += "</ul>";
                    document.getElementById("historial").innerHTML = html;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert("Error al cargar las postulaciones");
            }
        }

        // Aceptar/Rechazar postulaciones
        async function aceptarPostulacion(idPostulacion) {
            const response = await fetch(`c-aceptar-postulacion.php?id_postulacion=${idPostulacion}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        async function rechazarPostulacion(idPostulacion) {
            const response = await fetch(`c-rechazar-postulacion.php?id_postulacion=${idPostulacion}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        // Editar una solicitud
        function editarSolicitud(idSolicitud) {
            window.location.href = `c-editar-soli-servicio-form.php?id_solicitud=${idSolicitud}`;
        }

        // Eliminar una solicitud
        async function eliminarSolicitud(idSolicitud) {
            const response = await fetch(`c-eliminar-soli-servicio.php?id_solicitud=${idSolicitud}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        // Cargar historial al cargar la página
        cargarHistorial();
    </script>
    <?php include '../../includes/footer-cliente.php'; ?>
</body>
</html>