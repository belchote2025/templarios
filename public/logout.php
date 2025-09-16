<?php
// Logout directo - archivo simple
session_start();

// Limpiar todas las variables de sesión
unset($_SESSION['user_id']);
unset($_SESSION['user_email']);
unset($_SESSION['user_name']);
unset($_SESSION['user_role']);

// Destruir la sesión
session_destroy();

// Redirigir a la página de socios
header('Location: /prueba-php/public/socios');
exit;
?>
