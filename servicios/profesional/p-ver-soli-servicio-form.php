<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Solicitudes de Servicio - Profesional</title>
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
    <?php include '../../includes/navbar-profesional.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #a2a2f4;">Ver Solicitudes de Servicio</h1>
        <!-- Filtros -->
        <form id="filtro-form">
            <label for="estado">Filtrar por estado:</label>
            <select id="estado" name="estado" class="form-control mb-3">
                <option value="todas">Todas</option>
                <option value="pendiente">Pendiente</option>
                <option value="en proceso">En Proceso</option>
                <option value="completada">Completada</option>
            </select>
            <button type="button" class="btn btn-primary" onclick="cargarSolicitudes()">Filtrar</button>
        </form>

        <div id="solicitudes" class="mt-4">
            <!-- Aquí se cargarán las solicitudes disponibles mediante AJAX -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        async function cargarSolicitudes() {
            const estado = document.getElementById("estado").value;

            try {
                const response = await fetch(`p-ver-soli-servicio.php?estado=${estado}`);
                const data = await response.json();
                const solicitudesDiv = document.getElementById("solicitudes");

                if (data.success) {
                    let html = "<ul class='list-group'>";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <li class="list-group-item">
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
                                <button class="btn btn-success mt-2" onclick="postularse(${solicitud.id_solicitud_servicio})">Postularme</button>
                            </li>
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
    <?php include '../../includes/footer-profesional.php'; ?>
</body>
</html>