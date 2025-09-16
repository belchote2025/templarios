<?php
/**
 * Configuración de seguridad
 * Filá Mariscales
 */

return [
    // Configuración de contraseñas
    'password' => [
        'min_length' => 8,
        'require_mixed_case' => true,
        'require_numbers' => true,
        'require_symbols' => false,
        'max_age_days' => 90
    ],
    
    // Configuración de intentos de login
    'login_attempts' => [
        'max_attempts' => 5,
        'lockout_time' => 900, // 15 minutos en segundos
        'reset_after_success' => true
    ],
    
    // Headers de seguridad
    'headers' => [
        'X_Frame_Options' => 'DENY',
        'X_Content_Type_Options' => 'nosniff',
        'X_XSS_Protection' => '1; mode=block',
        'Referrer_Policy' => 'strict-origin-when-cross-origin',
        'Content_Security_Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://code.jquery.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://unpkg.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/ https://cdnjs.cloudflare.com; img-src 'self' data: https:; connect-src 'self';"
    ],
    
    // Configuración de sesión
    'session' => [
        'lifetime' => 3600, // 1 hora
        'regenerate_id' => true,
        'secure_cookies' => false, // Cambiar a true en producción con HTTPS
        'http_only' => true,
        'same_site' => 'Lax'
    ],
    
    // Configuración de CSRF
    'csrf' => [
        'token_length' => 32,
        'expire_time' => 3600 // 1 hora
    ],
    
    // Configuración de rate limiting
    'rate_limit' => [
        'enabled' => true,
        'requests_per_minute' => 60,
        'burst_limit' => 10
    ],
    
    // Configuración de logging
    'logging' => [
        'enabled' => true,
        'log_failed_logins' => true,
        'log_successful_logins' => false,
        'log_admin_actions' => true
    ]
];
