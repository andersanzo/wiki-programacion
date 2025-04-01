<?php
session_start();
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $mysqli->prepare("DELETE FROM languages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: list_languages.php");
exit;
