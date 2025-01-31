<?php
$errorMsg = '';
// Manejo de mensajes de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $errorMsg = 'Todos los campos son obligatorios.';
            break;
        case 2:
            $errorMsg = 'La cédula ya está registrada.';
            break;
        case 3:
            $errorMsg = 'Error en el sistema. Intenta de nuevo.';
            break;
        case 4:
            $errorMsg = 'Registro exitoso. ¡Ahora puedes iniciar sesión!';
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
    <title>Registro de Usuario</title>
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
        .registro-container { 
         background-color: #ffffff; 
         padding: 30px; 
         border-radius: 8px; 
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
         max-width: 400px; width: 100%; 
         text-align: center; 
        }
        .registro-container h2 { 
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
        .registro-button { 
        width: 100%; 
        padding: 10px; 
        border: none; 
        border-radius: 5px; 
        background-color: #343a40; 
        color: #fff; font-size: 18px; 
        cursor: pointer; 
        transition: background 0.3s ease; 
        }
        .registro-button:hover { 
        background-color: rgb(89, 98, 101); 
        }
        .error-message { 
         color: red; 
         margin-bottom: 15px; }
        .success-message { 
         color: green; 
         margin-bottom: 15px; 
        }
    </style>
</head>
<body> <!-- Cuerpo del registro  -->
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        
        <?php if ($errorMsg): ?> <!-- Mensajes de errores  -->
            <p class="<?php echo $_GET['error'] == 4 ? 'success-message' : 'error-message'; ?>"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
    
        <form action="procesar_registro.php" method="POST"> <!-- Procesar registro con POST -->
            <!-- Ingreso de datos para el login -->
            <div class="input-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" required>
            </div>
            <div class="input-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input-group">
                <label for="departamento">Departamento:</label>
                <input type="text" id="departamento" name="departamento" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="registro-button" type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>

