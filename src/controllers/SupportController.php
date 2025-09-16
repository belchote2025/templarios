<?php

class SupportController {
    private $faqModel;
    private $chatModel;
    private $faqCategoryModel;
    private $tutorialModel;
    
    public function __construct() {
        // Cargar modelos
        $this->faqModel = new \App\Models\Support\Faq();
        $this->chatModel = new \App\Models\Support\ChatMessage();
        $this->faqCategoryModel = new \App\Models\Support\FaqCategory();
        $this->tutorialModel = new \App\Models\Support\Tutorial();
        
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Muestra la página principal de ayuda
     */
    public function index() {
        try {
            $data = [
                'title' => 'Centro de Ayuda',
                'description' => 'Encuentra respuestas a las preguntas más frecuentes y obtén soporte personalizado.',
                'featuredFaqs' => $this->faqModel->getFeatured(5),
                'categories' => $this->faqCategoryModel->getAll(true),
                'featuredTutorials' => $this->tutorialModel->getFeatured(3),
                'unreadMessages' => isset($_SESSION['user_id']) ? $this->chatModel->getUnreadCount($_SESSION['user_id']) : 0
            ];
            
            $this->view('support/index', $data);
        } catch (Exception $e) {
            error_log('Error en SupportController::index: ' . $e->getMessage());
            $this->view('error/500', [
                'title' => 'Error del servidor',
                'message' => 'Ha ocurrido un error al cargar la página de ayuda.'
            ]);
        }
    }
    
    /**
     * Muestra una categoría de FAQ específica
     */
    public function category($categoryId) {
        try {
            $category = $this->faqCategoryModel->getById($categoryId);
            if (!$category) {
                $this->view('error/404', [
                    'title' => 'Categoría no encontrada',
                    'message' => 'La categoría solicitada no existe.'
                ]);
                return;
            }
            
            $faqs = $this->faqModel->getByCategory($categoryId);
            
            $data = [
                'title' => $category['name'] . ' - Preguntas Frecuentes',
                'description' => $category['description'],
                'category' => $category,
                'faqs' => $faqs,
                'categories' => $this->faqCategoryModel->getAll(true)
            ];
            
            $this->view('support/category', $data);
        } catch (Exception $e) {
            error_log('Error en SupportController::category: ' . $e->getMessage());
            $this->view('error/500', [
                'title' => 'Error del servidor',
                'message' => 'Ha ocurrido un error al cargar la categoría.'
            ]);
        }
    }
    
    /**
     * Muestra un tutorial específico
     */
    public function tutorial($slug) {
        try {
            $tutorial = $this->tutorialModel->getBySlug($slug);
            if (!$tutorial) {
                $this->view('error/404', [
                    'title' => 'Tutorial no encontrado',
                    'message' => 'El tutorial solicitado no existe.'
                ]);
                return;
            }
            
            // Incrementar contador de visualizaciones
            $this->tutorialModel->incrementViews($tutorial['id']);
            
            $data = [
                'title' => $tutorial['title'] . ' - Tutoriales',
                'description' => substr(strip_tags($tutorial['content']), 0, 160),
                'tutorial' => $tutorial,
                'relatedTutorials' => $this->tutorialModel->getRelated($tutorial['id'], $tutorial['category_id'])
            ];
            
            $this->view('support/tutorial', $data);
        } catch (Exception $e) {
            error_log('Error en SupportController::tutorial: ' . $e->getMessage());
            $this->view('error/500', [
                'title' => 'Error del servidor',
                'message' => 'Ha ocurrido un error al cargar el tutorial.'
            ]);
        }
    }
    
    /**
     * Busca en las preguntas frecuentes
     */
    public function searchFaqs() {
        try {
            $query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ?? '';
            $categoryId = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) ?: null;
            
            $results = [];
            if (!empty($query)) {
                $results = $this->faqModel->search($query, $categoryId);
            }
            
            $this->jsonResponse([
                'success' => true,
                'results' => $results
            ]);
        } catch (Exception $e) {
            error_log('Error en SupportController::searchFaqs: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => 'Error al realizar la búsqueda.'
            ], 500);
        }
    }
    
    /**
     * Obtiene la conversación del chat
     */
    /**
     * Envía un mensaje de chat
     */
    public function sendChatMessage() {
        try {
            // Verificar autenticación
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('No autorizado', 401);
            }
            
            // Validar entrada
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            if (empty($message)) {
                throw new Exception('El mensaje no puede estar vacío', 400);
            }
            
            $userId = $_SESSION['user_id'];
            $isFromAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
            
            // Guardar mensaje
            $messageId = $this->chatModel->create([
                'user_id' => $userId,
                'message' => $message,
                'is_from_admin' => $isFromAdmin
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message_id' => $messageId
            ]);
            
        } catch (Exception $e) {
            error_log('Error en SupportController::sendChatMessage: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    
    /**
     * Obtiene el recuento de mensajes no leídos
     */
    public function getUnreadCount() {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('No autorizado', 401);
            }
            
            $count = $this->chatModel->getUnreadCount($_SESSION['user_id']);
            
            $this->jsonResponse([
                'success' => true,
                'unread_count' => $count
            ]);
            
        } catch (Exception $e) {
            error_log('Error en SupportController::getUnreadCount: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    
    /**
     * Obtiene la lista de tutoriales
     */
    public function listTutorials() {
        try {
            $categoryId = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) ?: null;
            $difficulty = filter_input(INPUT_GET, 'difficulty', FILTER_SANITIZE_STRING);
            $search = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ?: '';
            $page = max(1, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1);
            $perPage = 10;
            
            // Obtener tutoriales paginados
            $result = $this->tutorialModel->getAll([
                'category_id' => $categoryId,
                'difficulty' => $difficulty,
                'search' => $search,
                'status' => 'published'
            ], $page, $perPage);
            
            $data = [
                'title' => 'Tutoriales y Guías',
                'description' => 'Aprende con nuestros tutoriales y guías paso a paso.',
                'tutorials' => $result['tutorials'],
                'total' => $result['total'],
                'page' => $page,
                'totalPages' => ceil($result['total'] / $perPage),
                'categories' => $this->faqCategoryModel->getAll(true),
                'currentCategory' => $categoryId,
                'currentDifficulty' => $difficulty,
                'searchQuery' => $search
            ];
            
            $this->view('support/tutorials', $data);
            
        } catch (Exception $e) {
            error_log('Error en SupportController::listTutorials: ' . $e->getMessage());
            $this->view('error/500', [
                'title' => 'Error del servidor',
                'message' => 'Ha ocurrido un error al cargar los tutoriales.'
            ]);
        }
    }
    
    /**
     * Marca un tutorial como útil
     */
    public function rateTutorial() {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('Debes iniciar sesión para calificar este tutorial', 401);
            }
            
            $tutorialId = filter_input(INPUT_POST, 'tutorial_id', FILTER_VALIDATE_INT);
            $isHelpful = filter_input(INPUT_POST, 'is_helpful', FILTER_VALIDATE_BOOLEAN);
            
            if (!$tutorialId) {
                throw new Exception('ID de tutorial no válido', 400);
            }
            
            $this->tutorialModel->rate($tutorialId, $_SESSION['user_id'], $isHelpful);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Gracias por tu valoración'
            ]);
            
        } catch (Exception $e) {
            error_log('Error en SupportController::rateTutorial: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    
    /**
     * Muestra el formulario de contacto
     */
    public function contact() {
        $data = [
            'title' => 'Contacta con Soporte',
            'description' => '¿Necesitas ayuda? Envíanos un mensaje y te responderemos lo antes posible.'
        ];
        
        $this->view('support/contact', $data);
    }
    
    /**
     * Procesa el envío del formulario de contacto
     */
    public function submitContact() {
        try {
            // Validar token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('Token de seguridad inválido', 400);
            }
            
            // Validar campos requeridos
            $required = ['name', 'email', 'subject', 'message'];
            $data = [];
            
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("El campo " . ucfirst($field) . " es obligatorio", 400);
                }
                $data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
            }
            
            // Validar email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El formato del correo electrónico no es válido', 400);
            }
            
            // Aquí iría el código para enviar el correo electrónico
            // Por ahora, solo lo registramos
            $logMessage = sprintf(
                "Nuevo mensaje de contacto:\nNombre: %s\nEmail: %s\nAsunto: %s\nMensaje: %s\n",
                $data['name'],
                $data['email'],
                $data['subject'],
                $data['message']
            );
            
            error_log($logMessage);
            
            // Redirigir con mensaje de éxito
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ];
            
            header('Location: /soporte/contacto');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en SupportController::submitContact: ' . $e->getMessage());
            
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => $e->getMessage()
            ];
            
            // Mantener los datos del formulario para mostrarlos de nuevo
            $_SESSION['form_data'] = $_POST;
            
            header('Location: /soporte/contacto');
            exit;
        }
    }
    
    /**
     * Método auxiliar para devolver respuestas JSON
     */
    private function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Método auxiliar para cargar vistas
     */
    private function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/{$view}.php";
        
        if (!file_exists($viewFile)) {
            throw new Exception("La vista {$view} no existe");
        }
        
        // Incluir el layout
        $content = $viewFile;
        require_once __DIR__ . '/../views/layouts/main.php';
    }
            }
        }
        
        if (!empty($unreadIds)) {
            $this->chatModel->markAsRead($unreadIds);
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'messages' => $messages
        ]);
    }
    
    // Enviar mensaje de chat
    public function sendChatMessage() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $message = trim($data['message'] ?? '');
        
        if (empty($message)) {
            http_response_code(400);
            echo json_encode(['error' => 'El mensaje no puede estar vacío']);
            return;
        }
        
        $messageId = $this->chatModel->createMessage(
            $_SESSION['user_id'],
            $message,
            false // No es del administrador
        );
        
        if ($messageId) {
            echo json_encode([
                'success' => true,
                'message_id' => $messageId
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al enviar el mensaje']);
        }
    }
    
    // Método auxiliar para cargar vistas
    protected function view($view, $data = []) {
        // Extraer las variables del array $data
        extract($data);
        
        // Incluir el archivo de la vista
        $viewFile = '../src/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // Vista no encontrada
            die('Vista no encontrada: ' . $view);
        }
    }
}
