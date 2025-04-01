<?php
session_start();
require_once '../config.php';

$id = intval($_GET['id']);
$languages = $mysqli->query("SELECT * FROM languages")->fetch_all(MYSQLI_ASSOC);
$stmt = $mysqli->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $language_id = intval($_POST['language_id']);
    $stmt = $mysqli->prepare("UPDATE categories SET name = ?, language_id = ? WHERE id = ?");
    $stmt->bind_param("sii", $name, $language_id, $id);
    $stmt->execute();
    header("Location: list_categories.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Categoría</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
  <h2>✏️ Editar Categoría</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Lenguaje</label>
      <select name="language_id" class="form-control">
        <?php foreach ($languages as $lang): ?>
          <option value="<?= $lang['id'] ?>" <?= $lang['id'] == $category['language_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($lang['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="btn btn-primary">Actualizar</button>
    <a href="list_categories.php" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>
