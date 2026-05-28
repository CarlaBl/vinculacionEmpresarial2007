<?php
// guardar reporte en la base de datos
session_start();
require_once 'conexion.php';

// Verifica si hay sesión activa
if (!isset($_SESSION['session'])) {
    header("Location: login.php");
    exit();
}

// Verifica que el formulario se haya enviado por POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode']);
    exit();
}
$iluminacion = isset($_POST['lighting']) ? 1 : 0;
$equipo = isset($_POST['equipment']) ? 1 : 0;
$comentarios = isset($_POST['comments']) ? $_POST['comments'] : '';


// Consulta SQL
$sql = "INSERT INTO reportes (
    reportero_nombre, 
    fecha_inspeccion,
    tipo_prioridad,
    turno,
    tipo_ubicacion, 
    edificio, 
    aula_seccion, 
    limpieza, 
    seguridad, 
    iluminacion_funcional, 
    equipo_operativo, 
    comentarios
) VALUES (
    '" . mysqli_real_escape_string($conn, $_POST['reporter_name']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['report_date']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['priority_type']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['turn']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['location_type']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['building']) . "',
    '" . mysqli_real_escape_string($conn, $_POST['room']) . "',
    '" . intval($_POST['cleanliness']) . "',
    '" . intval($_POST['safety']) . "',
    '$iluminacion',
    '$equipo',
    '" . mysqli_real_escape_string($conn, $comentarios) . "'
)";

if (mysqli_query($conn, $sql)) {
    //echo "Reporte insertado correctamente. ID: " . mysqli_insert_id($conn);
} else {
    //echo "Error al insertar: " . mysqli_error($conn);
}
// Redireccionar de vuelta al formulario
header("Location: http://localhost:8082/?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode']);
exit();
?>