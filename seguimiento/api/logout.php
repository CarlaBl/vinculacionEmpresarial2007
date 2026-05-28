<?php
//cerrar sesión
session_start();
//guardamos la variable mode si existe 
$mode = isset($_SESSION['mode']) ? $_SESSION['mode'] : 'light';
require_once 'conexion.php';

if (isset($_SESSION['id'])) {

    $userId = (int)$_SESSION['id'];

    $query = "UPDATE users 
              SET session = NULL 
              WHERE id = $userId";

    mysqli_query($conn, $query);
}

session_unset();
session_destroy();
header('Content-Type: application/json');

echo json_encode([
    'success' => true
]);

exit;
?>