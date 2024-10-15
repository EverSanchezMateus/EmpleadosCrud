<?php
include 'db.php';  // Conexión a la base de datos

// Leer los datos enviados en la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si todos los campos necesarios están presentes
if (isset($data['codigo'], $data['nombre'], $data['apellido'], $data['documento_identidad'], $data['direccion'], $data['email'], $data['telefono'], $data['estado'])) {
    $codigo = $data['codigo'];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $documento_identidad = $data['documento_identidad'];
    $direccion = $data['direccion'];
    $email = $data['email'];
    $telefono = $data['telefono'];
    $estado = $data['estado'];

    // Preparar la consulta para actualizar los datos del empleado
    $stmt = $conn->prepare("UPDATE empleados SET nombre = ?, apellido = ?, documento_identidad = ?, direccion = ?, email = ?, telefono = ?, estado = ? WHERE codigo = ?");
    $stmt->bind_param('ssissssi', $nombre, $apellido, $documento_identidad, $direccion, $email, $telefono, $estado, $codigo);

    if ($stmt->execute()) {
        echo "Empleado actualizado exitosamente.";
    } else {
        echo "Error al actualizar el empleado: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Datos incompletos para actualizar el empleado.";
}

$conn->close();
?>
