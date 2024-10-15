<?php
include 'db.php'; // Conexión a la base de datos


// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento_identidad = $_POST['documento_identidad'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    if ($nombre && $apellido && $documento_identidad && $direccion && $telefono) {
        // valido foto dandole valor nulo por defecto 
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            // valido tipo d eimagen y tamaño
            $allowed_types = ['image/jpeg', 'image/png'];


            if (in_array($_FILES['foto']['type'], $allowed_types)) {
                $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
            } else {
                echo "Archivo de foto inválido o demasiado grande.";
                exit();
            }
        }


        $inyectar = $conn->prepare("INSERT INTO empleados (nombre, apellido, documento_identidad, direccion, email, telefono, foto, estado) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Vincular parámetros correctamente
        $inyectar->bind_param("ssisssss", $nombre, $apellido, $documento_identidad, $direccion, $email, $telefono, $foto, $estado);

        // Ejecutar la inserción y verificar si es exitosa
        if ($inyectar->execute()) {
            echo $nombre . " - Ha sido agregado exitosamente.";
        } else {
            echo "Error al agregar empleado: " . $inyectar->error;
        }

        $inyectar->close();
    } else {
        echo "Faltan campos obligatorios.";
    }
} else {
    echo "Solicitud no válida.";
}

$conn->close();
