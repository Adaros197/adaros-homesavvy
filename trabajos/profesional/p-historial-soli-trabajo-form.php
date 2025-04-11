<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial de Solicitudes de Trabajo - Profesional</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../../includes/footer-styles.css" />
  <style>
    @font-face {
      font-family: nexa;
      src: url('../../assets/fonts/title.ttf');
    }

    body {
      font-family: nexa;
      background-color: #f5f7ff;
    }

    .tarjeta-solicitud {
      border: 1px solid #ddd;
      border-radius: 20px;
      padding: 20px;
      margin-bottom: 20px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .tarjeta-solicitud h5 {
      font-weight: bold;
      margin-bottom: 5px;
      color: #a2a2f4;
    }

    .tarjeta-solicitud p {
      margin-bottom: 5px;
      color: #555;
    }

    .btn-trabajo {
      background-color: #a2a2f4 !important;
      border-radius: 20px !important;
      color: #fff !important;
      font-weight: bold;
      padding: 6px 20px;
      border: none;
    }

    .btn-trabajo:hover {
      background-color: #8282d4 !important;
    }

    .btn-outline-primary,
    .btn-outline-danger {
      border-radius: 20px !important;
    }

    .img-thumbnail {
      max-width: 200px;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <?php include '../../includes/navbar-profesional.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-4" style="color: #a2a2f4;">Historial de Solicitudes de Trabajo</h1>
    <div id="historial"></div>
  </div>
  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel" style="color: #a2a2f4;">¿Estás seguro?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          Esta acción eliminará la solicitud de trabajo permanentemente.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function cargarHistorial() {
      try {
        const response = await fetch("p-historial-soli-trabajo.php");
        const data = await response.json();
        const historialDiv = document.getElementById("historial");

        if (data.success && data.solicitudes.length > 0) {
          let html = "";
          data.solicitudes.forEach(solicitud => {
            html += `
              <div class="tarjeta-solicitud">
                <h5>${solicitud.titulo}</h5>
                <p>${solicitud.descripcion}</p>
                <p><strong>Categoría:</strong> ${solicitud.categoria || 'Sin categoría'}</p>
                <p><strong>Tarifa:</strong> $${solicitud.tarifa}</p>
                <p><strong>Horario:</strong> ${solicitud.horarios}</p>
                <p><strong>Método de Pago:</strong> ${solicitud.metodo_pago}</p>
                <p><strong>Estado:</strong> ${solicitud.estado}</p>
                ${solicitud.foto 
                    ? `<img src="../../${solicitud.foto}" alt="Foto" class="img-thumbnail" style="max-width: 200px;">` 
                    : "<p><em>Sin imagen</em></p>"}

                <div class="mt-3 d-flex justify-content-end gap-2">
                  <button class="btn btn-trabajo" onclick="verPeticiones(${solicitud.id_solicitud_trabajo})">
                    <i class="bi bi-person-lines-fill me-1"></i> Ver Peticiones
                  </button>
                  <button class="btn btn-outline-primary btn-sm" onclick="editarSolicitud(${solicitud.id_solicitud_trabajo})">
                    <i class="bi bi-pencil-square me-1"></i> Editar
                  </button>
                  <button class="btn btn-outline-danger btn-sm" onclick="eliminarSolicitud(${solicitud.id_solicitud_trabajo})">
                    <i class="bi bi-trash3 me-1"></i> Eliminar
                  </button>
                </div>
              </div>
            `;
          });
          historialDiv.innerHTML = html;
        } else {
          historialDiv.innerHTML = `
            <div class="text-center mt-5">
              <i class="bi bi-arrow-repeat icon-spin mb-3" style="font-size: 3rem; color:#a2a2f4;"></i>
              <h4 class="text-muted">Aún no has subido solicitudes de trabajo</h4>
              <p class="text-muted">Cuando publiques una solicitud, aparecerá aquí.</p>
            </div>
          `;
        }
      } catch (error) {
        document.getElementById("historial").innerHTML = "<p>Error al cargar el historial</p>";
      }
    }

    function editarSolicitud(id) {
      window.location.href = `p-editar-soli-trabajo-form.php?id_solicitud=${id}`;
    }

    function verPeticiones(id) {
      window.location.href = `p-ver-peticiones-form.php?id_solicitud=${id}`;
    }

    let solicitudAEliminar = null;

function eliminarSolicitud(id) {
  solicitudAEliminar = id;
  const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
  modal.show();
}

document.getElementById("confirmarEliminarBtn").addEventListener("click", async function () {
  if (solicitudAEliminar) {
    try {
      const response = await fetch(`p-eliminar-soli-trabajo.php?id_solicitud=${solicitudAEliminar}`, {
        method: "POST"
      });
      const data = await response.json();

      const modal = bootstrap.Modal.getInstance(document.getElementById("confirmModal"));
      modal.hide();

      if (data.success) {
        cargarHistorial();
      } else {
        alert("Error: " + data.message);
      }
    } catch (error) {
      alert("Error al eliminar la solicitud.");
    }
  }
});


    cargarHistorial();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <?php include '../../includes/footer-profesional.php'; ?>
</body>
</html>
