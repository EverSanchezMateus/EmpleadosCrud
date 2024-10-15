<?php
include 'db.php'; // Conexión a la base de datos

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir el valor del nombre enviado a través de FormData
    $nombre = $_POST['nombre'] ?? '';

    // Crear la consulta base
    $query = "SELECT codigo, nombre, apellido, documento_identidad, direccion, email, telefono, estado FROM empleados WHERE LOWER(nombre) LIKE LOWER(?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($query)) {
        $nombre_busqueda = "%$nombre%";
        $stmt->bind_param("s", $nombre_busqueda);

        $stmt->execute();
        $result = $stmt->get_result();

        $empleados = [];
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }

        if (count($empleados) > 0) {
            echo json_encode($empleados);
        } else {
            echo json_encode(['error' => 'No se encontraron empleados con ese nombre']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta']);
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Método de solicitud no permitido']);
}
