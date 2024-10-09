<?php
include 'db.php';

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir el término de búsqueda
    $search = $_POST['search'];

    // Preparar la consulta SQL
    $query = "SELECT * FROM empleados WHERE documento_identidad LIKE ? OR nombre LIKE ?";
    $stmt = $conn->prepare($query);

    // Añadir los caracteres comodín para la búsqueda
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Mostrar los resultados en la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['codigo'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['apellido'] . "</td>";
            echo "<td>" . $row['documento_identidad'] . "</td>";
            echo "<td>" . $row['direccion'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['telefono'] . "</td>";
            echo "<td>" . $row['estado'] . "</td>";
            echo "<td><button class='btn-edit'>Editar</button><button class='btn-delete'>Eliminar</button></td>";
            echo "</tr>";
        }
    } else {
        // Si no se encontraron empleados
        echo "<tr><td colspan='9'>No se encontraron empleados</td></tr>";
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
