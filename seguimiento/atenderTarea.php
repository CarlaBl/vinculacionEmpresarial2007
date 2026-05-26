<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $report_id = $_GET['id'];

    $sql = "UPDATE reportes 
            SET estado = 'atendido',
                fecha_atendido = NOW()
            WHERE id = $report_id";
    mysqli_query($conn, $sql);
    header("Location: http://localhost:8084/?id=$report_id");
    exit;
}
?>