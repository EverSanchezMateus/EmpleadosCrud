<?php
include 'db_conexion.php'; // Conexión a la base de datos

$data = json_decode(file_get_contents('php://input'), true); // Obtener los datos enviados en la solicitud

if (isset($data['codigo'])) {
    // Extraer los valores
    $codigo = $data['codigo'];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $documento_identidad = $data['documento_identidad'];
    $direccion = $data['direccion'];
    $email = $data['email'];
    $telefono = $data['telefono'];
    $estado = $data['estado'];

    // Preparar la consulta para actualizar los datos del empleado
    $stmt = $conn->prepare("UPDATE empleados SET nombre = ?, apellido = ?, documento_identidad = ?, direccion = ?, email = ?, telefono = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("ssissssi", $nombre, $apellido, $documento_identidad, $direccion, $email, $telefono, $estado, $codigo);

    if ($stmt->execute()) {
        echo "Empleado actualizado exitosamente.";
    } else {
        echo "Error al actualizar el empleado: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: No se proporcionó el código del empleado.";
}
?>