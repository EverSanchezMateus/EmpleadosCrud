<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Consulta para obtener los empleados
$sql = "SELECT codigo, nombre, apellido, documento_identidad, direccion, email, telefono, estado FROM empleados";
$result = $conn->query($sql);

$empleados = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $empleados[] = $row;  // Añadir cada fila al array
    }
}

// Devolver la respuesta como JSON
echo json_encode($empleados);

$conn->close();
?>
