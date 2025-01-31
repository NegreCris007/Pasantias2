<?php
require 'conexion.php';
// Enviamos los datos correspondietes por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula']);
    $nombre = trim($_POST['nombre']);
    $departamento = trim($_POST['departamento']);
    $password = trim($_POST['password']);
    // Verificamos si estan vacios
    if (empty($cedula) || empty($nombre) || empty($departamento) || empty($password)) {
        header("Location: registro.php?error=1"); // Campos vacíos
        exit();
    }

    try {
        // Verificar si la cédula ya está registrada
        $stmt = $conexion->prepare("SELECT id FROM usuario WHERE cedula = :cedula"); //Consulta
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: registro.php?error=2"); // Cédula duplicada
            exit();
        }

        // Insertar nuevo usuario con contraseña cifrada
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("INSERT INTO usuario (cedula, nombre, departamento, password) VALUES (:cedula, :nombre, :departamento, :password)");
        $stmt->bindParam(":cedula", $cedula);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":departamento", $departamento);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute(); 
        

        header("Location: registro.php?error=4"); // Registro exitoso
        exit();
    } catch (PDOException $e) {
        error_log("Error en el registro: " . $e->getMessage());
        header("Location: registro.php?error=3"); // Error de base de datos
        exit();
    }
} else {// Volvemos a registro
    header("Location: registro.php");
    exit();
}
?>