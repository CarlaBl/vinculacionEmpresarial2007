<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $report_id = $_POST['report_id'];
    $user_id = $_POST['user_asig'];
    $comments = $_POST['comments'];

    $sql = "UPDATE reportes 
            SET status_asignado = 1,
                id_user_asignado = $user_id,
                fecha_asignado = NOW(),
                comentarios_asignado = '$comments'
            WHERE id = $report_id";

    mysqli_query($conn, $sql);
    header("Location: http://localhost:8084/?id=$report_id");
    exit;
}
?>