<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../src/config/config.php';

// Guardar suscripción en base de datos (misma lógica que newsletter-subscribe.php)
function guardarSuscripcion($email) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $createTable = "
            CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                fecha_suscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                activo BOOLEAN DEFAULT TRUE,
                ip_address VARCHAR(45),
                user_agent TEXT
            )
        ";
        $pdo->exec($createTable);

        $stmt = $pdo->prepare("
            INSERT INTO newsletter_subscriptions (email, ip_address, user_agent)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            fecha_suscripcion = CURRENT_TIMESTAMP,
            activo = TRUE
        ");

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        $stmt->execute([$email, $ip, $userAgent]);

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
if (!guardarSuscripcion($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar la suscripción. Inténtalo de nuevo.'
    ]);
    exit;
}

// Preparar los datos que el front debe enviar a FormSubmit
$formData = [
    'name' => 'Boletín Filá Mariscales',
    'email' => $email,
    'message' => "Nueva suscripción al boletín de noticias: $email",
    '_subject' => 'Nueva suscripción al boletín - Filá Mariscales',
    '_template' => 'table',
    '_captcha' => 'false',
    // Autorespuesta al suscriptor
    '_autoresponse' => "¡Gracias por suscribirte al boletín de " . SITE_NAME . "!\n\n" .
                      "A partir de ahora recibirás noticias y eventos destacados en tu correo.",
    // Ajusta esta URL pública según tu despliegue
    '_next' => URL_ROOT . '/noticias?subscripcion=ok'
];

// Devolver éxito y los datos del formulario para que el front cree el POST a FormSubmit
echo json_encode([
    'success' => true,
    'message' => 'Suscripción registrada. Enviando notificación mediante FormSubmit...',
    'formData' => $formData
]);
