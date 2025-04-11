<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Perfil - Profesional</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../includes/footer-styles.css">
  <style>
    @font-face {
      font-family: nexa;
      src: url('../assets/fonts/title.ttf');
    }

    body {
      font-family: nexa;
      background-color: #f4f5ff;
    }

    h3 {
      color: #a2a2f4 !important;
    }

    .form-container form {
      transition: all 0.4s ease-in-out !important;
      opacity: 0;
      max-height: 0;
      overflow: hidden;
    }

    .form-container form.show {
      opacity: 1;
      max-height: 1000px;
    }

    .btn-link {
      position: relative;
      text-decoration: none !important;
    }

    .btn-link::after {
      content: "";
      position: absolute;
      left: 50%;
      bottom: 0;
      width: 0;
      height: 2px;
      background-color: #a2a2f4;
      transition: all 0.3s ease-in-out;
      transform: translateX(-50%);
    }

    .btn-link:hover::after {
      width: 100%;
      left: 0;
      transform: translateX(0);
    }

    .quick-access-card {
      border: 1px solid #dee2e6;
      border-radius: 1rem !important;
      padding: 1.5rem;
      background-color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .quick-access-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .quick-access-link {
      font-weight: bold;
      font-size: 1rem;
      color: #a2a2f4 !important;
      text-decoration: none !important;
      position: relative;
      display: inline-block;
      padding-bottom: 4px;
    }

    .quick-access-link::after {
      content: "";
      position: absolute;
      left: 50%;
      bottom: 0;
      width: 0;
      height: 2px;
      background-color: #a2a2f4 !important;
      transition: all 0.3s ease-in-out;
      transform: translateX(-50%);
    }

    .quick-access-link:hover::after {
      width: 100%;
      left: 0;
      transform: translateX(0);
    }

    @media (max-width: 767px) {
      .quick-access-card {
        margin-top: 2rem;
      }
    }

    .cerrar {
      background-color: #a2a2f4;
      color: #ffffff !important;
      border-radius: 20px !important;
    }

    .cerrar:hover {
      background-color: #8888f3 !important;
      transition: .3s;
    }
  </style>
</head>
<body>
  <?php include '../includes/navbar-profesional.php'; ?>

  <div class="container mt-5">
    <h1 class="mb-2" style="color: #a2a2f4;">Gestión de Perfil - Profesional</h1>

    <div class="row align-items-start">
      <!-- Columna izquierda - información editable -->
      <div class="col-lg-8 col-12 mb-4">
        <?php include 'editar-perfil.php'; ?>
        <?php include 'p-formulario-perfil.php'; ?>
      </div>

      <!-- Columna derecha - accesos rápidos + cerrar sesión -->
      <div class="col-lg-4 col-12 mt-5">
        <div class="quick-access-card">
          <h5 class="text-dark fw-bold mb-4">Accesos Rápidos</h5>

          <div class="mb-3">
            <a href="#" class="quick-access-link">Ver Servicios Disponibles</a>
          </div>
          <div class="mb-3">
            <a href="#" class="quick-access-link">Servicios Asignados</a>
          </div>
          <div class="mb-3">
            <a href="#" class="quick-access-link">Historial</a>
          </div>
        </div>

        <!-- Cerrar sesión -->
        <form action="../auth/logout.php" method="POST" class="mt-4 text-center">
          <button type="submit" class="btn cerrar col-12" style="font-family: nexa;">
            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
          </button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function toggleEdit(id) {
      const form = document.getElementById(id);
      if (form.classList.contains('show')) {
        form.classList.remove('show');
        setTimeout(() => {
          form.classList.add('d-none');
        }, 400);
      } else {
        form.classList.remove('d-none');
        setTimeout(() => {
          form.classList.add('show');
        }, 10);
      }
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const alerta = document.querySelector(".alert-success, .alert-danger");
      if (alerta) {
        setTimeout(() => {
          alerta.classList.add("fade-out-up");
          setTimeout(() => {
            alerta.remove();
          }, 700);
        }, 3000);
      }
    });
  </script>

  <?php include '../includes/footer-profesional.php'; ?>
</body>
</html>
