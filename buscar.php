<?php
require "conexion.php";

    // Realizar la consulta
    $sql = "SELECT * FROM articulo WHERE nombre LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar resultados
        while($row = $result->fetch_assoc()) {
            echo "Resultado: " . $row["nombre"] . "<br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }

    // Cerrar conexión
    $conn->close();

?>