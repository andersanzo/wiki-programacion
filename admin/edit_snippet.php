<?php
session_start();
require_once '../config.php';

$id = intval($_GET['id']);
$languages = $mysqli->query("SELECT * FROM languages")->fetch_all(MYSQLI_ASSOC);
$categories = $mysqli->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
$stmt = $mysqli->prepare("SELECT * FROM snippets WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$snippet = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $language_id = $_POST['language_id'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $code = $_POST['code'];

    $stmt = $mysqli->prepare("UPDATE snippets SET title = ?, language_id = ?, category_id = ?, description = ?, code = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("siissi", $title, $language_id, $category_id, $description, $code, $id);
    $stmt->execute();
    header("Location: list_snippets.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Snippet</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #1e1e1e; color: #fff; }
    textarea.code {
      font-family: 'Courier New', monospace;
      background-color: #1e1e1e;
      color: #00ff88;
      padding: 15px;
      border-radius: 6px;
      width: 100%;
      border: 1px solid #444;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>✏️ Editar Snippet</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Título</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($snippet['title']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Lenguaje</label>
        <select name="language_id" class="form-control" required>
          <?php foreach ($languages as $lang): ?>
            <option value="<?= $lang['id'] ?>" <?= $lang['id'] == $snippet['language_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($lang['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Categoría</label>
        <select name="category_id" class="form-control" required>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $snippet['category_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Descripción</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($snippet['description']) ?></textarea>
      </div>
      <div class="mb-3">
        <label>Código</label>
        <textarea name="code" class="code" rows="10"><?= htmlspecialchars($snippet['code']) ?></textarea>
      </div>
      <button class="btn btn-primary">Actualizar</button>
      <a href="list_snippets.php" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</body>
</html>
