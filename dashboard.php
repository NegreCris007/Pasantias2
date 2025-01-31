


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #e9ecef;
            color: #333;
        }

        /* Encabezado */
        .header {
            width: 100%;
            background-color: #343a40;
            color: white;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .header .menu-btn {
            font-size: 24px;
            cursor: pointer;
            color: #fff;
        }

        .header .user-info {
            font-size: 18px;
            text-align: right;
            margin-left: auto;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 15px;
            background-color: #dc3545;
            border-radius: 5px;
            margin-left: 15px;
            transition: background 0.3s ease;
        }

        .header a:hover {
            background-color: #c82333;
        }

        /* Menú lateral */
        .sidebar {
            width: 250px;
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
            background-color: #212529;
            color: white;
            padding-top: 60px;
            transition: left 0.3s ease-in-out;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
            color: #adb5bd;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 12px 20px;
            border-bottom: 1px solid #464e54;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
            transition: background 0.3s ease;
            font-size: 16px;
        }

        .sidebar ul li a:hover {
            background: #495057;
        }

        .sidebar ul li ul {
            display: none;
            list-style: none;
            padding-left: 20px;
        }

        .sidebar ul li:hover ul {
            display: block;
        }

        /* Contenido principal */
        .main-content {
            margin-top: 70px;
            padding: 20px;
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.shifted {
            margin-left: 250px;
        }

        .main-content h1 {
            font-size: 28px;
            color: #343a40;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 16px;
            color: #495057;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        .input-group input {
            width: 30%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group select {
            width: 18%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-submit {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background-color:rgb(130, 140, 134);
        }

        /* Mostrar/ocultar el menú */
        .sidebar.active {
            left: 0;
        }

        .main-content.shifted {
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <span class="menu-btn" onclick="toggleMenu()">&#9776;</span>
        <div class="user-info">
            Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['departamento']); ?>)
        </div>
        <a href="logout.php">Cerrar sesión</a>
    </div>

    <!-- Menú lateral -->
    <div class="sidebar" id="sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="#" onclick="showSection('inicio-content')">Inicio</a></li>
            <li><a href="#" onclick="showSection('perfil-content')">Perfil</a></li>
            <li><a href="#" onclick="showSection('usuario-content')">Usuarios</a></li>
            <li><a href="#" onclick="showSection('article-form')">Artículo</a></li>
            <li><a href="#" onclick="showSection('category-form')">Categoría</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <div id="inicio-content">
            <h1>Inicio</h1>
            <p>Panel de inicio.</p>
        </div>

        <!-- Perfil de Usuario -->
        <div id="perfil-content" style="display: none;">
            <h1>Perfil</h1>
            <p>Información del usuario:</p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre']); ?></li>
                <li><strong>Cédula:</strong> <?php echo htmlspecialchars($_SESSION['cedula']); ?></li>
                <li><strong>Departamento:</strong> <?php echo htmlspecialchars($_SESSION['departamento']); ?></li>
            </ul>
        </div>

        <!-- Formulario de Categoría  -->
        <div id="category-form" style="display: none; margin-top: 20px;">

            <h2>Agregar Nueva Categoría</h2>
             <form action="procesar_categoria.php" method="POST">
            <div class="input-group">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>
            </div>

            <div class="input-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required>
        </div>
            <button class="btn-submit" type="submit">Guardar Categoría</button>
            </form>
       </div>

       <!-- Sección de Artículos -->
<div id="article-form" style="display: none; margin-top: 20px;">
   

    <!-- Botón para mostrar el formulario de registro -->
    <button class="btn-submit" onclick="showArticuloForm()">Registrar Nuevo Artículo</button>
    <!-- Tabla para mostrar los artículos registrados -->
    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #343a40; color: white;">
                <th>ID</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Puerto</th>
                <th>Generación</th>
                <th>Memoria Ram</th>
                <th>Memoria Rom</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'conexion.php';

            try {
                // Consultar todos los artículos registrados
                $stmt = $conexion->prepare("SELECT * FROM articulos");
                $stmt->execute();
                $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($articulos) {
                    foreach ($articulos as $articulo) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($articulo['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['marca']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['modelo']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['puerto']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['generacion']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['memoriaram']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['memoriarom']) . "</td>";
                        echo "<td>" . htmlspecialchars($articulo['categoria']) . "</td>";
                        //echo "<td>" . htmlspecialchars($articulo['descripcion']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>No hay artículos registrados.</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='6' style='text-align: center; color: red;'>Error al cargar los artículos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

 <!-- Formulario de Registro de Artículos -->
 <div id="articulo-form" style="display: none; margin-top: 20px;">
 <h2>Agregar Nuevo Artículo</h2>
    <form action="procesar_articulo.php" method="POST">
        <div class="input-group">
            <label for="nombre">Nombre del Artículo:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="input-group">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>
        </div>
        <div class="input-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required>
        </div>
        <div class="input-group">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>
        </div>
        <div class="input-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>
        </div>
        <div class="input-group">
            <label for="puerto">Puerto:</label>
            <input type="text" id="puerto" name="puerto" required>
        </div>
        <div class="input-group">
            <label for="generacion">Generación:</label>
            <input type="text" id="generacion" name="generacion" required>
        </div>
        <div class="input-group">
            <label for="memoriaram">Memoria Ram:</label>
            <input type="text" id="memoriaram" name="memoriaram" required>
        </div>
        <div class="input-group">
            <label for="memoriarom">Memoria Rom:</label>
            <input type="text" id="memoriarom" name="memoriarom" required>
        </div>
        <div class="input-group">
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php
                require 'conexion.php';

                try {
                    // Consultar las categorías registradas
                    $stmt = $conexion->prepare("SELECT id, descripcion FROM categorias");
                    $stmt->execute();
                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($categorias) {
                        foreach ($categorias as $categoria) {
                            echo "<option value='" . htmlspecialchars($categoria['descripcion']) . "'>" . htmlspecialchars($categoria['descripcion']) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hay categorías registradas</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value='' disabled>Error al cargar categorías</option>";
                }
                ?>
            </select>
        </div>
        <button class="btn-submit" type="submit">Guardar Artículo</button>
    </form>
</div>

    <script>

      // Mostrar el formulario de registro de artículos
        function showArticuloForm() {
        const articuloForm = document.getElementById('articulo-form');
        articuloForm.style.display = 'block';
    }
        
     // Mostrar la sección de artículos
        function showArticulos() {
        const articulos = document.getElementById('articulos');
        articulos.style.display = 'block';
    }


            function showSection(sectionId) {
            // Oculta todas las secciones
            document.getElementById('inicio-content').style.display = 'none';
            document.getElementById('perfil-content').style.display = 'none';
            document.getElementById('category-form').style.display = 'none';
            document.getElementById('article-form').style.display = 'none';
          
            // Muestra la sección seleccionada
            document.getElementById(sectionId).style.display = 'block';
        }

        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            

            sidebar.classList.toggle('active');
            mainContent.classList.toggle('shifted');
        }
    </script>
</body>
</html>












