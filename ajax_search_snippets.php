<?php
// ajax_search_snippets.php
require_once 'config.php';

$language_id = isset($_GET['lang']) ? intval($_GET['lang']) : 0;
$category_id = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
$query = isset($_GET['q']) ? $_GET['q'] : '';

if ($language_id === 0 || $category_id === 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT * FROM snippets WHERE language_id = ? AND category_id = ?";
$params = [$language_id, $category_id];
$types = "ii";

if ($query !== '') {
    // Para buscar en title, description o code
    $sql .= " AND (title LIKE ? OR description LIKE ? OR code LIKE ?)";
    $query_like = "%" . $query . "%";
    $params[] = $query_like;
    $params[] = $query_like;
    $params[] = $query_like;
    $types .= "sss";
}

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    echo json_encode([]);
    exit;
}

// Para versiones de PHP 5.6 en adelante podemos usar el operador "splat":
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$snippets = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($snippets);
?>
