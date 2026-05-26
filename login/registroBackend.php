<?php

$conn = new mysqli(
    "mysql",
    "root",
    "root123",
    "appdb"
);

if ($conn->connect_error) {
    die("Error de conexion");
}

if (
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['password2'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password == $password2) {

        $sql = "INSERT INTO users (
                    email,
                    password
                ) VALUES (
                    '$email',
                    '$password'
                )";

        if ($conn->query($sql) === TRUE) {
            //echo "Usuario registrado";
        } else {
            //echo "Error al registrar";
        }
            header("Location: index.php");
            exit();

    } else {

        // echo "Las contraseñas no coinciden";
        header("Location: index.php");
        exit();

    }

}

?>