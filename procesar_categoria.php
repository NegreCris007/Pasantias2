<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = trim($_POST['descripcion']);
    $codigo = trim($_POST['codigo']);

// Validar que no haya campos vacíos
    if (empty($descripcion) || empty($codigo)) {
        echo "El campo de categoría es obligatorio.";
        exit();
    }

    try {// Insertar la categorias en la base de datos
        $stmt = $conexion->prepare("INSERT INTO categorias (descripcion,codigo) VALUES (:descripcion, :codigo)");
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":codigo", $codigo);
        $stmt->execute();
        echo "Categoría agregada con éxito.";


        header("Location: admin.php"); // Registro exitoso
        exit();
    } catch (PDOException $e) {
        echo "Error al agregar la categoría: " . $e->getMessage();// Error de base de datos
    }
} else {// Volvemos al tablero
        header("Location: admin.php");
        exit();
}

?>
