<?php
session_start();
session_destroy();
header("Location: http://localhost/Paginaweb-main/"); // Redirige a la página de inicio
?>
