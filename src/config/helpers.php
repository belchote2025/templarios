<?php
// Redirect to a specific URL
function redirect($url) {
    header("Location: " . URL_ROOT . $url);
    exit();
}

// Send a notification to admin via FormSubmit
function sendFormSubmitNotification($subject, $message, $name = 'Notificación', $fromEmail = 'no-reply@filamariscales.es', $extraFields = []) {
    if (!defined('FORMSUBMIT_TO')) {
        error_log('FORMSUBMIT_TO is not defined. Cannot send FormSubmit notification.');
        return false;
    }

    $payload = array_merge([
        'name' => $name,
        'email' => $fromEmail,
        'message' => $message,
        '_subject' => $subject,
        '_template' => 'table',
        '_captcha' => 'false'
    ], $extraFields);

    $url = 'https://formsubmit.co/' . FORMSUBMIT_TO;

    // Prefer cURL
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $response = curl_exec($ch);
        if ($response === false) {
            error_log('FormSubmit cURL error: ' . curl_error($ch));
        } elseif (defined('FORMSUBMIT_LOG_SUCCESS') && FORMSUBMIT_LOG_SUCCESS) {
            error_log('[FormSubmit] OK subject=' . ($payload['_subject'] ?? '(no subject)'));
        }
        curl_close($ch);
        return $response !== false;
    }

    // Fallback to stream context
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($payload),
            'timeout' => 8
        ]
    ];
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        error_log('FormSubmit stream error: unable to send request');
        return false;
    } elseif (defined('FORMSUBMIT_LOG_SUCCESS') && FORMSUBMIT_LOG_SUCCESS) {
        error_log('[FormSubmit] OK subject=' . ($payload['_subject'] ?? '(no subject)'));
    }
    return true;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Get flash message
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return '';
}

// Set flash message
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

// Sanitize input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Format date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Check if current page matches the given path
function isActive($path) {
    $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $base_path = parse_url(URL_ROOT, PHP_URL_PATH);
    $current_path = str_replace($base_path, '', $current_path);
    return $current_path === $path ? 'active' : '';
}

// Generate CSRF token
function generateCsrfToken() {
    if (class_exists('SecurityHelper')) {
        return SecurityHelper::generateCsrfToken();
    }
    
    // Fallback if SecurityHelper is not available
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes(32));
    } else {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}
