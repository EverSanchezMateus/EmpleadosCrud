<?php
$servername = "localhost";
$username = "root";
$password = "maleja2024*";
$dbname = "sistema_empleados";

$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// La conexión fue exitosa
echo "Conexión exitosa";
