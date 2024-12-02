<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Solicitudes de Trabajo</title>
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>
    <h1>Solicitudes de Trabajo Disponibles</h1>

    <!-- Filtros -->
    <form id="filtro-form">
        <label for="categoria">Filtrar por categoría:</label>
        <select id="categoria" name="categoria">
            <option value="todas">Todas</option>
            <option value="electricidad">Electricidad</option>
            <option value="plomería">Plomería</option>
            <option value="carpintería">Carpintería</option>
            <option value="limpieza">Limpieza</option>
        </select>
        <button type="button" onclick="cargarSolicitudes()">Filtrar</button>
    </form>

    <div id="solicitudes">
        <!-- Aquí se cargarán las solicitudes mediante AJAX -->
    </div>

    <script>
        async function cargarSolicitudes() {
            const categoria = document.getElementById("categoria").value;

            try {
                const response = await fetch(`c-ver-soli-trabajo.php?categoria=${categoria}`);
                const data = await response.json();
                const solicitudesDiv = document.getElementById("solicitudes");

                if (data.success) {
                    let html = "<ul>";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <li>
                                <h3>${solicitud.titulo}</h3>
                                <p>${solicitud.descripcion}</p>
                                <p><strong>Categoría:</strong> ${solicitud.categoria}</p>
                                <p><strong>Tarifa:</strong> ${solicitud.tarifa}</p>
                                ${
                                    solicitud.foto
                                    ? `<img src="../${solicitud.foto}" alt="Imagen del trabajo" style="max-width: 200px;">`
                                    : "<p>Sin imagen</p>"
                                }
                                <button onclick="pedirTrabajo(${solicitud.id_solicitud_trabajo})">Pedir Trabajo</button>
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

        // Cargar las solicitudes al iniciar la página
        cargarSolicitudes();
    </script>
</body>
</html>
