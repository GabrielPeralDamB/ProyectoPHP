<?php
session_start(); // Inicia la sesión
// Destruye todas las variables de sesión
$_SESSION = array();
// Destruye la sesión
session_destroy();
// Redirige al usuario a la página de inicio de sesión
header("Location: ../../public/login.php"); // Cambia esto por la URL de tu página de login
exit();
?>