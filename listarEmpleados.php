<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    include 'db.php';

    $sql = "SELECT codigo, nombre, apellido, documento_identidad, direccion, email, telefono, foto, estado FROM empleados";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($empleados);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>