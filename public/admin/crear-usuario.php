    1→<?php
// Verificar si el admin está logueado
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /prueba-php/public/admin/login');
    exit;
}

// Colocar el working dir en la raíz del proyecto para usar rutas relativas como en public/index.php
chdir(dirname(__DIR__, 2));

// Cargar configuración y utilidades necesarias
require_once 'src/config/config.php';
require_once 'src/config/email_config.php';

// Instanciar modelo de usuario
$userModel = new User();

// Procesar el formulario si se envía
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanear datos
    $nombre    = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';
    $rol       = $_POST['rol'] ?? 'user';
    $activo    = isset($_POST['activo']) ? 1 : 0;

    $errors = [];

    if ($nombre === '') { $errors[] = 'El nombre es obligatorio.'; }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'El email no es válido.'; }
    if (strlen($password) < 6) { $errors[] = 'La contraseña debe tener al menos 6 caracteres.'; }
    if ($password !== $confirm) { $errors[] = 'Las contraseñas no coinciden.'; }

    // Comprobar email único
    if (empty($errors) && $userModel->findUserByEmail($email)) {
        $errors[] = 'El correo electrónico ya está registrado.';
    }

    if (!empty($errors)) {
        $message = implode('<br>', $errors);
        $messageType = 'danger';
    } else {
        // Hashear contraseña (consistente con AuthController)
        $hashed = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 2]);

        $data = [
            'nombre'    => $nombre,
            'apellidos' => $apellidos,
            'email'     => $email,
            'password'  => $hashed,
            'rol'       => $rol,
            'activo'    => $activo,
        ];

        if ($userModel->register($data)) {
            // Componer y enviar email de bienvenida
            $loginUrl = URL_ROOT . '/login';
            $subject  = 'Bienvenido/a a ' . SITE_NAME;
            $body = "<h2>¡Bienvenido/a, {$nombre}!</h2>"
                  . "<p>Tu cuenta ha sido creada correctamente.</p>"
                  . "<p><strong>Datos de acceso</strong></p>"
                  . "<ul>"
                  . "<li>Usuario (email): <strong>{$email}</strong></li>"
                  . "<li>Contraseña: <strong>{$password}</strong></li>"
                  . "</ul>"
                  . "<p>Puedes iniciar sesión aquí: <a href='{$loginUrl}'>{$loginUrl}</a></p>"
                  . "<p style='font-size:12px;color:#666'>Te recomendamos cambiar la contraseña tras el primer inicio de sesión.</p>";

            $sent = enviarEmail($email, $subject, $body);

            if ($sent) {
                $message = 'Usuario creado correctamente y email de bienvenida enviado.';
            } else {
                $message = 'Usuario creado correctamente, pero no se pudo enviar el email de bienvenida.';
            }
            $messageType = 'success';
        } else {
            $message = 'Ocurrió un error al crear el usuario.';
            $messageType = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario - Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/prueba-php/public/admin/dashboard">
                <i class="fas fa-shield-alt me-2"></i>Panel de Administración
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/prueba-php/public/admin/dashboard">Dashboard</a>
                <a class="nav-link" href="/prueba-php/public/admin/usuarios">Usuarios</a>
                <a class="nav-link" href="/prueba-php/public/admin/eventos">Eventos</a>
                <a class="nav-link" href="/prueba-php/public/admin/galeria">Galería</a>
                <a class="nav-link" href="/prueba-php/public/admin/logout">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Crear Nuevo Usuario</h1>
            <a href="/prueba-php/public/admin/dashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
            </a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Información del Usuario</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Contraseña *</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol">
                                    <option value="user" <?= (($_POST['rol'] ?? '') === 'user') ? 'selected' : '' ?>>Usuario</option>
                                    <option value="socio" <?= (($_POST['rol'] ?? '') === 'socio') ? 'selected' : '' ?>>Socio</option>
                                    <option value="admin" <?= (($_POST['rol'] ?? '') === 'admin') ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="activo" name="activo" <?= isset($_POST['activo']) ? 'checked' : 'checked' ?>>
                                    <label class="form-check-label" for="activo">
                                        Usuario activo
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Usuario
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Información</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">
                            Los campos marcados con * son obligatorios.
                        </p>
                        <p class="text-muted small">
                            La contraseña debe tener al menos 6 caracteres.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
