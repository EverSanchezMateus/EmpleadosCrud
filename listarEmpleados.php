<?php
include 'db.php'; // Asegúrate de que 'db.php' contiene la conexión a la base de datos usando mysqli

header('Content-Type: application/json');

// Preparar la consulta SQL para seleccionar todos los empleados
$sql = "SELECT codigo, nombre, apellido, documento_identidad, direccion, email, telefono, estado FROM empleados";

if ($stmt = $conn->prepare($sql)) {
    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();
    $empleados = [];

    // Recorrer los resultados y guardarlos en un array
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }

    // Devolver los datos en formato JSON
    echo json_encode($empleados);

    // Cerrar el statement
    $stmt->close();
} else {
    echo json_encode(['error' => "Error al preparar la consulta: " . $conn->error]);
}

// Cerrar la conexión
$conn->close();
