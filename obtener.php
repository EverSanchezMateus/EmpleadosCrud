<?php
include 'db.php'; // Conexión a la base de datos

// Obtener los datos enviados en la solicitud (JSON) y decodificarlos
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['codigo'])) {
    $codigo = $data['codigo'];

    // Preparar la consulta para obtener los datos del empleado según el código proporcionado
    $stmt = $conn->prepare("SELECT nombre, apellido, documento_identidad, direccion, email, telefono, estado FROM empleados WHERE codigo = ?");
    $stmt->bind_param("i", $codigo); // Vincular el parámetro del código (entero)
    $stmt->execute(); // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado de la consulta

    // Verificar si se encontraron resultados
    if ($row = $result->fetch_assoc()) {
        // Devolver los datos del empleado en formato JSON
        echo json_encode($row);
    } else {
        // Si no se encuentra el empleado, devolver un mensaje de error
        echo json_encode(['error' => 'Empleado no encontrado']);
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Si no se proporcionó el código, devolver un mensaje de error
    echo json_encode(['error' => 'No se proporcionó el código del empleado']);
}

// Cerrar la conexión
$conn->close();
