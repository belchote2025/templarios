<?php
// Script para servir imágenes de forma segura
$imagePath = $_GET['path'] ?? '';

// Directorios permitidos
$allowedDirs = [
    'uploads/carousel/',
    'uploads/gallery/', 
    'uploads/eventos/',
    'uploads/news/'
];

// Verificar que la ruta esté en un directorio permitido
$isAllowed = false;
foreach ($allowedDirs as $dir) {
    if (strpos($imagePath, $dir) === 0) {
        $isAllowed = true;
        break;
    }
}

if (!$isAllowed || empty($imagePath)) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Acceso denegado';
    exit;
}

// Construir la ruta completa
$fullPath = dirname(__DIR__) . '/' . $imagePath;

// Verificar que el archivo existe
if (!file_exists($fullPath)) {
    header('HTTP/1.0 404 Not Found');
    echo 'Imagen no encontrada';
    exit;
}

// Obtener la extensión del archivo
$extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

// Mapear extensiones a tipos MIME
$mimeTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp'
];

// Verificar que la extensión sea válida
if (!isset($mimeTypes[$extension])) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Tipo de archivo no permitido';
    exit;
}

// Obtener información del archivo
$fileSize = filesize($fullPath);
$lastModified = filemtime($fullPath);

// Configurar headers
header('Content-Type: ' . $mimeTypes[$extension]);
header('Content-Length: ' . $fileSize);
header('Cache-Control: max-age=31536000, public');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

// Servir el archivo
readfile($fullPath);
exit;
?>
