<?php
header('Content-Type: application/json');

// Obtener el contenido JSON de la solicitud
$input = json_decode(file_get_contents('php://input'), true);

// Verificar que se hayan enviado los datos necesarios
if (isset($input['servername'], $input['username'])) {
    $servername = $input['servername'];
    $username = $input['username'];
    $password = $input['password'];
}

$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comando SQL para crear la base de datos sistema_empleados
$sql_create_db = "CREATE DATABASE IF NOT EXISTS sistema_empleados";

if ($conn->query($sql_create_db) === TRUE) {
    echo "Base de datos sistema_empleados creada exitosamente<br>";
} else {
    echo "Error al crear la base de datos sistema_empleados: " . $conn->error . "<br>";
}

// Seleccionar la base de datos sistema_empleados
$conn->select_db("sistema_empleados");

// Comando SQL para crear la tabla empleados
$sql_create_table = "CREATE TABLE IF NOT EXISTS empleados (
    codigo INT(6)  AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    documento_identidad BIGINT NOT NULL,
    direccion VARCHAR(255),
    email VARCHAR(255),
    telefono BIGINT,
    foto BLOB,
    estado VARCHAR(50) DEFAULT 'activo'
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Tabla empleados creada exitosamente";
} else {
    echo "Error al crear la tabla empleados: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>