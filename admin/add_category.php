<?php
session_start();
require_once '../config.php';

$languages = $mysqli->query("SELECT * FROM languages")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $language_id = intval($_POST['language_id']);
    if ($name !== '') {
        $stmt = $mysqli->prepare("INSERT INTO categories (name, language_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $language_id);
        $stmt->execute();
        header("Location: list_categories.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir Categoría</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
  <h2>➕ Añadir Categoría</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nombre de la Categoría</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Lenguaje</label>
      <select name="language_id" class="form-control" required>
        <?php foreach ($languages as $lang): ?>
          <option value="<?= $lang['id'] ?>"><?= htmlspecialchars($lang['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>
