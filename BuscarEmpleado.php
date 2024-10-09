<?php
include 'db.php';

// Verificar si la solicitud es de tipo POST y si se ha enviado un término de búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Recibir el valor de búsqueda del formulario
    $search = $_POST['search'];

    // Consulta SQL para buscar empleados que coincidan con el término de búsqueda
    $query = "SELECT * FROM empleados WHERE nombre LIKE ? OR apellido LIKE ? OR documento_identidad LIKE ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($query)) {
        // Agregar el símbolo de porcentaje (%) para hacer búsquedas parciales
        $search_param = "%" . $search . "%";

        // Enlazar el parámetro de búsqueda
        $stmt->bind_param("sss", $search_param, $search_param, $search_param);

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
}

// Cerrar la conexión a la base de datos
$conn->close();
