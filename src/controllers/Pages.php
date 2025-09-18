<?php
class Pages extends Controller {
    private $userModel;
    private $eventModel;
    private $newsModel;

    public function __construct() {
        // Cargar el modelo de usuario para autenticación
        $this->userModel = $this->model('User');
        
        // Cargar el modelo de eventos
        if (class_exists('Event')) {
            $this->eventModel = $this->model('Event');
        }
        // Cargar el modelo de noticias
        if (class_exists('News')) {
            $this->newsModel = $this->model('News');
        }
        
        // Registrar visita automáticamente para páginas públicas
        $this->trackPageVisit();
    }
    
    /**
     * Registrar visita de la página actual
     */
    private function trackPageVisit() {
        try {
            if (class_exists('VisitTracker')) {
                require_once __DIR__ . '/../helpers/VisitTracker.php';
                $visitTracker = VisitTracker::getInstance();
                $visitTracker->trackVisit();
            }
        } catch (Exception $e) {
            error_log("Error al registrar visita en Pages: " . $e->getMessage());
        }
    }

    // Página de inicio
    public function index() {
        // Cargar imágenes del carrusel dinámicamente
        $carouselImages = $this->getCarouselImages();
        
        // Cargar imágenes de la galería dinámicamente
        $galleryImages = $this->getGalleryImages();
        
        // Cargar eventos próximos dinámicamente
        $upcomingEvents = $this->getUpcomingEvents();
        
        $data = [
            'title' => 'Inicio',
            'description' => 'Bienvenidos a la Filá Mariscales de Caballeros Templarios de Elche',
            'carousel_images' => $carouselImages,
            'upcoming_events' => $upcomingEvents,
            'gallery' => $galleryImages
        ];
        $this->view('pages/home', $data);
    }

    // Página de blog
    public function blog() {
        $data = [
            'title' => 'Blog',
            'description' => 'Artículos y publicaciones de la Filá Mariscales'
        ];
        $this->view('pages/blog', $data);
    }

    // Página de calendario
    public function calendario() {
        // Cargar eventos dinámicamente
        $events = $this->getAllEvents();
        
        $data = [
            'title' => 'Calendario',
            'description' => 'Calendario de eventos de la Filá Mariscales',
            'events' => $events
        ];
        $this->view('pages/calendario', $data);
    }

    // Página de descargas
    public function descargas() {
        $data = [
            'title' => 'Descargas',
            'description' => 'Documentos y archivos para descargar'
        ];
        $this->view('pages/descargas', $data);
    }

    // Página de directiva
    public function directiva() {
        $data = [
            'title' => 'Directiva',
            'description' => 'Conoce a los miembros de la junta directiva de la Filá Mariscales'
        ];
        $this->view('pages/directiva', $data);
    }

    // Página de galería
    public function galeria() {
        // Cargar imágenes de la galería dinámicamente
        $galleryImages = $this->getGalleryImages();
        
        $data = [
            'title' => 'Galería',
            'description' => 'Galería de imágenes de la Filá Mariscales',
            'gallery_images' => $galleryImages
        ];
        $this->view('pages/galeria', $data);
    }

    // Página de hermanamientos
    public function hermanamientos() {
        $data = [
            'title' => 'Hermanamientos',
            'description' => 'Nuestras relaciones con otras filás y entidades'
        ];
        $this->view('pages/hermanamientos', $data);
    }

    // Página del libro de la filá
    public function libro() {
        $data = [
            'title' => 'Libro de la Filá',
            'description' => 'Historia y anécdotas de la Filá Mariscales'
        ];
        $this->view('pages/libro', $data);
    }

    // Página de música
    public function musica() {
        $data = [
            'title' => 'Himno y Música',
            'description' => 'Escucha nuestro himno y otras piezas musicales de la Filá Mariscales'
        ];
        $this->view('pages/musica', $data);
    }

    // Página de noticias
    public function noticias($currentPage = 1) {
        try {
            // Validar número de página
            $currentPage = max(1, (int)$currentPage);
            
            // Inicializar datos por defecto
            $data = [
                'title' => 'Noticias',
                'description' => 'Últimas noticias y actualizaciones de la Filá Mariscales',
                'news' => [],
                'currentPage' => $currentPage,
                'totalPages' => 0
            ];

            // Verificar si el modelo de noticias está disponible
            if (!$this->newsModel) {
                error_log('Modelo de noticias no disponible');
                return $this->view('pages/noticias', $data);
            }

            // Obtener noticias publicadas
            $perPage = 6; // 6 noticias por página para un grid de 3 columnas
            
            // Obtener el total de noticias publicadas
            $totalNews = $this->newsModel->getNewsCountByStatus('publicado');
            if ($totalNews === false) {
                error_log('Error al obtener el total de noticias');
                return $this->view('pages/noticias', $data);
            }
            
            // Calcular el total de páginas
            $totalPages = max(1, ceil($totalNews / $perPage));
            
            // Asegurarse de que la página actual no exceda el total de páginas
            $currentPage = min($currentPage, $totalPages);
            
            // Obtener las noticias para la página actual
            $news = $this->newsModel->getPublishedNews($currentPage, $perPage);
            
            if ($news === false) {
                error_log('Error al obtener las noticias');
                $news = [];
            }

            // Actualizar datos con la información obtenida
            $data['news'] = $news;
            $data['totalPages'] = $totalPages;
            $data['currentPage'] = $currentPage;
            
        } catch (Exception $e) {
            // Registrar el error
            error_log('Error en el controlador de noticias: ' . $e->getMessage());
            error_log($e->getTraceAsString());
            
            // Mantener los datos por defecto en caso de error
            $data = $data ?? [
                'title' => 'Noticias',
                'description' => 'Últimas noticias y actualizaciones de la Filá Mariscales',
                'news' => [],
                'currentPage' => 1,
                'totalPages' => 0
            ];
        }

        // Cargar la vista con los datos
        $this->view('pages/noticias', $data);
    }

    // Página de patrocinadores
    public function patrocinadores() {
        $data = [
            'title' => 'Patrocinadores',
            'description' => 'Nuestros patrocinadores y colaboradores'
        ];
        $this->view('pages/patrocinadores', $data);
    }

    // Página de socios
    public function socios() {
        $data = [
            'title' => 'Zona de Socios',
            'description' => 'Área exclusiva para socios de la Filá Mariscales'
        ];
        
        // Verificar si el usuario está logueado
        if (isLoggedIn()) {
            // Obtener datos del usuario logueado
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            
            if ($user) {
                // Preparar datos del socio
                $socio_data = [
                    'nombre' => $user->nombre,
                    'apellidos' => $user->apellidos,
                    'email' => $user->email,
                    'numero_socio' => 'SOC-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'categoria' => ucfirst($user->rol),
                    'fecha_ingreso' => date('d/m/Y', strtotime($user->fecha_registro)),
                    'cuota_al_dia' => $user->activo == 1,
                    'ultima_cuota' => date('m/Y'),
                    'proximo_evento' => 'Reunión mensual - ' . date('d/m/Y', strtotime('+1 month')),
                    'ultimo_acceso' => $user->ultimo_acceso ? date('d/m/Y H:i', strtotime($user->ultimo_acceso)) : 'Primera vez'
                ];
                
                $data['socio_data'] = $socio_data;
                $data['user'] = $user;
            }
        }
        
        $this->view('pages/socios', $data);
    }

    // Página de perfil
    public function profile() {
        // Verificar si el usuario está logueado
        if (!isLoggedIn()) {
            $this->redirect('/socios');
        }
        
        // Obtener datos del usuario logueado
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        if (!$user) {
            $this->redirect('/socios');
        }
        
        $data = [
            'title' => 'Mi Perfil',
            'description' => 'Gestiona tu información personal',
            'user' => $user
        ];
        $this->view('pages/profile', $data);
    }

    // Actualizar perfil del usuario
    public function updateProfile() {
        if (!isLoggedIn()) {
            $this->redirect('/socios');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $nombre = trim($_POST['nombre'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');

            // Validaciones básicas
            if (empty($nombre) || empty($apellidos) || empty($email)) {
                setFlashMessage('Todos los campos obligatorios deben ser completados.', 'error');
                $this->redirect('/profile');
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setFlashMessage('El email no tiene un formato válido.', 'error');
                $this->redirect('/profile');
                return;
            }

            try {
                $db = new Database();
                $stmt = $db->query("UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, telefono = ?, direccion = ?, updated_at = NOW() WHERE id = ?");
                $stmt->bindParam(1, $nombre);
                $stmt->bindParam(2, $apellidos);
                $stmt->bindParam(3, $email);
                $stmt->bindParam(4, $telefono);
                $stmt->bindParam(5, $direccion);
                $stmt->bindParam(6, $user_id);
                
                if ($stmt->execute()) {
                    // Actualizar la sesión
                    $_SESSION['user_name'] = $nombre . ' ' . $apellidos;
                    $_SESSION['user_email'] = $email;
                    
                    setFlashMessage('Perfil actualizado correctamente.', 'success');
                } else {
                    setFlashMessage('Error al actualizar el perfil.', 'error');
                }
            } catch (Exception $e) {
                setFlashMessage('Error interno del servidor.', 'error');
            }
        }
        
        $this->redirect('/profile');
    }

    // Cambiar contraseña del usuario
    public function changePassword() {
        if (!isLoggedIn()) {
            $this->redirect('/socios');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validaciones
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                setFlashMessage('Todos los campos son obligatorios.', 'error');
                $this->redirect('/profile');
                return;
            }

            if ($new_password !== $confirm_password) {
                setFlashMessage('Las contraseñas nuevas no coinciden.', 'error');
                $this->redirect('/profile');
                return;
            }

            if (strlen($new_password) < 6) {
                setFlashMessage('La nueva contraseña debe tener al menos 6 caracteres.', 'error');
                $this->redirect('/profile');
                return;
            }

            try {
                $db = new Database();
                $stmt = $db->query("SELECT password FROM usuarios WHERE id = ?");
                $stmt->bindParam(1, $user_id);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_OBJ);

                if (!$user || !password_verify($current_password, $user->password)) {
                    setFlashMessage('La contraseña actual es incorrecta.', 'error');
                    $this->redirect('/profile');
                    return;
                }

                // Actualizar contraseña (solo hash, nunca en texto plano)
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->query("UPDATE usuarios SET password = ?, updated_at = NOW() WHERE id = ?");
                $stmt->bindParam(1, $hashed_password);
                $stmt->bindParam(2, $user_id);
                
                if ($stmt->execute()) {
                    setFlashMessage('Contraseña cambiada correctamente.', 'success');
                } else {
                    setFlashMessage('Error al cambiar la contraseña.', 'error');
                }
            } catch (Exception $e) {
                setFlashMessage('Error interno del servidor.', 'error');
            }
        }
        
        $this->redirect('/profile');
    }

    // Subir avatar del usuario
    public function uploadAvatar() {
        // Configurar headers para JSON
        header('Content-Type: application/json');
        
        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo: ' . ($_FILES['avatar']['error'] ?? 'Archivo no encontrado')]);
            return;
        }

        $file = $_FILES['avatar'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowed_types)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido. Solo se permiten JPG, PNG y GIF']);
            return;
        }

        if ($file['size'] > $max_size) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'El archivo es demasiado grande. Máximo 2MB']);
            return;
        }

        try {
            $user_id = $_SESSION['user_id'];
            $upload_dir = 'public/uploads/avatars/';
            
            // Crear directorio si no existe
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    throw new Exception('No se pudo crear el directorio de uploads');
                }
            }

            // Verificar permisos de escritura
            if (!is_writable($upload_dir)) {
                throw new Exception('El directorio no tiene permisos de escritura');
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . $user_id . '_' . time() . '.' . $extension;
            $filepath = $upload_dir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Actualizar en la base de datos usando PDO directo
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=mariscales_db', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $stmt = $pdo->prepare("UPDATE usuarios SET avatar = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute([$filename, $user_id]);
                    
                    echo json_encode(['success' => true, 'message' => 'Avatar actualizado correctamente', 'filename' => $filename]);
                } catch (PDOException $e) {
                    // Si falla la BD, al menos el archivo se subió
                    echo json_encode(['success' => true, 'message' => 'Avatar subido correctamente (error al actualizar BD)', 'filename' => $filename]);
                }
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo en el servidor']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Página de tienda
    public function tienda() {
        $products = [];
        
        try {
            // Usar la misma lógica que AdminController
            $pdo = new PDO('mysql:host=localhost;dbname=mariscales_db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Consulta que incluye las categorías (igual que AdminController)
            $stmt = $pdo->query('SELECT p.*, c.nombre as categoria_nombre 
                                FROM productos p 
                                LEFT JOIN categorias c ON p.categoria_id = c.id 
                                ORDER BY p.id DESC');
            $all_products = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            // Filtrar solo los activos si existe la columna activo
            foreach ($all_products as $product) {
                if (property_exists($product, 'activo')) {
                    if ($product->activo == 1) {
                        $products[] = $product;
                    }
                } else {
                    // Si no hay columna activo, mostrar todos
                    $products[] = $product;
                }
            }
            
        } catch (Exception $e) {
            error_log("Error obteniendo productos para tienda: " . $e->getMessage());
            $products = [];
        }
        
        $data = [
            'title' => 'Tienda Online',
            'description' => 'Compra los artículos oficiales de la Filá Mariscales',
            'products' => $products
        ];
        $this->view('pages/tienda', $data);
    }

    // Página de contacto
    public function contacto() {
        $data = [
            'title' => 'Contacto',
            'description' => 'Ponte en contacto con la Filá Mariscales de Caballeros Templarios de Elche'
        ];
        $this->view('pages/contacto', $data);
    }

    // Página de historia
    public function historia() {
        $data = [
            'title' => 'Historia',
            'description' => 'Descubre la rica tradición y el legado de los Caballeros Templarios de Elche'
        ];
        $this->view('pages/historia', $data);
    }

    // Login page
    public function login() {
        // If already logged in, redirect to dashboard
        if (isLoggedIn()) {
            $this->redirect('/socios');
        }

        $data = [
            'title' => 'Iniciar Sesión',
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => ''
        ];

        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => 'Iniciar Sesión',
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su email';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese su contraseña';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No se encontró ningún usuario con ese email';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Contraseña incorrecta';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => 'Iniciar Sesión',
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('auth/login', $data);
        }
    }

    // Register page
    public function registro() {
        // If already logged in, redirect to dashboard
        if (isLoggedIn()) {
            $this->redirect('/socios');
        }

        $data = [
            'title' => 'Registro',
            'nombre' => '',
            'apellidos' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'nombre_err' => '',
            'apellidos_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => 'Registro',
                'nombre' => trim($_POST['nombre']),
                'apellidos' => trim($_POST['apellidos']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'nombre_err' => '',
                'apellidos_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Nombre
            if (empty($data['nombre'])) {
                $data['nombre_err'] = 'Por favor ingrese su nombre';
            }

            // Validate Apellidos
            if (empty($data['apellidos'])) {
                $data['apellidos_err'] = 'Por favor ingrese sus apellidos';
            }

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Por favor ingrese un email válido';
            } else {
                // Check if email exists
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'El email ya está registrado';
                }
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese una contraseña';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor confirme su contraseña';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }

            // Make sure errors are empty
            if (empty($data['nombre_err']) && empty($data['apellidos_err']) && 
                empty($data['email_err']) && empty($data['password_err']) && 
                empty($data['confirm_password_err'])) {
                // Validated
                
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register User
                if ($this->userModel->register($data)) {
                    setFlashMessage('success', 'Registro exitoso. Por favor inicie sesión.');
                    $this->redirect('/login');
                } else {
                    die('Algo salió mal');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Init data
            $data = [
                'title' => 'Registro',
                'nombre' => '',
                'apellidos' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'nombre_err' => '',
                'apellidos_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('auth/register', $data);
        }
    }

    // Create user session
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->nombre . ' ' . $user->apellidos;
        $_SESSION['user_role'] = $user->rol;
        
        if ($user->rol === 'admin') {
            $this->redirect('/admin');
        } else {
            $this->redirect('/socios');
        }
    }

    // Logout
    public function logout() {
        // Limpiar todas las variables de sesión
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir a la página de socios (que tiene el formulario de login)
        $this->redirect('/socios');
    }

    // Private area
    public function zonaPrivada() {
        $this->requireLogin();
        
        $data = [
            'title' => 'Zona Privada',
            'description' => 'Área privada de miembros de la Filá Mariscales'
        ];
        $this->view('zona-privada', $data);
    }

    // Admin dashboard
    public function admin() {
        // Redirect to admin controller
        $this->redirect('/admin');
    }

    // Página interactiva
    public function interactiva() {
        $data = [
            'title' => 'Zona Interactiva',
            'description' => 'Descubre la tradición templaria de forma interactiva'
        ];
        $this->view('pages/interactiva', $data);
    }

    // 404 page
    public function notFound() {
        $data = [
            'title' => 'Página no encontrada',
            'description' => 'La página que buscas no existe'
        ];
        $this->view('404', $data);
    }

    // Método para ver una noticia individual
    public function verNoticia($id) {
        if (!$this->newsModel || !is_numeric($id)) {
            $this->notFound();
            return;
        }

        $newsItem = $this->newsModel->getNewsById($id);

        // Solo mostrar si la noticia existe y está publicada
        if (!$newsItem || $newsItem->estado !== 'publicado') {
            $this->notFound();
            return;
        }

        $data = [
            'title' => $newsItem->titulo,
            'description' => substr(strip_tags($newsItem->contenido), 0, 160),
            'news' => $newsItem
        ];

        $this->view('pages/noticia_single', $data);
    }

    // Método para obtener eventos próximos
    private function getUpcomingEvents() {
        if ($this->eventModel) {
            try {
                $events = $this->eventModel->getRecentEvents(3);
                $formattedEvents = [];
                
                foreach ($events as $event) {
                    $formattedEvents[] = [
                        'title' => $event->titulo,
                        'description' => $event->descripcion ?? 'Evento de la Filá Mariscales',
                        'date' => $event->fecha,
                        'time' => $event->hora,
                        'location' => $event->lugar ?? 'Por determinar',
                        'status' => $event->es_publico ? 'Confirmado' : 'Próximamente',
                        'image' => !empty($event->imagen_url) ? '/' . $event->imagen_url : 'https://via.placeholder.com/400x300/8B4513/FFFFFF?text=Evento'
                    ];
                }
                
                return $formattedEvents;
            } catch (Exception $e) {
                // Si hay error, usar eventos por defecto
            }
        }
        
        // Eventos por defecto si no hay modelo o hay error
        return [
            [
                'title' => 'Presentación de la Filá',
                'description' => 'Presentación oficial de la Filá Mariscales para las fiestas 2024',
                'date' => '2024-10-15',
                'time' => '20:00',
                'location' => 'Sede Social',
                'status' => 'Próximamente',
                'image' => 'https://via.placeholder.com/400x300/8B4513/FFFFFF?text=Evento+1'
            ],
            [
                'title' => 'Cena de Hermandad',
                'description' => 'Cena de hermandad para todos los miembros de la filá',
                'date' => '2024-10-20',
                'time' => '21:00',
                'location' => 'Restaurante El Rincón',
                'status' => 'Confirmado',
                'image' => 'https://via.placeholder.com/400x300/8B4513/FFFFFF?text=Evento+2'
            ],
            [
                'title' => 'Ensayo General',
                'description' => 'Ensayo general del desfile de Moros y Cristianos',
                'date' => '2024-10-25',
                'time' => '18:00',
                'location' => 'Punto de encuentro: Ayuntamiento',
                'status' => 'Próximamente',
                'image' => 'https://via.placeholder.com/400x300/8B4513/FFFFFF?text=Evento+3'
            ]
        ];
    }

    // Método para obtener todos los eventos
    private function getAllEvents() {
        if ($this->eventModel) {
            try {
                $events = $this->eventModel->getAllEvents(1, 50); // Obtener hasta 50 eventos
                return $events;
            } catch (Exception $e) {
                // Si hay error, devolver array vacío
            }
        }
        
        return [];
    }

    // Método para obtener imágenes del carrusel
    private function getCarouselImages() {
        $uploadDir = 'uploads/carousel/';
        $images = [];
        
        if (is_dir($uploadDir)) {
            $files = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($files as $file) {
                if (is_file($file)) {
                    $fileInfo = pathinfo($file);
                    $images[] = [
                        'path' => $file,
                        'name' => $fileInfo['basename'],
                        'url' => $this->getImageUrl($file)
                    ];
                }
            }
        }
        
        // Si no hay imágenes subidas, usar imágenes por defecto
        if (empty($images)) {
            $images = [
                [
                    'path' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'name' => 'Caballeros Templarios',
                    'url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ],
                [
                    'path' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=2025&q=80',
                    'name' => 'Desfile Medieval',
                    'url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=2025&q=80'
                ],
                [
                    'path' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'name' => 'Castillo Medieval',
                    'url' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]
            ];
        }
        
        return $images;
    }

    // Método para obtener imágenes de la galería
    private function getGalleryImages() {
        $uploadDir = 'uploads/gallery/';
        $images = [];
        
        if (is_dir($uploadDir)) {
            $files = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($files as $file) {
                if (is_file($file)) {
                    $fileInfo = pathinfo($file);
                    $images[] = [
                        'thumb' => $this->getImageUrl($file),
                        'full' => $this->getImageUrl($file),
                        'caption' => 'Imagen de la Filá Mariscales',
                        'alt' => 'Galería Filá Mariscales',
                        'name' => $fileInfo['basename']
                    ];
                }
            }
        }
        
        // Si no hay imágenes subidas, usar imágenes por defecto
        if (empty($images)) {
            $images = [
                [
                    'thumb' => 'https://via.placeholder.com/300x200/8B4513/FFFFFF?text=Galería+1',
                    'full' => 'https://via.placeholder.com/800x600/8B4513/FFFFFF?text=Galería+1',
                    'caption' => 'Desfile de Moros y Cristianos 2023',
                    'alt' => 'Desfile de Moros y Cristianos'
                ],
                [
                    'thumb' => 'https://via.placeholder.com/300x200/8B4513/FFFFFF?text=Galería+2',
                    'full' => 'https://via.placeholder.com/800x600/8B4513/FFFFFF?text=Galería+2',
                    'caption' => 'Cena de Hermandad',
                    'alt' => 'Cena de Hermandad'
                ],
                [
                    'thumb' => 'https://via.placeholder.com/300x200/8B4513/FFFFFF?text=Galería+3',
                    'full' => 'https://via.placeholder.com/800x600/8B4513/FFFFFF?text=Galería+3',
                    'caption' => 'Presentación de la Filá',
                    'alt' => 'Presentación de la Filá'
                ]
            ];
        }
        
        return $images;
    }

    // Método para generar URLs de imágenes
    private function getImageUrl($filePath) {
        // Si es una URL externa, devolverla tal como está
        if (strpos($filePath, 'http') === 0) {
            return $filePath;
        }
        
        // Verificar si el acceso directo funciona
        $directUrl = '/' . $filePath;
        
        // Por ahora, usar el script servidor para asegurar que funcione
        return '/prueba-php/public/serve-image.php?path=' . urlencode($filePath);
    }
}
