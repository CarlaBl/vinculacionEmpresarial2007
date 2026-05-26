<?php

$conn = new mysqli(
    "mysql",
    "root",
    "root123",
    "appdb"
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>