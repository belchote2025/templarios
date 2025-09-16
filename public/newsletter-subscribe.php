<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Cargar configuración
require_once '../src/config/config.php';
require_once '../src/config/email_config.php';

// Función para enviar email
function enviarEmailSuscripcion($email) {
    $asunto = "¡Bienvenido al boletín de la Filá Mariscales!";
    
    $mensaje = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Bienvenido al boletín</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #dc143c, #8b0000); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
            .logo { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
            .title { font-size: 28px; margin: 0; }
            .subtitle { font-size: 16px; opacity: 0.9; margin: 10px 0 0 0; }
            .message { background: white; padding: 25px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc143c; }
            .cta-button { display: inline-block; background: #dc143c; color: white; padding: 12px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px; }
            .social-links { margin: 20px 0; }
            .social-links a { display: inline-block; margin: 0 10px; color: #dc143c; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <div class='logo'>🛡️ FILÁ MARISCALES</div>
                <h1 class='title'>¡Bienvenido!</h1>
                <p class='subtitle'>Caballeros Templarios de Elche</p>
            </div>
            
            <div class='content'>
                <div class='message'>
                    <h2>¡Gracias por suscribirte a nuestro boletín!</h2>
                    <p>Estimado/a amigo/a de la Filá Mariscales,</p>
                    <p>Nos complace confirmar que te has suscrito exitosamente a nuestro boletín de noticias. A partir de ahora recibirás:</p>
                    <ul>
                        <li>📰 Las últimas noticias y eventos de la filá</li>
                        <li>📅 Información sobre próximas actividades</li>
                        <li>🏰 Noticias sobre la tradición templaria</li>
                        <li>🎭 Actualizaciones de las Fiestas de Moros y Cristianos</li>
                    </ul>
                    <p>Tu dirección de correo electrónico <strong>$email</strong> ha sido añadida a nuestra lista de suscriptores.</p>
                </div>
                
                <div style='text-align: center;'>
                    <a href='http://localhost/prueba-php/public/' class='cta-button'>
                        Visitar nuestra web
                    </a>
                </div>
                
                <div class='social-links' style='text-align: center;'>
                    <p>Síguenos en nuestras redes sociales:</p>
                    <a href='#'>Facebook</a> |
                    <a href='#'>Instagram</a> |
                    <a href='#'>Twitter</a> |
                    <a href='#'>YouTube</a>
                </div>
                
                <div class='footer'>
                    <p><strong>Filá Mariscales de Caballeros Templarios de Elche</strong></p>
                    <p>Si no deseas recibir más emails, puedes darte de baja en cualquier momento respondiendo a este correo.</p>
                    <p>Este email fue enviado a $email</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Configurar headers del email
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: Filá Mariscales <edu300572@gmail.com>',
        'Reply-To: edu300572@gmail.com',
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Usar la función de envío de email configurada
    return enviarEmail($email, $asunto, $mensaje);
}

// Función para guardar suscripción en base de datos
function guardarSuscripcion($email) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Crear tabla si no existe
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
        
        // Insertar suscripción
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
    $guardado = guardarSuscripcion($email);
    
    if (!$guardado) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al procesar la suscripción. Inténtalo de nuevo.'
        ]);
        exit;
    }
    
    // Enviar email de confirmación
    $emailEnviado = enviarEmailSuscripcion($email);
    
    if ($emailEnviado) {
        echo json_encode([
            'success' => true,
            'message' => '¡Suscripción exitosa! Revisa tu correo electrónico para confirmar.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'Suscripción completada, pero hubo un problema al enviar el email de confirmación.'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>
