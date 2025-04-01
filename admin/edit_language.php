<?php
session_start();
require_once '../config.php';

if (!isset($_GET['id'])) header("Location: list_languages.php");

$id = intval($_GET['id']);
$stmt = $mysqli->prepare("SELECT * FROM languages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$lang = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $stmt = $mysqli->prepare("UPDATE languages SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    header("Location: list_languages.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Lenguaje</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
  <div class="container mt-5">
    <h2>✏️ Editar Lenguaje</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($lang['name']) ?>" required>
      </div>
      <button class="btn btn-primary">Actualizar</button>
      <a href="list_languages.php" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</body>
</html>
