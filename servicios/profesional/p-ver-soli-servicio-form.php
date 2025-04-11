<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ver Solicitudes de Servicio - Profesional</title>
  <link rel="stylesheet" href="../../includes/footer-styles.css">

  <link rel="stylesheet" href="../../includes/footer-profesional.php">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    @font-face {
      font-family: nexa;
      src: url('../../assets/fonts/title.ttf');
    }

    body {
      font-family: nexa;
      
    }

    .custom-input {
      border-radius: 30px !important;
      padding: 10px 15px;
      border: 1px solid #ccc;
    }

    .btn-primary {
      border-radius: 50px !important;
      background-color: #a2a2f4 !important;
      border: none;
    }

    .btn-primary:hover {
      background-color: #7b7bff !important;
    }

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

    .btn-postular {
      background-color: #a2a2f4 !important;
      border-radius: 20px;
      padding: 8px 20px;
      font-weight: bold;
      border: none;
      color: white !important;
      display: inline-block;
      transition: background-color 0.3s ease;
    }

    .btn-postular:hover {
      background-color: #7b7bff !important;
    }
  </style>
</head>
<body>
  <?php include '../../includes/navbar-profesional.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-4" style="color: #a2a2f4;">Ver Solicitudes de Servicio</h1>

    <!-- Filtros -->
    <form id="filtro-form" class="mb-4">
      <label for="estado" class="fw-bold mb-2">Filtrar por estado</label>
      <div class="input-group">
        <select id="estado" name="estado" class="form-control custom-input">
          <option value="todas">Todas</option>
          <option value="pendiente">Pendiente</option>
          <option value="en proceso">En Proceso</option>
          <option value="completada">Completada</option>
        </select>
        <button type="button" class="btn btn-primary ms-3" onclick="cargarSolicitudes()">Filtrar</button>
      </div>
    </form>

    <div id="solicitudes"></div>
  </div>

  <script>
    async function cargarSolicitudes() {
      const estado = document.getElementById("estado").value;
      try {
        const response = await fetch(`p-ver-soli-servicio.php?estado=${estado}`);
        const data = await response.json();
        const solicitudesDiv = document.getElementById("solicitudes");

        if (data.success) {
          let html = "";
          data.solicitudes.forEach(solicitud => {
            html += `
              <div class="tarjeta-solicitud">
                <h5>${solicitud.titulo}</h5>
                <p>${solicitud.descripcion}</p>
                <p><strong>Categoría:</strong> ${solicitud.categoria || 'Sin categoría'}</p>
                <p><strong>Estado:</strong> ${solicitud.estado}</p>
                <p><strong>Horario:</strong> ${solicitud.horarios}</p>
                <p><strong>Método de Pago:</strong> ${solicitud.metodo_pago}</p>
                ${solicitud.foto ? `<img src="../../${solicitud.foto}" alt="Foto" style="max-width: 200px;" class="img-fluid rounded mb-2">` : "<p>Sin imagen</p>"}
                <div class="d-flex justify-content-end">
                  <button class="btn btn-postular" onclick="postularse(${solicitud.id_solicitud_servicio})">
                    <i class="bi bi-person-plus"></i> Postularme
                  </button>
                </div>
              </div>
            `;
          });
          solicitudesDiv.innerHTML = html;
        } else {
          solicitudesDiv.innerHTML = `<p class="text-muted">${data.message}</p>`;
        }
      } catch (error) {
        document.getElementById("solicitudes").innerHTML = "<p>Error al cargar las solicitudes</p>";
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

    cargarSolicitudes();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <?php include '../../includes/footer-profesional.php'; ?>
</body>
</html>
