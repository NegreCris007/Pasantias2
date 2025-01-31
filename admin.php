
<?php
session_start();

// Verificar si el usuario está autenticado y es Administrador
if (!isset($_SESSION['cedula']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php?error=5"); // Acceso no autorizado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Style/style.css"> 
    
</head>
<body>




    <!-- Encabezado -->
    <div class="header">
        <span class="menu-btn" onclick="toggleMenu()">&#9776;</span>
        <div class="user-info">
            Bienvenido, Admistrador <?php echo htmlspecialchars($_SESSION['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['departamento']); ?>)
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
            <li>
            <a href="#">Articulo</a>
            <ul>
            <li><a href="#" onclick="showSection('article-form')">Mostrar Artículos</a></li>
            <li><a href="#" onclick="showSection('articulo-form')">Registrar Artículo</a></li>
            </ul>
            </li>
            </a>
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



<div id="articulo-form" style="display: none; margin-top: 20px;">
<button class="btn-submit" onclick="toggleArticuloForm()">Registrar Nuevo Artículo</button>
 <!-- Formulario de Registro de Artículos -->

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

       <!-- Tabla de Artículos -->
       <div id="article-form" style="display: none; margin-top: 20px;">
    
    <?php
require 'conexion.php';

// Parámetros de búsqueda y filtros
$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';

// Paginación
$registros_por_pagina = 8;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Construcción de la consulta con filtros
$query = "SELECT * FROM articulos WHERE (nombre LIKE :buscar OR codigo LIKE :buscar)";
$params = ['buscar' => "%$buscar%"];

if (!empty($categoria)) {
    $query .= " AND categoria = :categoria";
    $params['categoria'] = $categoria;
}

$query .= " LIMIT :offset, :registros";
$stmt = $conexion->prepare($query);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':registros', $registros_por_pagina, PDO::PARAM_INT);
foreach ($params as $key => &$value) {
    $stmt->bindParam($key, $value);
}
$stmt->execute();
$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar total de registros para paginación
$countQuery = "SELECT COUNT(*) FROM articulos WHERE (nombre LIKE :buscar OR codigo LIKE :buscar)";
if (!empty($categoria)) {
    $countQuery .= " AND categoria = :categoria";
}
$countStmt = $conexion->prepare($countQuery);
$countStmt->execute($params);
$total_registros = $countStmt->fetchColumn();
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>



<h2>Buscar Artículos</h2>
<form method="GET">
    <div class="input-group">
    <input type="text" name="buscar" placeholder="Buscar por nombre o código" value="<?= htmlspecialchars($buscar) ?>">
    
    <div class="input-group">
    <select name="categoria">
        <option value="">Todas las categorías</option>
        <?php
        $categorias = $conexion->query("SELECT DISTINCT categoria FROM articulos")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($categorias as $cat) {
            $selected = ($categoria === $cat) ? 'selected' : '';
            echo "<option value='$cat' $selected>$cat</option>";
        }
        ?>
    </select>

    <button class="btn-submit" type="submit">Buscar</button>
</form>
<!-- Tabla -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Puerto</th>
            <th>Generación</th>
            <th>RAM</th>
            <th>ROM</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <tfoot>
    <th>ID</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Puerto</th>
            <th>Generación</th>
            <th>RAM</th>
            <th>ROM</th>
            <th>Categoría</th>
            <th>Acciones</th>
    </tfoot>
        <?php if ($articulos): ?>
            <?php foreach ($articulos as $articulo): ?>
                <tr>
                    <td><?= htmlspecialchars($articulo['id']) ?></td>
                    <td><?= htmlspecialchars($articulo['nombre']) ?></td>
                    <td><?= htmlspecialchars($articulo['codigo']) ?></td>
                    <td><?= htmlspecialchars($articulo['descripcion']) ?></td>
                    <td><?= htmlspecialchars($articulo['marca']) ?></td>
                    <td><?= htmlspecialchars($articulo['modelo']) ?></td>
                    <td><?= htmlspecialchars($articulo['puerto']) ?></td>
                    <td><?= htmlspecialchars($articulo['generacion']) ?></td>
                    <td><?= htmlspecialchars($articulo['memoriaram']) ?></td>
                    <td><?= htmlspecialchars($articulo['memoriarom']) ?></td>
                    <td><?= htmlspecialchars($articulo['categoria']) ?></td>
                    <td>
                        <a href="editar_articulo.php?id=<?= $articulo['id'] ?>"> Editar</a>
                        <a href="eliminar_articulo.php?id=<?= $articulo['id'] ?>" onclick="return confirm('¿Eliminar este artículo?')"> Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="12" style="text-align: center;">No se encontraron artículos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paginación -->
<div class="pagination">
    <?php if ($pagina_actual > 1): ?>
        <a href="?pagina=1&buscar=<?= $buscar ?>&categoria=<?= $categoria ?>">◀-</a>
        <a href="?pagina=<?= $pagina_actual - 1 ?>&buscar=<?= $buscar ?>&categoria=<?= $categoria ?>">◀</a>
    <?php endif; ?>

    Página <?= $pagina_actual ?> de <?= $total_paginas ?>

    <?php if ($pagina_actual < $total_paginas): ?>
        <a href="?pagina=<?= $pagina_actual + 1 ?>&buscar=<?= $buscar ?>&categoria=<?= $categoria ?>">▶</a>
        <a href="?pagina=<?= $total_paginas ?>&buscar=<?= $buscar ?>&categoria=<?= $categoria ?>">-▶</a>
    <?php endif; ?>
</div>

<script src="Script/script.js"></script> 
</body>
</html>

























