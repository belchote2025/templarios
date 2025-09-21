<?php
require_once __DIR__ . '/../src/config/config.php';

function renderMessage($title, $message, $success = true) {
    $color = $success ? '#198754' : '#dc3545';
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Newsletter | ".SITE_NAME."</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='bg-light'><div class='container py-5'><div class='row justify-content-center'><div class='col-md-8'><div class='card shadow-sm'><div class='card-header text-white' style='background: $color;'><h5 class='mb-0'>$title</h5></div><div class='card-body'><p class='mb-3'>$message</p><a href='".URL_ROOT."/noticias' class='btn btn-primary'>Volver a Noticias</a></div></div></div></div></div></body></html>";
}

$email = trim($_GET['email'] ?? '');
$token = trim($_GET['token'] ?? '');

if (!$email || !$token) {
    renderMessage('Confirmación de suscripción', 'Parámetros inválidos.', false);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar token
    $stmt = $pdo->prepare("SELECT id FROM newsletter_subscriptions WHERE email = ? AND confirm_token = ?");
    $stmt->execute([$email, $token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        renderMessage('Confirmación de suscripción', 'Token inválido o ya utilizado.', false);
        exit;
    }

    // Generar token de baja
    $unsubscribeToken = bin2hex(random_bytes(16));

    // Activar suscripción y limpiar token de confirmación, guardar token de baja
    $upd = $pdo->prepare("UPDATE newsletter_subscriptions SET activo = TRUE, confirm_token = NULL, unsubscribe_token = ? WHERE id = ?");
    $upd->execute([$unsubscribeToken, $row['id']]);

    $unsubscribeUrl = URL_ROOT . '/newsletter-unsubscribe.php?email=' . urlencode($email) . '&token=' . urlencode($unsubscribeToken);

    // Notificar a administración y enviar autorespuesta de bienvenida con enlace de baja
    $subject = 'Suscripción confirmada al boletín';
    $adminMsg = "Se ha confirmado una suscripción al boletín.\nEmail: $email\nFecha: " . date('d/m/Y H:i');
    $autoResponse = "¡Bienvenido/a al boletín de " . SITE_NAME . "!\n\n" .
                    "Has confirmado correctamente tu suscripción.\n\n" .
                    "Si en el futuro deseas darte de baja, puedes hacerlo desde este enlace:\n" .
                    $unsubscribeUrl . "\n\n" .
                    "Gracias por suscribirte.";

    if (function_exists('sendFormSubmitNotification')) {
        sendFormSubmitNotification($subject, $adminMsg, null, null, [
            'email' => $email,
            '_autoresponse' => $autoResponse
        ]);
    }

    renderMessage('¡Suscripción confirmada!', "Tu suscripción ha sido confirmada correctamente. Puedes darte de baja en cualquier momento desde este enlace: <a href='$unsubscribeUrl'>$unsubscribeUrl</a>");

} catch (Exception $e) {
    error_log('Error confirmando suscripción: ' . $e->getMessage());
    renderMessage('Error', 'No se pudo confirmar tu suscripción. Inténtalo más tarde.', false);
}
