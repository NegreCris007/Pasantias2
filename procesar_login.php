
<?php
// Inicio sesión
session_start();
require 'conexion.php';

// Verificar si los datos se envían por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['password']);

    // Validar campos vacíos
    if (empty($cedula) || empty($password)) {
        header("Location: login.php?error=2"); // Campos vacíos
        exit();
    }

    try {
        // Consulta para obtener los datos del usuario
        $stmt = $conexion->prepare("SELECT cedula, password, nombre, departamento, rol FROM usuario WHERE cedula = :cedula LIMIT 1");
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña
        if ($user && password_verify($password, $user['password'])) {
            // Crear sesión segura
            session_regenerate_id(true);
            $_SESSION['cedula'] = $user['cedula'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['departamento'] = $user['departamento'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir según el rol del usuario
            if ($user['rol'] === 'admin') {
                header("Location: admin.php");

            } elseif ($user['rol'] === 'usuario') {
                header("Location: usuario.php");

            } else {
                header("Location: login.php?error=4"); // Rol desconocido
            }
            exit();
            
        } else {
            header("Location: login.php?error=1"); // Credenciales incorrectas
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error en el login: " . $e->getMessage());
        header("Location: login.php?error=3"); // Error de base de datos
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
