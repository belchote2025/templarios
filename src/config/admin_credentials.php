<?php
// Credenciales de Administrador
// Archivo de configuración para el panel de administración

// Credenciales por defecto
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

// Credenciales alternativas
define('ADMIN_USERNAME_ALT', 'administrador');
define('ADMIN_PASSWORD_ALT', 'admin');

// Configuración de seguridad
define('ADMIN_SESSION_TIMEOUT', 3600); // 1 hora
define('ADMIN_MAX_LOGIN_ATTEMPTS', 5);
define('ADMIN_LOCKOUT_TIME', 900); // 15 minutos

// Función para verificar credenciales de administrador
function verifyAdminCredentials($username, $password) {
    // Verificar credenciales principales
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        return true;
    }
    
    // Verificar credenciales alternativas
    if ($username === ADMIN_USERNAME_ALT && $password === ADMIN_PASSWORD_ALT) {
        return true;
    }
    
    return false;
}

// Función para crear sesión de administrador
function createAdminSession($username) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_role'] = 'admin';
    $_SESSION['admin_login_time'] = time();
}

// Función para verificar si el administrador está logueado
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && 
           $_SESSION['admin_logged_in'] === true &&
           isset($_SESSION['admin_login_time']) &&
           (time() - $_SESSION['admin_login_time']) < ADMIN_SESSION_TIMEOUT;
}

// Función para cerrar sesión de administrador
function logoutAdmin() {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_username']);
    unset($_SESSION['admin_role']);
    unset($_SESSION['admin_login_time']);
    session_destroy();
}

// Función para obtener información del administrador
function getAdminInfo() {
    if (isAdminLoggedIn()) {
        return [
            'username' => $_SESSION['admin_username'] ?? 'Admin',
            'role' => $_SESSION['admin_role'] ?? 'admin',
            'login_time' => $_SESSION['admin_login_time'] ?? time()
        ];
    }
    return null;
}
?>





