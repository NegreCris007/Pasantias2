<?php // Inicio sesión
session_start();
if (isset($_SESSION['cedula'])) {
    header('Location: dashboard.php');
    exit();
}

// Manejo de mensajes de error
$errorMsg = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $errorMsg = 'Cédula o contraseña incorrecta.';
            break;
        case 2:
            $errorMsg = 'Por favor, completa todos los campos.';
            break;
        case 3:
            $errorMsg = 'Error en el sistema. Inténtalo más tarde.';
            break;
    }
}
?>
<!-- Estructura Html para el login -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Estilos -->
    <style> 
        body {  /* Cuerpo  del estilo*/
            font-family: Arial, sans-serif; 
            background-color: #f0f2f5; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .login-container { 
            background-color: #ffffff; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            max-width: 400px; 
            width: 100%; 
            text-align: center; 
        }
        .login-container h2 { 
            margin-bottom: 20px; 
            color: #333; 
        }
        .input-group { 
            margin-bottom: 15px; 
            text-align: left; 
        }
        .input-group label { 
            display: block; 
            font-weight: bold; 
            color: #555; 
        }
        .input-group input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 16px; 
        }
        .login-button, .registro-button { 
            width: 100%; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            color: #fff; 
            font-size: 18px; 
            cursor: pointer; 
            transition: background 0.3s ease; 
        }
        .login-button { 
            background-color: #343a40;
        }
        .login-button:hover { 
            background-color:rgb(89, 98, 101); 
        }
        .registro-button { 
            background-color: #343a40; 
            margin-top: 10px; 
        }
        .registro-button:hover { 
            background-color: rgb(89, 98, 101); 
        }
        .error-message { 
            color: red; 
            margin-bottom: 15px; 
        }
    </style>
</head>
<body>  <!-- Cuerpo del login  -->
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if ($errorMsg): ?>   <!-- Mensaje de error -->
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
              
        <form action="procesar_login.php" method="POST">   <!-- Procesar con POST -->
            <div class="input-group">
                  <!-- Ingreso de datos para el login -->
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="login-button" type="submit">Ingresar</button>
        </form>
            <!-- Bóton para ir a registro -->
        <form action="registro.php" method="GET">
            <button class="registro-button" type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>