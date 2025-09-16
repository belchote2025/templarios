<?php
// Redirect to a specific URL
function redirect($url) {
    header("Location: " . URL_ROOT . $url);
    exit();
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
