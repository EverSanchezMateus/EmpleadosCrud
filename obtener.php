<?php
include 'db.php'; // Conexión a la base de datos

$data = json_decode(file_get_contents('php://input'), true); // Obtener los datos enviados en la solicitud

if (isset($data['codigo'])) {
    $codigo = $data['codigo'];

    // Consulta para obtener los datos del empleado
    $stmt = $conn->prepare("SELECT nombre, apellido, documento_identidad, direccion, email, telefono, estado FROM empleados WHERE id = ?");
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Retornar los datos del empleado en formato JSON
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Empleado no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No se proporcionó el código del empleado']);
}
?>
