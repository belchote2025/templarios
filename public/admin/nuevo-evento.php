<?php
// Verificar si el admin está logueado
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /prueba-php/public/admin/login');
    exit;
}

// Procesar el formulario si se envía
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica de crear evento
    $message = 'Evento creado correctamente (simulado)';
    $messageType = 'success';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Evento - Admin</title>
    
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
            <h1 class="h2">Crear Nuevo Evento</h1>
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
                        <h5 class="mb-0">Información del Evento</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título del Evento *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha *</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="hora" class="form-label">Hora *</label>
                                    <input type="time" class="form-control" id="hora" name="hora" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="lugar" class="form-label">Lugar *</label>
                                <input type="text" class="form-control" id="lugar" name="lugar" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label">Tipo de Evento</label>
                                    <select class="form-select" id="tipo" name="tipo">
                                        <option value="reunion">Reunión</option>
                                        <option value="ensayo">Ensayo</option>
                                        <option value="acto">Acto</option>
                                        <option value="celebracion">Celebración</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="activo">Activo</option>
                                        <option value="cancelado">Cancelado</option>
                                        <option value="completado">Completado</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Evento
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
                            La fecha debe ser futura o actual.
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
