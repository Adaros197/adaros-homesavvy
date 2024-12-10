<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Solicitudes de Servicio</title>
</head>
<body>
    <?php include '../../includes/navbar-profesional.php'; ?>
    <h1>Solicitudes de Servicio Disponibles</h1>

    <!-- Filtros -->
    <form id="filtro-form">
        <label for="estado">Filtrar por estado:</label>
        <select id="estado" name="estado">
            <option value="todas">Todas</option>
            <option value="pendiente">Pendiente</option>
            <option value="en proceso">En Proceso</option>
            <option value="completada">Completada</option>
        </select>
        <button type="button" onclick="cargarSolicitudes()">Filtrar</button>
    </form>

    <div id="solicitudes">
        <!-- Aquí se cargarán las solicitudes disponibles mediante AJAX -->
    </div>

    <script>
        async function cargarSolicitudes() {
            const estado = document.getElementById("estado").value;

            try {
                const response = await fetch(`p-ver-soli-servicio.php?estado=${estado}`);
                const data = await response.json();
                const solicitudesDiv = document.getElementById("solicitudes");

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
                                <button onclick="postularse(${solicitud.id_solicitud_servicio})">Postularme</button>
                            </li>
                            <hr>
                        `;
                    });
                    html += "</ul>";
                    solicitudesDiv.innerHTML = html;
                } else {
                    solicitudesDiv.innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                solicitudesDiv.innerHTML = "<p>Error al cargar las solicitudes</p>";
            }
        }

        async function postularse(idSolicitud) {
            try {
                const response = await fetch(`p-postular-servicio.php?id_solicitud=${idSolicitud}`, { method: 'POST' });
                const data = await response.json();
                alert(data.message);
                cargarSolicitudes();
            } catch (error) {
                alert("Error al postularse");
            }
        }

        // Cargar las solicitudes al iniciar la página
        cargarSolicitudes();
    </script>
</body>
</html>