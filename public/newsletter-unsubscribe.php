<?php
require_once __DIR__ . '/../src/config/config.php';

function renderMessage($title, $message, $success = true) {
    $color = $success ? '#198754' : '#dc3545';
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Baja Newsletter | ".SITE_NAME."</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='bg-light'><div class='container py-5'><div class='row justify-content-center'><div class='col-md-8'><div class='card shadow-sm'><div class='card-header text-white' style='background: $color;'><h5 class='mb-0'>$title</h5></div><div class='card-body'><p class='mb-3'>$message</p><a href='".URL_ROOT."/noticias' class='btn btn-primary'>Volver a Noticias</a></div></div></div></div></div></body></html>";
}

$email = trim($_GET['email'] ?? '');
$token = trim($_GET['token'] ?? '');

if (!$email || !$token) {
    renderMessage('Baja de suscripción', 'Parámetros inválidos.', false);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE newsletter_subscriptions SET activo = FALSE WHERE email = ? AND unsubscribe_token = ?");
    $stmt->execute([$email, $token]);

    if ($stmt->rowCount() === 0) {
        renderMessage('Baja de suscripción', 'Token inválido o ya utilizado.', false);
        exit;
    }

    renderMessage('Baja confirmada', 'Has sido dado de baja correctamente del boletín.');
} catch (Exception $e) {
    error_log('Error en baja de suscripción: ' . $e->getMessage());
    renderMessage('Error', 'No se pudo procesar tu solicitud. Inténtalo más tarde.', false);
}
