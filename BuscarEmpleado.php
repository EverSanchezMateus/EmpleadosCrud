<?php
include 'db.php';
$id = $_POST['id'];

// Verificar si se ha enviado el ID por POST
if (isset($_POST['id'])) {
    // Obtener el ID del empleado desde el formulario
    $id = $_POST['id'];

    // Crear una consulta SQL para buscar el empleado
    $query = "SELECT * FROM empleados WHERE id = ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($query)) {
        // Enlazar el parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si se encontró un empleado

        if ($result->num_rows > 0) {
            // Mostrar la información del empleado
            $row = $result->fetch_assoc();
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Apellido: " . $row['apellido'] . "<br>";
            echo "Documento Identidad: " . $row['documento_identidad'] . "<br>";
            echo "Dirección: " . $row['direccion'] . "<br>";
            echo "Teléfono: " . $row['telefono'] . "<br>";
            echo "Estado: " . $row['estado'] . "<br>";
        } else {
            // Si no se encontró ningún empleado con ese ID
            echo "No se encontró ningún empleado con el ID proporcionado.";
        }

        // Cerrar la consulta
        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
