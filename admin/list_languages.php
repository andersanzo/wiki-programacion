<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$result = $mysqli->query("SELECT * FROM languages");
$languages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lenguajes | Admin</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #1e1e1e; color: white; }
    .container { margin-top: 40px; }
    .table { background-color: #2c2c2c; }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4 text-center">🗂️ Gestión de Lenguajes</h2>
    <div class="mb-3 text-end">
        <a href="dashboard.php" class="btn btn-outline-light">⬅ Volver</a>
    </div>
    <table class="table table-dark table-bordered table-striped">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($languages as $lang): ?>
          <tr>
            <td><?= $lang['id'] ?></td>
            <td><?= htmlspecialchars($lang['name']) ?></td>
            <td>
              <a href="edit_language.php?id=<?= $lang['id'] ?>" class="btn btn-sm btn-primary">✏️</a>
              <a href="delete_language.php?id=<?= $lang['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar lenguaje?')">🗑️</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
