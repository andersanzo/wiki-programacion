<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';


// Obtener snippets
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
    <title>Dashboard | Admin</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1e1e1e;
            color: #fff;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 60px auto;
        }
        .card {
            background-color: #2c2c2c;
            border: 1px solid #444;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(255,255,255,0.1);
        }
        .card-title {
            color: #00ffff;
        }
        a.btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin - Wiki de Programación</span>
            <div>
            <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
            <a href="../index.php" class="btn btn-outline-light">Salir del Admin</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="container mt-4">
            <div class="card p-3 text-center">
                <h4 class="card-title">📄 Snippets</h4>
                <a href="add_snippet.php" class="btn btn-success">➕ Añadir</a>
                <a href="list_snippets.php" class="btn btn-primary mt-2">📋 Ver Todos</a>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card p-3 text-center">
                <h4 class="card-title">🗂️ Lenguajes</h4>
                <a href="add_language.php" class="btn btn-success">➕ Añadir</a>
                <a href="list_languages.php" class="btn btn-primary mt-2">📋 Ver Todos</a>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card p-3 text-center">
                <h4 class="card-title">📚 Categorías</h4>
                <a href="add_category.php" class="btn btn-success">➕ Añadir</a>
                <a href="list_categories.php" class="btn btn-primary mt-2">📋 Ver Todas</a>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-4">
    <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Lenguaje</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($snippets) > 0): ?>
                    <?php foreach ($snippets as $snip): ?>
                        <tr>
                            <td><?php echo $snip['id']; ?></td>
                            <td><?php echo htmlspecialchars($snip['title']); ?></td>
                            <td><?php echo htmlspecialchars($snip['language']); ?></td>
                            <td><?php echo htmlspecialchars($snip['category']); ?></td>
                            <td>
                                <a href="edit_snippet.php?id=<?php echo $snip['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_snippet.php?id=<?php echo $snip['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No hay snippets registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>

</html>
