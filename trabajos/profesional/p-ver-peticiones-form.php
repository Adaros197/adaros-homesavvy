<?php
session_start();

if (!isset($_SESSION['profesional_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require("../../conexion.php");
$conexion = retornarConexion();

$id_solicitud = $_GET['id_solicitud'] ?? null;
if (!$id_solicitud) {
    echo "<p>Error: No se especificó la solicitud.</p>";
    exit;
}

$query = "SELECT p.id_peticion_trabajo, p.estado, p.fecha_peticion, c.nombre AS nombre_cliente
          FROM PeticionTrabajo p
          JOIN Cliente c ON p.id_cliente = c.id_cliente
          WHERE p.id_solicitud_trabajo = '$id_solicitud'";
$result = mysqli_query($conexion, $query);
$peticiones = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peticiones</title>
  <link rel="icon" href="../../assets/img/hd.png" sizes="16x16" type="image/png">
  <link rel="stylesheet" href="../../includes/footer-styles.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    @font-face {
      font-family: nexa;
      src: url('../../assets/fonts/title.ttf');
    }
    body {
      font-family: nexa;
      background-color: #f5f5fd !important;
    }
    .tarjeta {
      background: #fff;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .btn-sm {
      border-radius: 20px;
    }
  </style>
</head>
<body>
  <?php include '../../includes/navbar-profesional.php'; ?>

  <div class="container mt-5">
    <h1 style="color:#a2a2f4;">Peticiones para la Solicitud #<?php echo $id_solicitud; ?></h1>

    <?php if (count($peticiones) > 0): ?>
      <?php foreach ($peticiones as $pet): ?>
        <div class="tarjeta">
          <h5><i class="bi bi-person"></i> <?php echo $pet['nombre_cliente']; ?></h5>
          <p><strong>Estado:</strong> <?php echo $pet['estado']; ?></p>
          <p><strong>Fecha:</strong> <?php echo $pet['fecha_peticion']; ?></p>
          <div class="d-flex gap-2 align-items-center">
            <?php if ($pet['estado'] === 'pendiente'): ?>
              <form action="p-aceptar-peticion.php" method="POST">
                <input type="hidden" name="id_peticion" value="<?php echo $pet['id_peticion_trabajo']; ?>">
                <button class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Aceptar</button>
              </form>
              <form action="p-rechazar-peticion.php" method="POST">
                <input type="hidden" name="id_peticion" value="<?php echo $pet['id_peticion_trabajo']; ?>">
                <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Rechazar</button>
              </form>
            <?php else: ?>
              <span class="badge bg-<?php echo $pet['estado'] === 'aceptada' ? 'success' : 'danger'; ?> text-uppercase px-3 py-2">
                <?php echo ucfirst($pet['estado']); ?>
              </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-center mt-5">
        <i class="bi bi-emoji-frown" style="font-size: 3rem; color:#aaa;"></i>
        <h5 class="text-muted">Aún no hay peticiones para esta solicitud</h5>
      </div>
    <?php endif; ?>
  </div>

  <?php include '../../includes/footer-profesional.php'; ?>
</body>
</html>
