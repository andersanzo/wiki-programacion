<?php
session_start();
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $mysqli->prepare("DELETE FROM snippets WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: list_snippets.php");
exit;
