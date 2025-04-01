<?php
require_once 'config.php';

if (!isset($_GET['q'])) {
    echo json_encode([]);
    exit;
}

$search = "%" . $_GET['q'] . "%";
$results = [];

// Buscar en lenguajes
$stmt = $mysqli->prepare("SELECT id, name FROM languages WHERE name LIKE ? LIMIT 5");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $results[] = [
        "name" => "📌 Lenguaje: " . htmlspecialchars($row['name']),
        "url" => "language.php?id=" . $row['id']
    ];
}

// Buscar en categorías
$stmt = $mysqli->prepare("SELECT id, name, language_id FROM categories WHERE name LIKE ? LIMIT 5");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $results[] = [
        "name" => "📂 Categoría: " . htmlspecialchars($row['name']),
        "url" => "category.php?lang=" . $row['language_id'] . "&cat=" . $row['id']
    ];
}

// Buscar en snippets
$stmt = $mysqli->prepare("SELECT id, title, language_id, category_id FROM snippets WHERE title LIKE ? OR description LIKE ? OR code LIKE ? LIMIT 10");
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $results[] = [
        "name" => "💻 Snippet: " . htmlspecialchars($row['title']),
        "url" => "category.php?lang=" . $row['language_id'] . "&cat=" . $row['category_id']
    ];
}

echo json_encode($results);
?>
