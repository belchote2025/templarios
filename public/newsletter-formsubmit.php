<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../src/config/config.php';

// Guardar suscripción en base de datos (misma lógica que newsletter-subscribe.php)
function guardarSuscripcion($email, &$confirmTokenOut = null) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $createTable = "
            CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                fecha_suscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                activo BOOLEAN DEFAULT FALSE,
                confirm_token VARCHAR(64) DEFAULT NULL,
                unsubscribe_token VARCHAR(64) DEFAULT NULL,
                ip_address VARCHAR(45),
                user_agent TEXT
            )
        ";
        $pdo->exec($createTable);
        // Asegurar columnas nuevas si la tabla ya existía
        try { $pdo->exec("ALTER TABLE newsletter_subscriptions ADD COLUMN IF NOT EXISTS confirm_token VARCHAR(64) DEFAULT NULL"); } catch (Exception $e) {}
        try { $pdo->exec("ALTER TABLE newsletter_subscriptions ADD COLUMN IF NOT EXISTS unsubscribe_token VARCHAR(64) DEFAULT NULL"); } catch (Exception $e) {}

        // Generar token de confirmación
        $confirmToken = bin2hex(random_bytes(16));
        $confirmTokenOut = $confirmToken;

        $stmt = $pdo->prepare("
            INSERT INTO newsletter_subscriptions (email, ip_address, user_agent, activo, confirm_token)
            VALUES (?, ?, ?, FALSE, ?)
            ON DUPLICATE KEY UPDATE 
            fecha_suscripcion = CURRENT_TIMESTAMP,
            activo = VALUES(activo),
            confirm_token = VALUES(confirm_token)
        ");

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        $stmt->execute([$email, $ip, $userAgent, $confirmToken]);

        return true;
    } catch (PDOException $e) {
        error_log("Error en base de datos (newsletter-formsubmit): " . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$email = trim($input['email'] ?? '');
$privacyAccepted = (bool)($input['privacy'] ?? false);

// Validaciones
if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Por favor, introduce tu dirección de correo electrónico.'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Por favor, introduce una dirección de correo electrónico válida.'
    ]);
    exit;
}

if (!$privacyAccepted) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes aceptar la política de privacidad para continuar.'
    ]);
    exit;
}

// Guardar suscripción
if (!guardarSuscripcion($email, $confirmToken)) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar la suscripción. Inténtalo de nuevo.'
    ]);
    exit;
}

// Preparar los datos que el front debe enviar a FormSubmit
$confirmUrl = URL_ROOT . '/newsletter-confirm.php?email=' . urlencode($email) . '&token=' . urlencode($confirmToken);
$formData = [
    'name' => 'Boletín Filá Mariscales',
    'email' => $email,
    'message' => "Nueva suscripción (pendiente de confirmación) al boletín: $email",
    '_subject' => 'Nueva suscripción al boletín (pendiente) - Filá Mariscales',
    '_template' => 'table',
    '_captcha' => 'false',
    // Autorespuesta al suscriptor
    '_autoresponse' => "¡Gracias por suscribirte al boletín de " . SITE_NAME . "!\n\n" .
                      "Para completar tu suscripción, confirma tu correo haciendo clic en el siguiente enlace:\n" .
                      $confirmUrl . "\n\n" .
                      "Tras confirmar, recibirás un email de bienvenida con el enlace para darte de baja cuando quieras.\n\n" .
                      "Si no has solicitado esta suscripción, ignora este mensaje.",
    // Ajusta esta URL pública según tu despliegue
    '_next' => URL_ROOT . '/noticias?subscripcion=ok'
];

// Devolver éxito y los datos del formulario para que el front cree el POST a FormSubmit
echo json_encode([
    'success' => true,
    'message' => 'Suscripción registrada. Enviando notificación mediante FormSubmit...',
    'formData' => $formData
]);
