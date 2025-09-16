<?php
// Redirigir todas las peticiones del directorio admin al sistema de rutas principal
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/prueba-php/public';

// Extraer la parte de la URL después de /admin/
$path = str_replace($basePath . '/admin', '', $requestUri);

// Si no hay path adicional, redirigir al dashboard
if (empty($path) || $path === '/') {
    header('Location: ' . $basePath . '/admin/dashboard');
    exit;
}

// Si hay un path adicional, redirigir al sistema de rutas
header('Location: ' . $basePath . '/admin' . $path);
exit;
?>
