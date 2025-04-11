<?php
session_start(); // <- Esto era lo que te faltaba 🔥

if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require("../../conexion.php"); // <- También asegúrate de conectar

$conexion = retornarConexion();

$id_solicitud = $_GET['id_solicitud'] ?? null;
if (!$id_solicitud) {
    echo "<p>Error: No se especificó la solicitud.</p>";
    exit;
}

$query = "SELECT p.id_postulacion_servicio, p.estado, p.fecha_postulacion, prof.nombre 
          FROM PostulacionServicio p
          JOIN Profesional prof ON p.id_profesional = prof.id_profesional
          WHERE p.id_solicitud_servicio = '$id_solicitud'";
$result = mysqli_query($conexion, $query);
$postulaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Postulaciones</title>
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
      background-color: #e2f2ff !important;
    }
    .tarjeta {
      background: #fff;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php include '../../includes/navbar-cliente.php'; ?>

  <div class="container mt-5">
    <h1 style="color:#3e93d6;">Postulaciones para la Solicitud #<?php echo $id_solicitud; ?></h1>

    <?php if (count($postulaciones) > 0): ?>
      <?php foreach ($postulaciones as $post): ?>
        <div class="tarjeta">
          <h5><i class="bi bi-person"></i> <?php echo $post['nombre']; ?></h5>
          <p><strong>Estado:</strong> <?php echo $post['estado']; ?></p>
          <p><strong>Fecha:</strong> <?php echo $post['fecha_postulacion']; ?></p>
          <div class="d-flex gap-2 align-items-center">
  <?php if ($post['estado'] === 'pendiente'): ?>
    <form action="c-aceptar-postulacion.php" method="POST">
      <input type="hidden" name="id_postulacion" value="<?php echo $post['id_postulacion_servicio']; ?>">
      <button class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Aceptar</button>
    </form>
    <form action="c-rechazar-postulacion.php" method="POST">
      <input type="hidden" name="id_postulacion" value="<?php echo $post['id_postulacion_servicio']; ?>">
      <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Rechazar</button>
    </form>
  <?php else: ?>
    <span class="badge bg-<?php echo $post['estado'] === 'aceptada' ? 'success' : 'danger'; ?> text-uppercase px-3 py-2">
      <?php echo ucfirst($post['estado']); ?>
    </span>
  <?php endif; ?>
</div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-center mt-5">
        <i class="bi bi-emoji-frown" style="font-size: 3rem; color:#aaa;"></i>
        <h5 class="text-muted">Aún no hay postulaciones para esta solicitud</h5>
      </div>
    <?php endif; ?>
  </div>

  <?php include '../../includes/footer-cliente.php'; ?>
</body>
</html>
