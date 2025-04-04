<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial de Solicitudes</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <style>
    @font-face {
      font-family: nexa;
      src: url('../../assets/fonts/title.ttf');
    }

    body {
      font-family: nexa;
      background-color: #e2f2ff !important;
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
    }

    .tarjeta-solicitud p {
      margin-bottom: 5px;
      color: #555;
    }

    .btn-trabajo {
      background-color: #3E93D6 !important;
      border-radius: 20px !important;
      color: #fff !important;
      font-weight: bold;
      padding: 6px 20px;
      border: none;
    }

    .btn-trabajo:hover {
      background-color: #3278a7 !important;
    }

    .modal-content {
      border-radius: 20px !important;
    }

    .modal-header {
      border-bottom: none;
    }

    .modal-footer {
      border-top: none;
    }
  </style>
</head>
<body>
  <?php include '../../includes/navbar-cliente.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-4" style="color: #3e93d6;">Historial de Solicitudes de Servicio</h1>
    <div id="historial"></div>
  </div>

  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">¿Estás seguro?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          Esta acción eliminará la solicitud de servicio permanentemente.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    let solicitudAEliminar = null;

    async function cargarHistorial() {
      try {
        const response = await fetch("c-historial-soli-servicio.php");
        const data = await response.json();
        const historialDiv = document.getElementById("historial");

        if (data.success) {
          let html = "";
          data.solicitudes.forEach(solicitud => {
            html += `
              <div class="tarjeta-solicitud">
                <h5>${solicitud.titulo}</h5>
                <p>${solicitud.descripcion}</p>
                <p><strong>Estado:</strong> ${solicitud.estado}</p>
                <p><strong>Horario:</strong> ${solicitud.horarios}</p>
                <p><strong>Método de Pago:</strong> ${solicitud.metodo_pago}</p>
                ${solicitud.foto ? `<img src="../../${solicitud.foto}" alt="Foto" style="max-width: 200px;" class="img-fluid rounded">` : "<p>Sin imagen</p>"}
                <div class="mt-3 d-flex gap-2">
                  <button class="btn btn-trabajo" onclick="verPostulaciones(${solicitud.id_solicitud_servicio})">Ver Postulaciones</button>
                  <button class="btn btn-outline-primary btn-sm" onclick="editarSolicitud(${solicitud.id_solicitud_servicio})">Editar</button>
                  <button class="btn btn-outline-danger btn-sm" onclick="mostrarConfirmacion(${solicitud.id_solicitud_servicio})">Eliminar</button>
                </div>
              </div>
            `;
          });
          historialDiv.innerHTML = html;
        } else {
          historialDiv.innerHTML = `<p>${data.message}</p>`;
        }
      } catch (error) {
        document.getElementById("historial").innerHTML = "<p>Error al cargar el historial</p>";
      }
    }

    function editarSolicitud(id) {
      window.location.href = `c-editar-soli-servicio-form.php?id_solicitud=${id}`;
    }

    function mostrarConfirmacion(id) {
      solicitudAEliminar = id;
      const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
      modal.show();
    }

    document.getElementById("confirmarEliminarBtn").addEventListener("click", async function () {
      if (solicitudAEliminar) {
        try {
          const response = await fetch(`c-eliminar-soli-servicio.php?id_solicitud=${solicitudAEliminar}`, {
            method: "POST"
          });
          const data = await response.json();
          if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById("confirmModal"));
            modal.hide();
            cargarHistorial();
          } else {
            alert("Error: " + data.message);
          }
        } catch (error) {
          alert("Error al eliminar la solicitud.");
        }
      }
    });

    async function verPostulaciones(id) {
      alert("Funcionalidad pendiente: ver postulaciones de solicitud ID " + id);
    }

    cargarHistorial();
  </script>

<?php include '../../includes/footer-cliente.php'; ?>
</body>
</html>
