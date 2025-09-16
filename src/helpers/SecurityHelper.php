<?php

class SecurityHelper {
    private static $securityConfig;
    
    public static function init() {
        self::$securityConfig = require_once __DIR__ . '/../config/security.php';
    }
    
    // Generar token CSRF
    public static function generateCsrfToken() {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes(32));
        } else {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
    
    // Validar token CSRF
    public static function validateCsrfToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
    
    // Validar fortaleza de contraseña
    public static function validatePasswordStrength($password) {
        $config = self::$securityConfig['password'];
        $errors = [];
        
        if (strlen($password) < $config['min_length']) {
            $errors[] = "La contraseña debe tener al menos {$config['min_length']} caracteres.";
        }
        
        if ($config['require_mixed_case'] && !preg_match('/(?=.*[a-z])(?=.*[A-Z])/', $password)) {
            $errors[] = "La contraseña debe contener letras mayúsculas y minúsculas.";
        }
        
        if ($config['require_numbers'] && !preg_match('/[0-9]/', $password)) {
            $errors[] = "La contraseña debe contener al menos un número.";
        }
        
        if ($config['require_symbols'] && !preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "La contraseña debe contener al menos un carácter especial.";
        }
        
        return $errors;
    }
    
    // Registrar intento de inicio de sesión fallido
    public static function logFailedLoginAttempt($email, $ip) {
        $key = 'login_attempts_' . md5($email . $ip);
        $attempts = $_SESSION[$key] ?? 0;
        $attempts++;
        $_SESSION[$key] = $attempts;
        
        // Registrar el intento fallido en la base de datos
        $db = new Database();
        $db->query('INSERT INTO login_attempts (email, ip_address, user_agent, created_at) VALUES (:email, :ip, :ua, NOW())');
        $db->bind(':email', $email);
        $db->bind(':ip', $ip);
        $db->bind(':ua', $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
        $db->execute();
        
        return $attempts;
    }
    
    // Verificar si la IP o el usuario están bloqueados
    public static function isBlocked($email, $ip) {
        $key = 'login_attempts_' . md5($email . $ip);
        $attempts = $_SESSION[$key] ?? 0;
        
        if ($attempts >= self::$securityConfig['login_attempts']['max_attempts']) {
            return true;
        }
        
        // Verificar en la base de datos
        $db = new Database();
        $db->query('SELECT COUNT(*) as count FROM login_attempts WHERE (email = :email OR ip_address = :ip) AND created_at > DATE_SUB(NOW(), INTERVAL :minutes MINUTE)');
        $db->bind(':email', $email);
        $db->bind(':ip', $ip);
        $db->bind(':minutes', self::$securityConfig['login_attempts']['lockout_time'] / 60);
        $result = $db->single();
        
        return $result->count >= self::$securityConfig['login_attempts']['max_attempts'];
    }
    
    // Limpiar intentos exitosos
    public static function clearLoginAttempts($email, $ip) {
        $key = 'login_attempts_' . md5($email . $ip);
        unset($_SESSION[$key]);
    }
    
    // Generar token seguro
    public static function generateSecureToken($length = 32) {
        return bin2hex(random_bytes($length));
    }
    
    // Sanitizar entrada
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    // Configurar headers de seguridad
    public static function setSecurityHeaders() {
        $headers = self::$securityConfig['headers'];
        
        foreach ($headers as $header => $value) {
            $headerName = str_replace('_', '-', ucwords($header, '_'));
            header("$headerName: $value");
        }
    }
}

// Inicializar la clase de seguridad
SecurityHelper::init();
