<?php
// config.php
$host = 'localhost';
$user = 'root';
$password = ''; // Actualiza según tu configuración
$dbname = 'wiki_programacion';

$mysqli = new mysqli($host, $user, $password, $dbname); // Conexión a la base de datos

if ($mysqli->connect_error) {
    die('Error de conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
