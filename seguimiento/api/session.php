<?php
session_start();

require_once 'conexion.php';

if (!isset($_SESSION['session'])) {

    if (!isset($_GET['session']) || empty($_GET['session'])) {
        header("Location: http://localhost:8081/");
        exit;
    }

    $session = $_GET['session'];

    $query = "SELECT id, email, session, role 
              FROM users 
              WHERE session = '$session' 
              LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['session'] = $user['session'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

    } else {

        header("Location: http://localhost:8081/");
        exit;

    }
}
//validamos si mode esta creada en una variable de session 
if (!isset($_SESSION['mode'])) {
    //si no existe se asigna el valor por defecto
    $_SESSION['mode'] = 'light';
    //si mode existe se guarda 
    if (isset($_GET['mode'])) {
        $_SESSION['mode'] = $_GET['mode'];
    }
}else{
    //si mode existe se guarda 
    if (isset($_GET['mode'])) {
        $_SESSION['mode'] = $_GET['mode'];
    }
}




?>