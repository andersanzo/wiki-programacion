<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$query = "SELECT s.id, s.title, l.name AS language, c.name AS category 
          FROM snippets s
          JOIN languages l ON s.language_id = l.id
          JOIN categories c ON s.category_id = c.id";
$result = $mysqli->query($query);
$snippets = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Snippets | Admin</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #1e1e1e;
      color: white;
    }
    .container {
      margin-top: 40px;
    }
    .table {
      background-color: #2c2c2c;
    }
    .table th,
    .table td {
      vertical-align: middle;
    }
    .btn-sm {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4 text-center">📄 Gestión de Snippets</h2>
    <div class="mb-3 text-end">
        <a href="dashboard.php" class="btn btn-outline-light">⬅ Volver al Panel</a>
    </div>
    <table class="table table-dark table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Lenguaje</th>
          <th>Categoría</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($snippets as $snip): ?>
          <tr>
            <td><?= $snip['id'] ?></td>
            <td><?= htmlspecialchars($snip['title']) ?></td>
            <td><?= htmlspecialchars($snip['language']) ?></td>
            <td><?= htmlspecialchars($snip['category']) ?></td>
            <td>
              <a href="edit_snippet.php?id=<?= $snip['id'] ?>" class="btn btn-sm btn-primary">✏️ Editar</a>
              <a href="delete_snippet.php?id=<?= $snip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este snippet?')">🗑️ Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
