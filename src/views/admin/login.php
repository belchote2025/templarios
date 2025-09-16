<?php
require_once dirname(dirname(dirname(__DIR__))) . '/src/config/admin_credentials.php';

// Definir función redirect si no existe
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: " . $url);
        exit();
    }
}

// Si ya está logueado, redirigir al dashboard
if (isAdminLoggedIn()) {
    redirect('/admin/dashboard');
}

// Procesar login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (verifyAdminCredentials($username, $password)) {
        createAdminSession($username);
        redirect('/admin/dashboard');
    } else {
        $error = 'Credenciales incorrectas. Inténtalo de nuevo.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - Filá Mariscales</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    
    <style>
    :root {
        --templar-red: #DC143C;
        --templar-red-dark: #8B0000;
        --templar-white: #FFFFFF;
        --templar-gold: #FFD700;
    }
    
    body {
        font-family: 'Crimson Text', serif;
        background: linear-gradient(135deg, 
            rgba(220, 20, 60, 0.1) 0%, 
            rgba(255, 255, 255, 0.9) 50%, 
            rgba(220, 20, 60, 0.1) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 3px solid var(--templar-red);
        backdrop-filter: blur(10px);
        max-width: 400px;
        width: 100%;
        padding: 2.5rem;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--templar-red) 0%, var(--templar-red-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 5px 15px rgba(220, 20, 60, 0.3);
    }
    
    .login-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .login-title {
        font-family: 'Cinzel', serif;
        font-size: 1.8rem;
        color: var(--templar-red);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }
    
    .login-subtitle {
        color: #6c757d;
        font-size: 1rem;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: var(--templar-red);
        box-shadow: 0 0 0 0.2rem rgba(220, 20, 60, 0.25);
    }
    
    .btn-login {
        background: linear-gradient(135deg, var(--templar-red) 0%, var(--templar-red-dark) 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 20, 60, 0.3);
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    .alert-danger {
        background: rgba(220, 20, 60, 0.1);
        color: var(--templar-red);
        border-left: 4px solid var(--templar-red);
    }
    
    .credentials-info {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid var(--templar-gold);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
        font-size: 0.9rem;
    }
    
    .credentials-info h6 {
        color: var(--templar-gold);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .credentials-info p {
        margin-bottom: 0.25rem;
        color: #6c757d;
    }
    
    .back-link {
        text-align: center;
        margin-top: 1rem;
    }
    
    .back-link a {
        color: var(--templar-red);
        text-decoration: none;
        font-weight: 600;
    }
    
    .back-link a:hover {
        text-decoration: underline;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h1 class="login-title">Panel de Administración</h1>
            <p class="login-subtitle">Filá Mariscales de Caballeros Templarios</p>
        </div>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="bi bi-person me-2"></i>Usuario
                </label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-2"></i>Contraseña
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-login btn-outline-light w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>
        </form>
        
        <div class="credentials-info">
            <h6><i class="bi bi-info-circle me-2"></i>Credenciales de Prueba</h6>
            <p><strong>Usuario:</strong> admin</p>
            <p><strong>Contraseña:</strong> admin123</p>
            <p><small>O alternativamente: administrador / admin</small></p>
        </div>
        
        <div class="back-link">
            <a href="/prueba-php/public/">
                <i class="bi bi-arrow-left me-2"></i>Volver al sitio principal
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

