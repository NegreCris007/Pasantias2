<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $codigo = trim($_POST['codigo']);
    $descripcion = trim($_POST['descripcion']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $puerto = trim($_POST['puerto']);
    $generacion = trim($_POST['generacion']);
    $memoriaram = trim($_POST['memoriaram']);
    $memoriarom = trim($_POST['memoriarom']);
    $categoria = trim($_POST['categoria']);

    // Validar que no haya campos vacíos
    if (empty($nombre) || empty($codigo) || empty($descripcion) || empty($marca) || empty($modelo) 
         || empty($puerto) || empty($generacion) || empty($memoriaram) || empty($memoriarom) || empty($categoria)) {
        header("Location: admin.php?error=1"); // Campos vacíos
        exit();
    }

    try {
        // Insertar el artículo en la base de datos
        $stmt = $conexion->prepare("INSERT INTO articulos (nombre, codigo, descripcion, marca, modelo, puerto, generacion, memoriaram, memoriarom, categoria) VALUES (:nombre, :codigo, :descripcion, :marca, :modelo, :puerto, :generacion, :memoriaram, :memoriarom, :categoria)");
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $modelo, PDO::PARAM_STR);
        $stmt->bindParam(":puerto", $puerto, PDO::PARAM_STR);
        $stmt->bindParam(":generacion", $generacion, PDO::PARAM_STR);
        $stmt->bindParam(":memoriaram", $memoriaram, PDO::PARAM_STR);
        $stmt->bindParam(":memoriarom", $memoriarom, PDO::PARAM_STR);
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: admin.php?success=1"); // Registro exitoso
        exit();
    } catch (PDOException $e) {
        error_log("Error en el registro: " . $e->getMessage());
        header("Location: admin.php?error=2"); // Error de base de datos
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>