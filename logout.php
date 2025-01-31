
<?php
//Cerrar sesiones de manera segura
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
