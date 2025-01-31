<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conexion->prepare("DELETE FROM articulos WHERE id=:id");
    $stmt->execute(['id' => $id]);
}
header("Location: admin.php");
?>


