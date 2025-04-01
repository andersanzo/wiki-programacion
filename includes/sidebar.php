<?php
require_once __DIR__ . '/../config.php';

// Obtener la lista de lenguajes
$query = "SELECT * FROM languages";
$result = $mysqli->query($query);
$languages = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="sidebar">
<h4>👻 Lenguajes 👻</h4>
<a href="admin/login.php" class="btn btn-dark w-100 mb-2">🗝 Administración 🗝</a>
    <?php foreach ($languages as $lang): ?>
      <a href="language.php?id=<?php echo $lang['id']; ?>" class="btn btn-dark w-100 mb-2">
        <?php echo htmlspecialchars($lang['name']); ?>
      </a>
    <?php endforeach; ?>
  </div>

<style>
    body {
      background-color: #f8f9fa;
      display: flex;
    }
    .sidebar {
      height: 100vh;
      width: 260px;
      background-color: #212529;
      padding: 20px;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      overflow-y: auto;
    }
    .sidebar h4 {
      color: white;
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
</style>
