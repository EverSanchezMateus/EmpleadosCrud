<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Crear conexión con MySQL
    $conn = new mysqli($servername, $username, $password);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Crear la base de datos 'sistema_empleados' si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS sistema_empleados";
    if ($conn->query($sql) === TRUE) {
        echo "Base de datos 'sistema_empleados' creada exitosamente.<br>";
    } else {
        echo "Error al crear la base de datos: " . $conn->error . "<br>";
    }
    
    // Seleccionar la base de datos 'sistema_empleados'
    $conn->select_db('sistema_empleados');
    
    // Crear la tabla 'empleados' si no existe
    $sql = "CREATE TABLE IF NOT EXISTS empleados (
        codigo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        apellido VARCHAR(100) NOT NULL,
        documento_identidad BIGINT NOT NULL UNIQUE,
        direccion VARCHAR(255),
        email VARCHAR(255),
        telefono BIGINT,
        foto LONGBLOB,
        estado VARCHAR(255) NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Tabla 'empleados' creada exitosamente.<br>";
    } else {
        echo "Error al crear la tabla: " . $conn->error . "<br>";
    }
    
    // Cerrar la conexión
    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
