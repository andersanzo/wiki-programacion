<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$result = $mysqli->query("SELECT c.id, c.name, l.name AS language FROM categories c JOIN languages l ON c.language_id = l.id");
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Categorías | Admin</title>
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
    <h2 class="mb-4 text-center">📚 Gestión de Categorías</h2>
    <div class="mb-3 text-end">
        <a href="dashboard.php" class="btn btn-outline-light">⬅ Volver</a>
    </div>
    <table class="table table-dark table-bordered table-striped">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Lenguaje</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td><?= $cat['id'] ?></td>
            <td><?= htmlspecialchars($cat['name']) ?></td>
            <td><?= htmlspecialchars($cat['language']) ?></td>
            <td>
              <a href="edit_category.php?id=<?= $cat['id'] ?>" class="btn btn-sm btn-primary">✏️</a>
              <a href="delete_category.php?id=<?= $cat['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar categoría?')">🗑️</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
