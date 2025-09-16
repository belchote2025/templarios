<?php

class OrderController extends Controller {
    
    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Mostrar página de checkout
    public function checkout() {
        if (empty($_SESSION['cart'])) {
            header('Location: /prueba-php/public/cart');
            exit;
        }
        
        $data = [
            'title' => 'Checkout - Finalizar Compra',
            'cart_items' => $_SESSION['cart'] ?? [],
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal(),
            'user' => $this->getUserData()
        ];
        
        $this->loadView('pages/checkout', $data);
    }
    
    // Procesar pedido
    public function processOrder() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        if (empty($_SESSION['cart'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
            return;
        }
        
        // Validar datos del formulario
        $required_fields = ['nombre', 'apellidos', 'email', 'direccion', 'ciudad', 'codigo_postal', 'provincia'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "El campo $field es requerido"]);
                return;
            }
        }
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            
            // Calcular totales
            $subtotal = $this->getCartTotal();
            $descuento = $this->calculateDiscount($_POST['cupon'] ?? '');
            $envio = $this->calculateShipping($subtotal - $descuento);
            $total = $subtotal - $descuento + $envio;
            
            // Crear pedido
            $stmt = $pdo->prepare("
                INSERT INTO pedidos (
                    usuario_id, email, nombre, apellidos, telefono, 
                    direccion, ciudad, codigo_postal, provincia, 
                    total, descuento, envio, estado, metodo_pago, notas
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente', ?, ?)
            ");
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $stmt->execute([
                $usuario_id,
                $_POST['email'],
                $_POST['nombre'],
                $_POST['apellidos'],
                $_POST['telefono'] ?? null,
                $_POST['direccion'],
                $_POST['ciudad'],
                $_POST['codigo_postal'],
                $_POST['provincia'],
                $total,
                $descuento,
                $envio,
                $_POST['metodo_pago'] ?? 'tarjeta',
                $_POST['notas'] ?? null
            ]);
            
            $pedido_id = $pdo->lastInsertId();
            
            // Crear items del pedido
            $stmt = $pdo->prepare("
                INSERT INTO pedido_items (
                    pedido_id, producto_id, nombre_producto, precio, cantidad, subtotal
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($_SESSION['cart'] as $item) {
                $subtotal_item = $item['precio'] * $item['quantity'];
                $stmt->execute([
                    $pedido_id,
                    $item['id'],
                    $item['nombre'],
                    $item['precio'],
                    $item['quantity'],
                    $subtotal_item
                ]);
                
                // Actualizar stock
                $update_stock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                $update_stock->execute([$item['quantity'], $item['id']]);
            }
            
            // Actualizar cupón si se usó
            if (!empty($_POST['cupon'])) {
                $this->updateCouponUsage($_POST['cupon'], $pdo);
            }
            
            $pdo->commit();
            
            // Limpiar carrito
            $_SESSION['cart'] = [];
            
            // Enviar correo de confirmación
            $this->sendOrderConfirmationEmail($pedido_id, $_POST['email']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Pedido procesado correctamente',
                'pedido_id' => $pedido_id,
                'total' => $total,
                'payment_required' => true,
                'payment_method' => $_POST['metodo_pago'] ?? 'tarjeta'
            ]);
            
        } catch (Exception $e) {
            if (isset($pdo)) {
                $pdo->rollback();
            }
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al procesar el pedido: ' . $e->getMessage()]);
        }
    }
    
    // Verificar cupón
    public function validateCoupon() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $codigo = $_POST['codigo'] ?? '';
        $total = floatval($_POST['total'] ?? 0);
        
        if (empty($codigo)) {
            echo json_encode(['success' => false, 'message' => 'Código de cupón requerido']);
            return;
        }
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("
                SELECT * FROM cupones 
                WHERE codigo = ? AND activo = 1 
                AND (fecha_inicio IS NULL OR fecha_inicio <= CURDATE())
                AND (fecha_fin IS NULL OR fecha_fin >= CURDATE())
                AND (usos_maximos IS NULL OR usos_actuales < usos_maximos)
            ");
            $stmt->execute([$codigo]);
            $cupon = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$cupon) {
                echo json_encode(['success' => false, 'message' => 'Cupón no válido o expirado']);
                return;
            }
            
            if ($total < $cupon->minimo_compra) {
                echo json_encode([
                    'success' => false, 
                    'message' => "Compra mínima requerida: " . number_format($cupon->minimo_compra, 2) . "€"
                ]);
                return;
            }
            
            $descuento = $this->calculateDiscountAmount($cupon, $total);
            
            echo json_encode([
                'success' => true,
                'message' => 'Cupón aplicado correctamente',
                'descuento' => $descuento,
                'cupon' => [
                    'codigo' => $cupon->codigo,
                    'descripcion' => $cupon->descripcion,
                    'tipo' => $cupon->tipo,
                    'valor' => $cupon->valor
                ]
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al validar cupón: ' . $e->getMessage()]);
        }
    }
    
    // Añadir a wishlist
    public function addToWishlist() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $product_id = $_POST['product_id'] ?? null;
        
        if (!$product_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de producto requerido']);
            return;
        }
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $session_id = $usuario_id ? null : session_id();
            
            $stmt = $pdo->prepare("
                INSERT IGNORE INTO wishlist (usuario_id, session_id, producto_id) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$usuario_id, $session_id, $product_id]);
            
            if ($stmt->rowCount() > 0) {
                // Obtener el nuevo contador de wishlist
                if ($usuario_id) {
                    $countStmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE usuario_id = ?");
                    $countStmt->execute([$usuario_id]);
                } else {
                    $countStmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE session_id = ?");
                    $countStmt->execute([$session_id]);
                }
                $countResult = $countStmt->fetch(PDO::FETCH_OBJ);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Producto añadido a favoritos',
                    'wishlist_count' => $countResult->count
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'El producto ya está en favoritos']);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    // Obtener wishlist
    public function getWishlist() {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $session_id = $usuario_id ? null : session_id();
            
            if ($usuario_id) {
                $stmt = $pdo->prepare("
                    SELECT p.*, w.fecha_creacion as fecha_favorito
                    FROM wishlist w
                    JOIN productos p ON w.producto_id = p.id
                    WHERE w.usuario_id = ? AND p.activo = 1
                    ORDER BY w.fecha_creacion DESC
                ");
                $stmt->execute([$usuario_id]);
            } else {
                $stmt = $pdo->prepare("
                    SELECT p.*, w.fecha_creacion as fecha_favorito
                    FROM wishlist w
                    JOIN productos p ON w.producto_id = p.id
                    WHERE w.session_id = ? AND p.activo = 1
                    ORDER BY w.fecha_creacion DESC
                ");
                $stmt->execute([$session_id]);
            }
            
            $wishlist = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $data = [
                'title' => 'Mis Favoritos',
                'wishlist' => $wishlist
            ];
            
            $this->loadView('pages/wishlist', $data);
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    // Métodos auxiliares
    private function getCartCount() {
        $count = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    private function getCartTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $total += $item['precio'] * $item['quantity'];
        }
        return $total;
    }
    
    private function getUserData() {
        if (isset($_SESSION['user_id'])) {
            return [
                'nombre' => $_SESSION['user_name'] ?? '',
                'email' => $_SESSION['user_email'] ?? '',
                'telefono' => $_SESSION['user_phone'] ?? '',
                'direccion' => $_SESSION['user_address'] ?? ''
            ];
        }
        return null;
    }
    
    private function calculateDiscount($cupon_codigo) {
        if (empty($cupon_codigo)) return 0;
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("
                SELECT * FROM cupones 
                WHERE codigo = ? AND activo = 1 
                AND (fecha_inicio IS NULL OR fecha_inicio <= CURDATE())
                AND (fecha_fin IS NULL OR fecha_fin >= CURDATE())
                AND (usos_maximos IS NULL OR usos_actuales < usos_maximos)
            ");
            $stmt->execute([$cupon_codigo]);
            $cupon = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$cupon) return 0;
            
            $total = $this->getCartTotal();
            if ($total < $cupon->minimo_compra) return 0;
            
            return $this->calculateDiscountAmount($cupon, $total);
            
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function calculateDiscountAmount($cupon, $total) {
        if ($cupon->tipo === 'porcentaje') {
            $descuento = ($total * $cupon->valor) / 100;
            if ($cupon->maximo_descuento && $descuento > $cupon->maximo_descuento) {
                $descuento = $cupon->maximo_descuento;
            }
            return $descuento;
        } else {
            return $cupon->valor;
        }
    }
    
    private function calculateShipping($subtotal) {
        // Envío gratis a partir de 50€
        return $subtotal >= 50 ? 0 : 5.99;
    }
    
    private function updateCouponUsage($codigo, $pdo) {
        $stmt = $pdo->prepare("UPDATE cupones SET usos_actuales = usos_actuales + 1 WHERE codigo = ?");
        $stmt->execute([$codigo]);
    }
    
    // Enviar correo de confirmación de pedido
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
            
            // Crear contenido del correo
            $subject = "Confirmación de Pedido #{$pedido_id} - Filá Mariscales";
            
            $html_content = $this->generateOrderEmailHTML($pedido, $pedido_data);
            $text_content = $this->generateOrderEmailText($pedido, $pedido_data);
            
            // Enviar correo
            $this->sendEmail($email, $subject, $html_content, $text_content);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Error sending order confirmation email: " . $e->getMessage());
            return false;
        }
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
    
    // Enviar correo
    private function sendEmail($to, $subject, $html_content, $text_content) {
        // Configuración del correo
        $from = "noreply@filamariscales.es";
        $from_name = "Filá Mariscales";
        
        // Headers del correo
        $headers = "From: {$from_name} <{$from}>\r\n";
        $headers .= "Reply-To: info@filamariscales.es\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"boundary123\"\r\n";
        
        // Cuerpo del correo
        $body = "--boundary123\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $text_content . "\r\n\r\n";
        $body .= "--boundary123\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $body .= $html_content . "\r\n\r\n";
        $body .= "--boundary123--";
        
        // Enviar correo
        return mail($to, $subject, $body, $headers);
    }
    
    // Eliminar de wishlist
    public function removeFromWishlist() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $product_id = $input['product_id'] ?? null;
        
        if (!$product_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de producto requerido']);
            return;
        }
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $session_id = $usuario_id ? null : session_id();
            
            if ($usuario_id) {
                $stmt = $pdo->prepare("DELETE FROM wishlist WHERE usuario_id = ? AND producto_id = ?");
                $stmt->execute([$usuario_id, $product_id]);
            } else {
                $stmt = $pdo->prepare("DELETE FROM wishlist WHERE session_id = ? AND producto_id = ?");
                $stmt->execute([$session_id, $product_id]);
            }
            
            // Obtener el nuevo contador de wishlist
            if ($usuario_id) {
                $countStmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE usuario_id = ?");
                $countStmt->execute([$usuario_id]);
            } else {
                $countStmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE session_id = ?");
                $countStmt->execute([$session_id]);
            }
            $countResult = $countStmt->fetch(PDO::FETCH_OBJ);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Producto eliminado de favoritos',
                'wishlist_count' => $countResult->count
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    // Obtener información de la wishlist
    public function getWishlistInfo() {
        header('Content-Type: application/json');
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $session_id = $usuario_id ? null : session_id();
            
            if ($usuario_id) {
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE usuario_id = ?");
                $stmt->execute([$usuario_id]);
            } else {
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM wishlist WHERE session_id = ?");
                $stmt->execute([$session_id]);
            }
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $wishlist_count = $result->count;
            
            echo json_encode([
                'success' => true,
                'wishlist_count' => $wishlist_count
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    // Mostrar confirmación de pedido
    public function showConfirmation($pedido_id) {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
            $stmt->execute([$pedido_id]);
            $pedido = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$pedido) {
                header('Location: /prueba-php/public/');
                exit;
            }
            
            $data = [
                'title' => 'Confirmación de Pedido',
                'pedido_id' => $pedido_id,
                'pedido' => $pedido
            ];
            
            $this->loadView('pages/order-confirmation', $data);
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    // Limpiar wishlist
    public function clearWishlist() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $usuario_id = $_SESSION['user_id'] ?? null;
            $session_id = $usuario_id ? null : session_id();
            
            if ($usuario_id) {
                $stmt = $pdo->prepare("DELETE FROM wishlist WHERE usuario_id = ?");
                $stmt->execute([$usuario_id]);
            } else {
                $stmt = $pdo->prepare("DELETE FROM wishlist WHERE session_id = ?");
                $stmt->execute([$session_id]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Lista de favoritos limpiada']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
