<!-- Botón para mostrar el formulario -->
<button class="btn-submit" onclick="toggleArticuloForm()">Registrar Nuevo Artículo</button>

<!-- Formulario de Artículo -->
<div id="article-form" style="display: none;">
    <h2>Registrar Artículo</h2>
    <form id="articleForm">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="">Seleccione...</option>
        </select>

        <button type="submit" class="btn-submit">Guardar Artículo</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    cargarCategorias();
    cargarArticulos();
});

// Mostrar/Ocultar Formulario
function toggleArticuloForm() {
    let form = document.getElementById("article-form");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}

// Cargar Categorías dinámicamente
function cargarCategorias() {
    fetch('cargar_categorias.php')
    .then(response => response.json())
    .then(data => {
        let select = document.getElementById("categoria");
        select.innerHTML = '<option value="">Seleccione...</option>';
        data.forEach(cat => {
            let option = document.createElement("option");
            option.value = cat.id;
            option.textContent = cat.descripcion;
            select.appendChild(option);
        });
    });
}

// Enviar Formulario con AJAX
document.getElementById("articleForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("procesar_articulo.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarArticulos();
        this.reset();
    });
});
</script>




<h2>Lista de Artículos</h2>
<div id="article-list"></div>

<script>
// Cargar Artículos con AJAX
function cargarArticulos() {
    fetch('listar_articulos.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById("article-list").innerHTML = data;
    });
}

// Función para Eliminar Artículo
function eliminarArticulo(id) {
    if (confirm("¿Desea eliminar este artículo?")) {
        fetch(`eliminar_articulo.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            alert(data);
            cargarArticulos();
        });
    }
}
</script>


<?php
require 'conexion.php';

$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$categoria = $_POST['categoria'];

$sql = "INSERT INTO articulos (nombre, codigo, descripcion, marca, modelo, categoria) 
        VALUES (:nombre, :codigo, :descripcion, :marca, :modelo, :categoria)";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':marca', $marca);
$stmt->bindParam(':modelo', $modelo);
$stmt->bindParam(':categoria', $categoria);

if ($stmt->execute()) {
    echo "Artículo registrado exitosamente";
} else {
    echo "Error al registrar";
}
?>




<?php
require 'conexion.php';

$query = "SELECT * FROM articulos";
$stmt = $conexion->query($query);
$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>Código</th><th>Descripción</th>
            <th>Marca</th><th>Modelo</th><th>Categoría</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($articulos): ?>
            <?php foreach ($articulos as $articulo): ?>
                <tr>
                    <td><?= htmlspecialchars($articulo['id']) ?></td>
                    <td><?= htmlspecialchars($articulo['nombre']) ?></td>
                    <td><?= htmlspecialchars($articulo['codigo']) ?></td>
                    <td><?= htmlspecialchars($articulo['descripcion']) ?></td>
                    <td><?= htmlspecialchars($articulo['marca']) ?></td>
                    <td><?= htmlspecialchars($articulo['modelo']) ?></td>
                    <td><?= htmlspecialchars($articulo['categoria']) ?></td>
                    <td>
                        <button onclick="eliminarArticulo(<?= $articulo['id'] ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">No hay artículos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>




<?php
require 'conexion.php';

$id = $_GET['id'];
$sql = "DELETE FROM articulos WHERE id = :id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Artículo eliminado correctamente";
} else {
    echo "Error al eliminar";
}
?>































