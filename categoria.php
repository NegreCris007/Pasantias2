<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
    <link rel="stylesheet" href="Style/style.css"> 
   
</head>
<body>
        <!-- Formulario de Categoría  
        <div id="category-form" style="display: none; margin-top: 20px;">-->

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
</body>
</html>