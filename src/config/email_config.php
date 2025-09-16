<?php
// Configuración de email para la Filá Mariscales

// Configuración del servidor SMTP (para uso con servidores de correo reales)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'edu300572@gmail.com');
define('SMTP_PASSWORD', 'granmaestre2024');
define('SMTP_ENCRYPTION', 'tls');

// Configuración de email de la filá
define('FILA_EMAIL', 'edu300572@gmail.com');
define('FILA_NAME', 'Filá Mariscales de Caballeros Templarios');
define('FILA_REPLY_TO', 'edu300572@gmail.com');

// Configuración para desarrollo local
define('DEVELOPMENT_MODE', false); // Activado para envío real

// Función para enviar email usando PHPMailer (si está disponible)
function enviarEmailConPHPMailer($destinatario, $asunto, $mensaje) {
    // Verificar si PHPMailer está disponible
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        return false;
    }
    
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        
        // Remitente
        $mail->setFrom(FILA_EMAIL, FILA_NAME);
        $mail->addReplyTo(FILA_REPLY_TO, FILA_NAME);
        
        // Destinatario
        $mail->addAddress($destinatario);
        
        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error PHPMailer: " . $e->getMessage());
        return false;
    }
}

// Función para enviar email usando mail() nativo de PHP
function enviarEmailNativo($destinatario, $asunto, $mensaje) {
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: ' . FILA_NAME . ' <' . FILA_EMAIL . '>',
        'Reply-To: ' . FILA_REPLY_TO,
        'X-Mailer: PHP/' . phpversion(),
        'X-Priority: 3'
    ];
    
    // Configurar parámetros adicionales para XAMPP
    $additional_parameters = '-f' . FILA_EMAIL;
    
    return mail($destinatario, $asunto, $mensaje, implode("\r\n", $headers), $additional_parameters);
}

// Función principal para enviar emails
function enviarEmail($destinatario, $asunto, $mensaje) {
    // En modo desarrollo, solo logear
    if (DEVELOPMENT_MODE) {
        error_log("Email simulado enviado a: $destinatario");
        error_log("Asunto: $asunto");
        return true;
    }
    
    // Intentar con PHPMailer primero
    if (enviarEmailConPHPMailer($destinatario, $asunto, $mensaje)) {
        return true;
    }
    
    // Fallback a mail() nativo
    return enviarEmailNativo($destinatario, $asunto, $mensaje);
}
?>
