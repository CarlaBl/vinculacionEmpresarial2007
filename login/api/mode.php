<?php
session_start();

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