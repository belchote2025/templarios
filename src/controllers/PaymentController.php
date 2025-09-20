<?php

class PaymentController extends Controller {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Procesar pago con Stripe
    public function processStripePayment() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $stripe_token = $input['stripe_token'] ?? null;
        $amount = floatval($input['amount'] ?? 0);
        $email = $input['email'] ?? '';
        $pedido_id = $input['pedido_id'] ?? null;
        
        if (!$stripe_token || $amount <= 0 || !$email || !$pedido_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos de pago inválidos']);
            return;
        }
        
        try {
            // Configuración de Stripe (en producción usar claves reales)
            $stripe_secret_key = 'sk_test_51234567890abcdef'; // Clave de prueba
            
            // Simular procesamiento de pago con Stripe
            $payment_result = $this->simulateStripePayment($stripe_token, $amount, $email);
            
            if ($payment_result['success']) {
                // Actualizar estado del pedido
                $this->updateOrderStatus($pedido_id, 'procesando', $payment_result['transaction_id']);
                
                // Notificar confirmación de pedido vía FormSubmit (administración)
                $this->sendOrderConfirmationEmail($pedido_id, $email);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Pago procesado correctamente',
                    'transaction_id' => $payment_result['transaction_id']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $payment_result['error']
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }
    
    // Procesar pago con PayPal
    public function processPayPalPayment() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $amount = floatval($input['amount'] ?? 0);
        $email = $input['email'] ?? '';
        $pedido_id = $input['pedido_id'] ?? null;
        
        if ($amount <= 0 || !$email || !$pedido_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos de pago inválidos']);
            return;
        }
        
        try {
            // Simular procesamiento de pago con PayPal
            $payment_result = $this->simulatePayPalPayment($amount, $email);
            
            if ($payment_result['success']) {
                // Actualizar estado del pedido
                $this->updateOrderStatus($pedido_id, 'procesando', $payment_result['transaction_id']);
                
                // Enviar correo de confirmación
                $this->sendOrderConfirmationEmail($pedido_id, $email);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Pago procesado correctamente',
                    'transaction_id' => $payment_result['transaction_id'],
                    'redirect_url' => $payment_result['redirect_url']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $payment_result['error']
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }
    
    // Procesar transferencia bancaria
    public function processBankTransfer() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $pedido_id = $input['pedido_id'] ?? null;
        $email = $input['email'] ?? '';
        
        if (!$pedido_id || !$email) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            return;
        }
        
        try {
            // Actualizar estado del pedido a pendiente de pago
            $this->updateOrderStatus($pedido_id, 'pendiente_pago');
            
            // Notificar instrucciones de transferencia vía FormSubmit (administración)
            $this->sendBankTransferInstructions($pedido_id, $email);
            
            echo json_encode([
                'success' => true,
                'message' => 'Instrucciones de transferencia enviadas por correo'
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    // Simular pago con Stripe
    private function simulateStripePayment($token, $amount, $email) {
        // En producción, aquí se haría la llamada real a Stripe
        // Por ahora simulamos un pago exitoso
        
        // Simular validación del token
        if (strlen($token) < 10) {
            return ['success' => false, 'error' => 'Token de pago inválido'];
        }
        
        // Simular validación del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Email inválido'];
        }
        
        // Simular procesamiento exitoso
        $transaction_id = 'stripe_' . time() . '_' . rand(1000, 9999);
        
        return [
            'success' => true,
            'transaction_id' => $transaction_id,
            'amount' => $amount,
            'currency' => 'EUR'
        ];
    }
    
    // Simular pago con PayPal
    private function simulatePayPalPayment($amount, $email) {
        // En producción, aquí se haría la llamada real a PayPal
        // Por ahora simulamos un pago exitoso
        
        $transaction_id = 'paypal_' . time() . '_' . rand(1000, 9999);
        
        return [
            'success' => true,
            'transaction_id' => $transaction_id,
            'redirect_url' => 'https://paypal.com/checkout/' . $transaction_id
        ];
    }
    
    // Actualizar estado del pedido
    private function updateOrderStatus($pedido_id, $estado, $transaction_id = null) {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "UPDATE pedidos SET estado = ?, fecha_actualizacion = NOW()";
            $params = [$estado];
            
            if ($transaction_id) {
                $sql .= ", transaction_id = ?";
                $params[] = $transaction_id;
            }
            
            $sql .= " WHERE id = ?";
            $params[] = $pedido_id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
        } catch (Exception $e) {
            error_log("Error updating order status: " . $e->getMessage());
        }
    }
    
    // Enviar notificación de confirmación de pedido vía FormSubmit
    private function sendOrderConfirmationEmail($pedido_id, $email) {
        try {
            // Obtener datos del pedido
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("
                SELECT p.*, pi.nombre_producto, pi.precio, pi.cantidad, pi.subtotal
                FROM pedidos p
                LEFT JOIN pedido_items pi ON p.id = pi.pedido_id
                WHERE p.id = ?
            ");
            $stmt->execute([$pedido_id]);
            $pedido_data = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if (empty($pedido_data)) {
                return false;
            }
            
            $pedido = $pedido_data[0];
            
            // Crear contenido para FormSubmit (notificación interna)
            $subject = "Nuevo pago confirmado - Pedido #{$pedido_id}";
            $lines = [];
            $lines[] = "Pedido #{$pedido->id}";
            $lines[] = "Fecha: " . date('d/m/Y H:i', strtotime($pedido->fecha_creacion));
            $lines[] = "Estado: {$pedido->estado}";
            $lines[] = "Método de Pago: " . ucfirst($pedido->metodo_pago);
            $lines[] = "Cliente: {$pedido->nombre} {$pedido->apellidos} ({$email})";
            $lines[] = "Dirección: {$pedido->direccion}, {$pedido->codigo_postal} {$pedido->ciudad}, {$pedido->provincia}";
            $lines[] = "";
            $lines[] = "Productos:";
            foreach ($pedido_data as $item) {
                $lines[] = "- {$item->nombre_producto} x{$item->cantidad} @ " . number_format($item->precio, 2) . "€ = " . number_format($item->subtotal, 2) . "€";
            }
            $lines[] = "";
            $lines[] = "Total: " . number_format($pedido->total, 2) . "€ (Envío: " . number_format($pedido->envio, 2) . "€ | Descuento: -" . number_format($pedido->descuento, 2) . "€)";
            $message = implode("\n", $lines);

            // Autorespuesta para el cliente
            $autoresponse =
                "¡Gracias por tu pedido en " . SITE_NAME . "!\n\n" .
                "Hemos recibido tu pedido #{$pedido->id}.\n" .
                "Pronto te enviaremos más detalles sobre el envío.\n\n" .
                "Resumen:\n" .
                "Total: " . number_format($pedido->total, 2) . "€\n" .
                "Método de pago: " . ucfirst($pedido->metodo_pago);

            sendFormSubmitNotification($subject, $message, 'Notificación de pedidos', 'no-reply@filamariscales.es', [
                'email' => $email,
                '_autoresponse' => $autoresponse
            ]);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Error sending order confirmation email: " . $e->getMessage());
            return false;
        }
    }
    
    // Enviar notificación de instrucciones de transferencia bancaria vía FormSubmit
    private function sendBankTransferInstructions($pedido_id, $email) {
        }
        $lines[] = "";
        $lines[] = "Total: " . number_format($pedido->total, 2) . "€ (Envío: " . number_format($pedido->envio, 2) . "€ | Descuento: -" . number_format($pedido->descuento, 2) . "€)";
        $message = implode("\n", $lines);

        // Autorespuesta para el cliente
        $autoresponse =
            "¡Gracias por tu pedido en " . SITE_NAME . "!\n\n" .
            "Hemos recibido tu pedido #{$pedido->id}.\n" .
            "Pronto te enviaremos más detalles sobre el envío.\n\n" .
            "Resumen:\n" .
            "Total: " . number_format($pedido->total, 2) . "€\n" .
            "Método de pago: " . ucfirst($pedido->metodo_pago);

        sendFormSubmitNotification($subject, $message, 'Notificación de pedidos', 'no-reply@filamariscales.es', [
            'email' => $email,
            '_autoresponse' => $autoresponse
        ]);

        return true;

    } catch (Exception $e) {
        error_log("Error sending order confirmation email: " . $e->getMessage());
        return false;
    }
    
    // Generar HTML del correo de confirmación
    private function generateOrderEmailHTML($pedido, $items) {
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Confirmación de Pedido</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc143c; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .order-details { background: white; padding: 15px; margin: 15px 0; border-radius: 5px; }
                .item { border-bottom: 1px solid #eee; padding: 10px 0; }
                .total { font-weight: bold; font-size: 18px; color: #dc143c; }
                .footer { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>¡Gracias por tu pedido!</h1>
                    <p>Filá Mariscales de Caballeros Templarios de Elche</p>
                </div>
                
                <div class='content'>
                    <h2>Confirmación de Pedido #{$pedido->id}</h2>
                    
                    <div class='order-details'>
                        <h3>Detalles del Pedido</h3>
                        <p><strong>Fecha:</strong> " . date('d/m/Y H:i', strtotime($pedido->fecha_creacion)) . "</p>
                        <p><strong>Estado:</strong> {$pedido->estado}</p>
                        <p><strong>Método de Pago:</strong> " . ucfirst($pedido->metodo_pago) . "</p>
                    </div>
                    
                    <div class='order-details'>
                        <h3>Productos</h3>";
        
        foreach ($items as $item) {
            $html .= "
                        <div class='item'>
                            <strong>{$item->nombre_producto}</strong><br>
                            Cantidad: {$item->cantidad} | Precio: " . number_format($item->precio, 2) . "€ | Subtotal: " . number_format($item->subtotal, 2) . "€
                        </div>";
        }
        
        $html .= "
                    </div>
                    
                    <div class='order-details'>
                        <h3>Total del Pedido</h3>
                        <p>Subtotal: " . number_format($pedido->total - $pedido->envio + $pedido->descuento, 2) . "€</p>
                        <p>Descuento: -" . number_format($pedido->descuento, 2) . "€</p>
                        <p>Envío: " . number_format($pedido->envio, 2) . "€</p>
                        <p class='total'>Total: " . number_format($pedido->total, 2) . "€</p>
                    </div>
                    
                    <div class='order-details'>
                        <h3>Dirección de Envío</h3>
                        <p>{$pedido->nombre} {$pedido->apellidos}<br>
                        {$pedido->direccion}<br>
                        {$pedido->codigo_postal} {$pedido->ciudad}, {$pedido->provincia}</p>
                    </div>
                </div>
                
                <div class='footer'>
                    <p>¡Gracias por confiar en Filá Mariscales!</p>
                    <p>Para cualquier consulta, contacta con nosotros en info@filamariscales.es</p>
                </div>
            </div>
        </body>
        </html>";
        
        return $html;
    }
    
    // Generar texto plano del correo
    private function generateOrderEmailText($pedido, $items) {
        $text = "¡Gracias por tu pedido!\n\n";
        $text .= "Filá Mariscales de Caballeros Templarios de Elche\n\n";
        $text .= "Confirmación de Pedido #{$pedido->id}\n";
        $text .= "Fecha: " . date('d/m/Y H:i', strtotime($pedido->fecha_creacion)) . "\n";
        $text .= "Estado: {$pedido->estado}\n";
        $text .= "Método de Pago: " . ucfirst($pedido->metodo_pago) . "\n\n";
        
        $text .= "Productos:\n";
        foreach ($items as $item) {
            $text .= "- {$item->nombre_producto} (Cantidad: {$item->cantidad}, Precio: " . number_format($item->precio, 2) . "€)\n";
        }
        
        $text .= "\nTotal del Pedido: " . number_format($pedido->total, 2) . "€\n\n";
        $text .= "Dirección de Envío:\n";
        $text .= "{$pedido->nombre} {$pedido->apellidos}\n";
        $text .= "{$pedido->direccion}\n";
        $text .= "{$pedido->codigo_postal} {$pedido->ciudad}, {$pedido->provincia}\n\n";
        $text .= "¡Gracias por confiar en Filá Mariscales!\n";
        $text .= "Para cualquier consulta: info@filamariscales.es";
        
        return $text;
    }
    
    // Generar HTML para transferencia bancaria
    private function generateBankTransferEmailHTML($pedido_id) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Instrucciones de Pago</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc143c; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .bank-details { background: white; padding: 15px; margin: 15px 0; border-radius: 5px; }
                .footer { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Instrucciones de Pago</h1>
                    <p>Filá Mariscales de Caballeros Templarios de Elche</p>
                </div>
                
                <div class='content'>
                    <h2>Pedido #{$pedido_id}</h2>
                    <p>Para completar tu pedido, realiza una transferencia bancaria con los siguientes datos:</p>
                    
                    <div class='bank-details'>
                        <h3>Datos Bancarios</h3>
                        <p><strong>Banco:</strong> Banco Santander</p>
                        <p><strong>IBAN:</strong> ES91 2100 0418 4502 0005 1332</p>
                        <p><strong>BIC/SWIFT:</strong> BSCHESMM</p>
                        <p><strong>Concepto:</strong> Pedido #{$pedido_id} - Filá Mariscales</p>
                        <p><strong>Beneficiario:</strong> Filá Mariscales de Caballeros Templarios de Elche</p>
                    </div>
                    
                    <p><strong>Importante:</strong> Una vez realizada la transferencia, envíanos el justificante a info@filamariscales.es para procesar tu pedido.</p>
                </div>
                
                <div class='footer'>
                    <p>¡Gracias por confiar en Filá Mariscales!</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    // Generar texto para transferencia bancaria
    private function generateBankTransferEmailText($pedido_id) {
        $text = "Instrucciones de Pago\n\n";
        $text .= "Filá Mariscales de Caballeros Templarios de Elche\n\n";
        $text .= "Pedido #{$pedido_id}\n\n";
        $text .= "Para completar tu pedido, realiza una transferencia bancaria:\n\n";
        $text .= "Banco: Banco Santander\n";
        $text .= "IBAN: ES91 2100 0418 4502 0005 1332\n";
        $text .= "BIC/SWIFT: BSCHESMM\n";
        $text .= "Concepto: Pedido #{$pedido_id} - Filá Mariscales\n";
        $text .= "Beneficiario: Filá Mariscales de Caballeros Templarios de Elche\n\n";
        $text .= "Importante: Envía el justificante a info@filamariscales.es\n\n";
        $text .= "¡Gracias por confiar en Filá Mariscales!";
        
        return $text;
    }
    
    // (Helper global sendFormSubmitNotification se usa en lugar de método local)
}
