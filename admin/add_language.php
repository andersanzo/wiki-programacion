<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $mysqli->prepare("INSERT INTO languages (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        header("Location: list_languages.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir Lenguaje</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
  <div class="container mt-5">
    <h2 class="text-center">➕ Añadir Lenguaje</h2>
    <form method="POST" class="mt-4">
      <div class="mb-3">
        <label class="form-label">Nombre del Lenguaje</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <button class="btn btn-success">Guardar</button>
      <a href="dashboard.php" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</body>
</html>
