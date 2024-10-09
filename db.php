<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_empleados";


// Crear conexión
$conn = new mysql($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
