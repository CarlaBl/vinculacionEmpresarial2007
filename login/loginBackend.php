<?php

session_start();

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
    isset($_POST['password'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT *
            FROM users
            WHERE email = '$email'
            AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        // Concatenar email y contrasena con timestamp para evitar colisiones
        $sessionData = $user['email'] . $user['password'] . time() . $user['id'];

        // Encriptar con SHA256
        $hashedSession = hash('sha256', $sessionData);

        // Actualizar solo la columna session donde el id coincide
        $updateSession = $updateSession = "UPDATE users SET session = '$hashedSession' WHERE id = {$user['id']}";
        
        $conn->query($updateSession);

        echo json_encode([
            "success" => true,
            "id" => $user['id'],
            "email" => $user['email'],
            "session" => $hashedSession
        ]);


    } else {

        echo json_encode([
            "success" => false
        ]);

    }

}

?>