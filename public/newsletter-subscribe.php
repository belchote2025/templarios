<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Cargar configuración
require_once '../src/config/config.php';

// (El envío de correo al usuario se realizará por FormSubmit en el cliente)

// Función para guardar suscripción en base de datos
function guardarSuscripcion($email, &$confirmTokenOut = null) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Crear tabla si no existe
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
        
        $confirmToken = bin2hex(random_bytes(16));
        $confirmTokenOut = $confirmToken;
        
        // Insertar suscripción
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
        error_log("Error en base de datos: " . $e->getMessage());
        return false;
    }
}

// Procesar la petición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    $email = trim($input['email'] ?? '');
    $privacyAccepted = $input['privacy'] ?? false;
    
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
    
    // Guardar en base de datos
    $confirmToken = null;
    $guardado = guardarSuscripcion($email, $confirmToken);
    
    if (!$guardado) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al procesar la suscripción. Inténtalo de nuevo.'
        ]);
        exit;
    }
    
    // Preparar datos para FormSubmit (para que el frontend haga el POST)
    $confirmUrl = URL_ROOT . '/newsletter-confirm.php?email=' . urlencode($email) . '&token=' . urlencode($confirmToken);
    $formData = [
        'name' => 'Boletín Filá Mariscales',
        'email' => $email,
        'message' => "Nueva suscripción (pendiente de confirmación) al boletín: $email",
        '_subject' => 'Nueva suscripción al boletín (pendiente) - Filá Mariscales',
        '_template' => 'table',
        '_captcha' => 'false',
        // Autorespuesta con confirmación
        '_autoresponse' => "¡Gracias por suscribirte al boletín de " . SITE_NAME . "!\n\n" .
                          "Para completar tu suscripción, confirma tu correo haciendo clic en el siguiente enlace:\n" .
                          $confirmUrl . "\n\n" .
                          "Si no has solicitado esta suscripción, ignora este mensaje.",
        '_next' => URL_ROOT . '/noticias?subscripcion=ok'
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Suscripción registrada. Enviando notificación mediante FormSubmit...',
        'formData' => $formData
    ]);
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>
