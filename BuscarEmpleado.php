<?php
include 'db.php'; // Conexión a la base de datos

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se proporcionó el nombre o el documento de identidad
if (isset($data['documento_identidad']) || isset($data['nombre'])) {
    $documento_identidad = $data['documento_identidad'] ?? null;
    $nombre = $data['nombre'] ?? null;

    // Crear la consulta
    $query = "SELECT * FROM empleados WHERE 1=1";
    $params = [];

    if ($documento_identidad) {
        $query .= " AND documento_identidad = ?";
        $params[] = $documento_identidad;
    }
    if ($nombre) {
        $query .= " AND nombre LIKE ?";
        $params[] = "%" . $nombre . "%";
    }

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($query)) {
        if ($params) {
            // Enlazar parámetros de forma dinámica
            $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $empleados = [];
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }

        if (count($empleados) > 0) {
            echo json_encode($empleados);
        } else {
            echo json_encode(['error' => 'No se encontraron empleados con los criterios proporcionados']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó nombre ni documento de identidad']);
}

$conn->close();
