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
        }
    </style>
</head>
<body>
    <?php include '../../includes/navbar-cliente.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #3e93d6;">Ver Solicitudes de Trabajo</h1>

        <!-- Filtros -->
        <form id="filtro-form" class="mb-4">
            <label for="categoria">Filtrar por categoría:</label>
            <select id="categoria" name="categoria" class="form-control">
                <option value="todas">Todas</option>
                <option value="electricidad">Electricidad</option>
                <option value="plomería">Plomería</option>
                <option value="carpintería">Carpintería</option>
                <option value="limpieza">Limpieza</option>
            </select>
            <button type="button" class="btn btn-primary mt-2" onclick="cargarSolicitudes()">Filtrar</button>
        </form>

        <div id="solicitudes">
            <!-- Aquí se cargarán las solicitudes mediante AJAX -->
        </div>
    </div>

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
                    let html = "<ul class='list-group'>";
                    data.solicitudes.forEach(solicitud => {
                        html += `
                            <li class="list-group-item">
                                <h3>${solicitud.titulo}</h3>
                                <p>${solicitud.descripcion}</p>
                                <p><strong>Categoría:</strong> ${solicitud.categoria}</p>
                                <p><strong>Tarifa:</strong> ${solicitud.tarifa}</p>
                                ${
                                    solicitud.foto
                                    ? `<img src="../../${solicitud.foto}" alt="Imagen del trabajo" class="img-fluid" style="max-width: 200px;">`
                                    : "<p>Sin imagen</p>"
                                }
                                <button class="btn btn-success mt-2" onclick="pedirTrabajo(${solicitud.id_solicitud_trabajo})">Pedir Trabajo</button>
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
