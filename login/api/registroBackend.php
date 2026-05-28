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
    isset($_POST['password2']) && 
    isset($_POST['role_type'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $role_type = $_POST['role_type'];

    if ($password == $password2) {

        $sql = "INSERT INTO users (
                    email,
                    password,
                    role
                ) VALUES (
                    '$email',
                    '$password', 
                    '$role_type'
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