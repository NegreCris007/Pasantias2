<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE articulos SET nombre=:nombre, codigo=:codigo, descripcion=:descripcion, marca=:marca, modelo=:modelo, 
            puerto=:puerto, generacion=:generacion, memoriaram=:memoriaram, memoriarom=:memoriarom, categoria=:categoria
            WHERE id=:id";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'nombre' => $_POST['nombre'],
        'codigo' => $_POST['codigo'],
        'descripcion' => $_POST['descripcion'],
        'marca' => $_POST['marca'],
        'modelo' => $_POST['modelo'],
        'puerto' => $_POST['puerto'],
        'generacion' => $_POST['generacion'],
        'memoriaram' => $_POST['memoriaram'],
        'memoriarom' => $_POST['memoriarom'],
        'categoria' => $_POST['categoria']
    ]);
    
    header("Location: admin.php");
} else {
    $stmt = $conexion->prepare("SELECT * FROM articulos WHERE id=:id");
    $stmt->execute(['id' => $id]);
    $articulo = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="Style/style.css"> 
<head><title>Editar Artículo</title></head>
<body>
<h2>Editar Artículo</h2>
<form method="POST">
    <input type="text" name="nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>" required>
    <input type="text" name="codigo" value="<?= htmlspecialchars($articulo['codigo']) ?>" required>
    <input type="text" name="descripcion" value="<?= htmlspecialchars($articulo['descripcion'])?>"required>
    <input type="text" name="marca" value="<?= htmlspecialchars($articulo['marca'])?>"required>
    <input type="text" name="modelo" value="<?= htmlspecialchars($articulo['modelo'])?>"required>
    <input type="text" name="puerto" value="<?= htmlspecialchars($articulo['puerto'])?>"required>
    <input type="text" name="generacion" value="<?= htmlspecialchars($articulo['generacion'])?>"required>
    <input type="text" name="memoriaram" value="<?= htmlspecialchars($articulo['memoriaram'])?>"required>
    <input type="text" name="memoriarom" value="<?= htmlspecialchars($articulo['memoriarom'])?>"required>
    <input type="text" name="categoria" value="<?= htmlspecialchars($articulo['categoria'])?>"required>
    <button class="btn-submit" type="submit">Actualizar</button>
</form>
</body>
</html>