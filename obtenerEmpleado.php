<?php
include 'db.php';  // Conexión a la base de datos

// Leer los datos enviados en la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$codigo = $data['codigo'] ?? '';

if ($codigo) {
    // Preparar la consulta para obtener los datos del empleado
    $stmt = $conn->prepare("SELECT * FROM empleados WHERE codigo = ?");
    $stmt->bind_param('i', $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($empleado = $result->fetch_assoc()) {
        // Devolver los datos en formato JSON
        echo json_encode($empleado);
    } else {
        echo json_encode(["error" => "Empleado no encontrado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Código de empleado no proporcionado"]);
}

$conn->close();
?>
