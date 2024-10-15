<?php
    include 'db.php';

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['codigo'])) {
        $codigo = $data['codigo'];

        $sql= "DELETE FROM empleados WHERE codigo=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('i',$codigo);
        if ($stmt->execute()) {
            echo "Empleado eliminado exitosamente.";
        } else {
            echo "Error eliminando el empleado: " . $conn->error;
        }
    
        $stmt->close();

    } 

    } else {
        echo "Código de empleado no proporcionado.";
    }

    
    $conn->close();
    ?>