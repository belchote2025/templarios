<?php
require_once __DIR__ . '/../helpers/SecurityHelper.php';

class AuthController extends Controller {
    private $userModel;
    private $securityHelper;

    public function __construct() {
        $this->userModel = $this->model('User');
        $this->securityHelper = new SecurityHelper();
        
        // Configurar headers de seguridad
        $this->securityHelper->setSecurityHeaders();
        
        // Iniciar sesión segura
        $this->initSecureSession();
    }
    
    // Inicializar sesión segura
    private function initSecureSession() {
        $config = require __DIR__ . '/../config/security.php';
        
        // Configuración de la sesión
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
        ini_set('session.cookie_samesite', $config['session']['same_site']);
        
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Regenerar ID de sesión periódicamente
        $this->regenerateSessionId();
    }
    
    // Regenerar ID de sesión
    private function regenerateSessionId() {
        $config = require __DIR__ . '/../config/security.php';
        
        if (!isset($_SESSION['last_regeneration'])) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 1800) { // 30 minutos
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }

    // Verificar límite de tasa de registro por IP
    private function checkRegistrationRateLimit($ip) {
        $config = require __DIR__ . '/../config/security.php';
        $db = new Database();
        
        // Contar registros de esta IP en las últimas 24 horas
        $db->query('SELECT COUNT(*) as count FROM user_registrations 
                   WHERE ip_address = :ip AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)');
        $db->bind(':ip', $ip);
        $result = $db->single();
        
        if ($result->count >= $config['registration']['max_per_day']) {
            $this->logSecurityEvent('registration_rate_limit', 'IP bloqueada por exceso de registros: ' . $ip);
            setFlashMessage('error', 'Se ha excedido el límite de registros permitidos. Por favor, inténtelo más tarde.');
            redirect('/');
        }
    }
    
    // Enviar correo de verificación
    private function sendVerificationEmail($email, $token) {
        $config = require __DIR__ . '/../config/security.php';
        $verificationUrl = URLROOT . '/verify-email?token=' . $token;
        
        $to = $email;
        $subject = 'Verifica tu correo electrónico';
        $message = "
            <h2>Bienvenido a Filá Mariscales</h2>
            <p>Por favor, haz clic en el siguiente enlace para verificar tu dirección de correo electrónico:</p>
            <p><a href='$verificationUrl'>$verificationUrl</a></p>
            <p>Si no has creado una cuenta, puedes ignorar este correo.</p>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $config['mail']['from_address'] . "\r\n";
        
        // En un entorno de producción, usaría una biblioteca como PHPMailer
        @mail($to, $subject, $message, $headers);
    }
    
    // Registrar actividad del usuario
    private function logActivity($userId, $action, $details = '') {
        $db = new Database();
        $db->query('INSERT INTO user_activity_logs (user_id, action, ip_address, user_agent, details, created_at) 
                   VALUES (:user_id, :action, :ip, :ua, :details, NOW())');
        $db->bind(':user_id', $userId);
        $db->bind(':action', $action);
        $db->bind(':ip', $_SERVER['REMOTE_ADDR']);
        $db->bind(':ua', $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
        $db->bind(':details', $details);
        $db->execute();
    }
    
    // Registrar error de seguridad
    private function logSecurityEvent($eventType, $details) {
        $db = new Database();
        $db->query('INSERT INTO security_logs (event_type, ip_address, user_agent, details, created_at) 
                   VALUES (:event_type, :ip, :ua, :details, NOW())');
        $db->bind(':event_type', $eventType);
        $db->bind(':ip', $_SERVER['REMOTE_ADDR']);
        $db->bind(':ua', $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
        $db->bind(':details', $details);
        $db->execute();
    }
    
    // Registrar error de la aplicación
    private function logError($message) {
        $logFile = __DIR__ . '/../../logs/error_' . date('Y-m-d') . '.log';
        $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
    
    // Show registration form
    public function register() {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('/');
        }

        $data = [
            'title' => 'Registro de Usuario',
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
            // Verificar token CSRF
            if (empty($_POST['csrf_token']) || !$this->securityHelper->validateCsrfToken($_POST['csrf_token'])) {
                setFlashMessage('error', 'Token de seguridad inválido. Por favor, inténtelo de nuevo.');
                redirect('/register');
            }
            
            // Sanitizar y validar datos
            $data = [
                'title' => 'Registro de Usuario',
                'nombre' => $this->securityHelper->sanitizeInput($_POST['nombre'] ?? ''),
                'apellidos' => $this->securityHelper->sanitizeInput($_POST['apellidos'] ?? ''),
                'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'nombre_err' => '',
                'apellidos_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validar IP para prevenir abuso
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->checkRegistrationRateLimit($ip);

            // Validate Name
            if (empty($data['nombre'])) {
                $data['nombre_err'] = 'Por favor ingrese su nombre';
            }

            // Validate Apellidos
            if (empty($data['apellidos'])) {
                $data['apellidos_err'] = 'Por favor ingrese sus apellidos';
            }

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su correo electrónico';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'El correo electrónico ya está registrado';
                }
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese una contraseña';
            } else {
                $passwordErrors = $this->securityHelper->validatePasswordStrength($data['password']);
                if (!empty($passwordErrors)) {
                    $data['password_err'] = implode(' ', $passwordErrors);
                }
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor confirme la contraseña';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['nombre_err']) && 
                empty($data['apellidos_err']) && empty($data['password_err']) && 
                empty($data['confirm_password_err'])) {
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 2]);
                
                // Generar token de verificación
                $verificationToken = $this->securityHelper->generateSecureToken();
                $data['verification_token'] = $verificationToken;
                $data['email_verified'] = 0; // 0 = no verificado, 1 = verificado

                // Register user
                if ($userId = $this->userModel->register($data)) {
                    // Enviar correo de verificación
                    $this->sendVerificationEmail($data['email'], $verificationToken);
                    
                    // Registrar actividad
                    $this->logActivity($userId, 'register', 'Nuevo registro de usuario');
                    
                    setFlashMessage('success', '¡Registro exitoso! Por favor verifica tu correo electrónico para activar tu cuenta.');
                    redirect('/login');
                } else {
                    $this->logError('Error al registrar usuario: ' . json_encode($data));
                    setFlashMessage('error', 'Ocurrió un error al registrar tu cuenta. Por favor, inténtalo de nuevo.');
                    $this->view('auth/register', $data);
                }
            }
        }

        // Load view
        $this->view('auth/register', $data);
    }

    // Show login form
    public function login() {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('/');
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
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Process form data
            $data = [
                'title' => 'Iniciar Sesión',
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su correo electrónico';
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
                $data['email_err'] = 'No se encontró ninguna cuenta con ese correo electrónico';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Contraseña incorrecta';
                    $this->view('auth/login', $data);
                }
            }
        }

        // Load view
        $this->view('auth/login', $data);
    }

    // Create user session
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->nombre;
        $_SESSION['user_role'] = $user->rol;
        
        // Update last login
        $this->userModel->updateLastLogin($user->id);
        
        // Redirect based on user role
        if ($user->rol === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/mi-cuenta');
        }
    }

    // Logout user
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        
        setFlashMessage('success', 'Has cerrado sesión correctamente');
        redirect('/login');
    }

    // Forgot password
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $email = trim($_POST['email']);
            
            if (empty($email)) {
                $data['email_err'] = 'Por favor ingrese su correo electrónico';
            } elseif (!$this->userModel->findUserByEmail($email)) {
                $data['email_err'] = 'No se encontró ninguna cuenta con ese correo electrónico';
            }
            
            if (empty($data['email_err'])) {
                // Generate token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                if ($this->userModel->createPasswordResetToken($email, $token, $expires)) {
                    // Send email with reset link
                    $resetLink = URL_ROOT . '/reset-password/' . $token;
                    
                    // In a real app, you would send an email here
                    // $this->sendPasswordResetEmail($email, $resetLink);
                    
                    setFlashMessage('success', 'Se ha enviado un enlace de restablecimiento a su correo electrónico');
                    redirect('/login');
                } else {
                    die('Algo salió mal al procesar su solicitud');
                }
            }
        }
        
        $data = [
            'title' => 'Recuperar Contraseña',
            'email' => $email ?? '',
            'email_err' => $data['email_err'] ?? ''
        ];
        
        $this->view('auth/forgot-password', $data);
    }
    
    // Reset password form
    public function resetPassword($token = '') {
        if (empty($token)) {
            redirect('/forgot-password');
        }
        
        // Validate token
        $user = $this->userModel->findUserByResetToken($token);
        
        if (!$user || strtotime($user->token_expires) < time()) {
            setFlashMessage('error', 'El enlace de restablecimiento no es válido o ha expirado');
            redirect('/forgot-password');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => 'Restablecer Contraseña',
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token' => $token,
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese una nueva contraseña';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor confirme la contraseña';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }
            
            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash new password
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                
                if ($this->userModel->updatePassword($user->id, $hashedPassword)) {
                    // Delete the token
                    $this->userModel->deleteResetToken($token);
                    
                    setFlashMessage('success', 'Su contraseña ha sido actualizada. Por favor inicie sesión.');
                    redirect('/login');
                } else {
                    die('Algo salió mal al actualizar la contraseña');
                }
            }
            
            $this->view('auth/reset-password', $data);
        } else {
            $data = [
                'title' => 'Restablecer Contraseña',
                'token' => $token,
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            $this->view('auth/reset-password', $data);
        }
    }
}
