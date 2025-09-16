<?php

class CartController extends Controller {
    
    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    // Añadir producto al carrito
    public function addToCart() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $product_id = $_POST['product_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if (!$product_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de producto requerido']);
            return;
        }
        
        // Obtener información del producto
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT id, nombre, precio, stock, imagen FROM productos WHERE id = ? AND activo = 1");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_OBJ);
            
            if (!$product) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
                return;
            }
            
            // Verificar stock disponible
            if ($product->stock < $quantity) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Stock insuficiente. Disponible: ' . $product->stock]);
                return;
            }
            
            // Añadir al carrito
            if (isset($_SESSION['cart'][$product_id])) {
                // Si ya existe, aumentar cantidad
                $new_quantity = $_SESSION['cart'][$product_id]['quantity'] + $quantity;
                if ($new_quantity > $product->stock) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Stock insuficiente. Disponible: ' . $product->stock]);
                    return;
                }
                $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
            } else {
                // Si no existe, añadir nuevo
                $_SESSION['cart'][$product_id] = [
                    'id' => $product->id,
                    'nombre' => $product->nombre,
                    'precio' => $product->precio,
                    'imagen' => $product->imagen,
                    'quantity' => $quantity
                ];
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Producto añadido al carrito',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->getCartTotal()
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    // Actualizar cantidad en el carrito
    public function updateCart() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $product_id = $_POST['product_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 0);
        
        if (!$product_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de producto requerido']);
            return;
        }
        
        if ($quantity <= 0) {
            // Eliminar del carrito
            unset($_SESSION['cart'][$product_id]);
        } else {
            // Verificar stock
            try {
                $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
                $stmt->execute([$product_id]);
                $stock = $stmt->fetchColumn();
                
                if ($quantity > $stock) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Stock insuficiente. Disponible: ' . $stock]);
                    return;
                }
                
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                }
                
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                return;
            }
        }
        
        echo json_encode([
            'success' => true, 
            'message' => 'Carrito actualizado',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }
    
    // Eliminar producto del carrito
    public function removeFromCart() {
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
        
        unset($_SESSION['cart'][$product_id]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Producto eliminado del carrito',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ]);
    }
    
    // Vaciar carrito
    public function clearCart() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        $_SESSION['cart'] = [];
        
        echo json_encode([
            'success' => true, 
            'message' => 'Carrito vaciado',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }
    
    // Mostrar carrito
    public function showCart() {
        $data = [
            'title' => 'Carrito de Compras',
            'cart_items' => $_SESSION['cart'] ?? [],
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
        
        $this->loadView('pages/cart', $data);
    }
    
    // Obtener número de productos en el carrito
    private function getCartCount() {
        $count = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    // Obtener total del carrito
    private function getCartTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $total += $item['precio'] * $item['quantity'];
        }
        return $total;
    }
    
    // Obtener información del carrito (para AJAX)
    public function getCartInfo() {
        header('Content-Type: application/json');
        
        echo json_encode([
            'success' => true,
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal(),
            'cart_items' => $_SESSION['cart'] ?? []
        ]);
    }
}
