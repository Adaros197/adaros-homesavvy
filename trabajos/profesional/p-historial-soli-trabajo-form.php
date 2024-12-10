<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Solicitudes de Trabajo</title>
</head>
<body>
    <?php include '../../includes/navbar-profesional.php'; ?>
    <h1>Historial de Solicitudes de Trabajo</h1>

    <div id="historial">
        <!-- Aquí se cargarán las solicitudes mediante AJAX -->
    </div>

    <script>
        async function cargarHistorial() {
            try {
                const response = await fetch("p-historial-soli-trabajo.php");
                const data = await response.json();
                const historialDiv = document.getElementById("historial");

                if (data.success) {
                    let html = "<ul>";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <li>
                                <h3>${solicitud.titulo}</h3>
                                <p>${solicitud.descripcion}</p>
                                <p><strong>Categoría:</strong> ${solicitud.categoria}</p>
                                <p><strong>Tarifa:</strong> ${solicitud.tarifa}</p>
                                <p><strong>Estado:</strong> ${solicitud.estado}</p>
                                ${
                                    solicitud.foto
                                    ? `<img src="../../${solicitud.foto}" alt="Foto del trabajo" style="max-width: 200px;">`
                                    : "<p>Sin imagen</p>"
                                }
                                <button onclick="verPeticiones(${solicitud.id_solicitud_trabajo})">Ver Peticiones</button>
                                <button onclick="editarSolicitud(${solicitud.id_solicitud_trabajo})">Editar</button>
                                <button onclick="eliminarSolicitud(${solicitud.id_solicitud_trabajo})">Eliminar</button>
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

        async function verPeticiones(idSolicitud) {
            try {
                const response = await fetch(`p-ver-peticiones.php?id_solicitud=${idSolicitud}`);
                const data = await response.json();

                if (data.success) {
                    let html = `<h3>Peticiones para la Solicitud ${idSolicitud}</h3><ul>`;
                    data.peticiones.forEach(peticion => {
                        html += `
                            <li>
                                <p><strong>Cliente:</strong> ${peticion.nombre_cliente}</p>
                                <p><strong>Fecha de Petición:</strong> ${peticion.fecha_peticion}</p>
                                <p><strong>Estado:</strong> ${peticion.estado}</p>
                                <button onclick="aceptarPeticion(${peticion.id_peticion_trabajo})">Aceptar</button>
                                <button onclick="rechazarPeticion(${peticion.id_peticion_trabajo})">Rechazar</button>
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
                alert("Error al cargar las peticiones");
            }
        }

        async function aceptarPeticion(idPeticion) {
            const response = await fetch(`p-aceptar-peticion.php?id_peticion=${idPeticion}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        async function rechazarPeticion(idPeticion) {
            const response = await fetch(`p-rechazar-peticion.php?id_peticion=${idPeticion}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        async function editarSolicitud(idSolicitud) {
            window.location.href = `p-editar-soli-trabajo-form.php?id_solicitud=${idSolicitud}`;
        }

        async function eliminarSolicitud(idSolicitud) {
            const response = await fetch(`p-eliminar-soli-trabajo.php?id_solicitud=${idSolicitud}`);
            const data = await response.json();
            alert(data.message);
            cargarHistorial();
        }

        cargarHistorial();
    </script>
</body>
</html>