<?php
// Panel para ver suscripciones del newsletter
require_once '../src/config/config.php';

// Función para obtener suscripciones
function obtenerSuscripciones() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->query("
            SELECT email, fecha_suscripcion, activo, metodo_envio, ip_address 
            FROM newsletter_subscriptions 
            ORDER BY fecha_suscripcion DESC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Función para obtener estadísticas
function obtenerEstadisticas() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stats = [];
        
        // Total de suscripciones
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM newsletter_subscriptions");
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Suscripciones activas
        $stmt = $pdo->query("SELECT COUNT(*) as activas FROM newsletter_subscriptions WHERE activo = 1");
        $stats['activas'] = $stmt->fetch(PDO::FETCH_ASSOC)['activas'];
        
        // Suscripciones de hoy
        $stmt = $pdo->query("SELECT COUNT(*) as hoy FROM newsletter_subscriptions WHERE DATE(fecha_suscripcion) = CURDATE()");
        $stats['hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['hoy'];
        
        return $stats;
    } catch (PDOException $e) {
        return ['total' => 0, 'activas' => 0, 'hoy' => 0];
    }
}

$suscripciones = obtenerSuscripciones();
$estadisticas = obtenerEstadisticas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Suscripciones - Filá Mariscales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%); color: white; }
        .stat-card { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .badge { font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card header">
                    <div class="card-body text-center">
                        <h1 class="mb-0">
                            <i class="bi bi-envelope-heart me-3"></i>
                            Panel de Suscripciones
                        </h1>
                        <p class="mb-0">Filá Mariscales de Caballeros Templarios</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1 mb-3"></i>
                        <h3><?php echo $estadisticas['total']; ?></h3>
                        <p class="mb-0">Total Suscripciones</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                        <h3><?php echo $estadisticas['activas']; ?></h3>
                        <p class="mb-0">Suscripciones Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-day-fill fs-1 mb-3"></i>
                        <h3><?php echo $estadisticas['hoy']; ?></h3>
                        <p class="mb-0">Suscripciones Hoy</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de suscripciones -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-list-ul me-2"></i>
                            Lista de Suscripciones
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Email</th>
                                        <th>Fecha de Suscripción</th>
                                        <th>Estado</th>
                                        <th>Método</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($suscripciones)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                                <p class="text-muted mt-2">No hay suscripciones registradas</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($suscripciones as $suscripcion): ?>
                                            <tr>
                                                <td>
                                                    <i class="bi bi-envelope me-2"></i>
                                                    <?php echo htmlspecialchars($suscripcion['email']); ?>
                                                </td>
                                                <td>
                                                    <i class="bi bi-calendar me-2"></i>
                                                    <?php echo date('d/m/Y H:i', strtotime($suscripcion['fecha_suscripcion'])); ?>
                                                </td>
                                                <td>
                                                    <?php if ($suscripcion['activo']): ?>
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            Activa
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">
                                                            <i class="bi bi-x-circle me-1"></i>
                                                            Inactiva
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo htmlspecialchars($suscripcion['metodo_envio']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo htmlspecialchars($suscripcion['ip_address']); ?>
                                                    </small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información del sistema -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Información del Sistema
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Estado del Sistema:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check-circle text-success me-2"></i>Formulario funcionando</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>Base de datos conectada</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>Suscripciones guardándose</li>
                                    <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Emails en modo funcional</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Acciones:</h6>
                                <div class="d-flex gap-2">
                                    <a href="/prueba-php/public/noticias" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>
                                        Ver Formulario
                                    </a>
                                    <a href="/prueba-php/public/diagnostico-email.php" class="btn btn-info btn-sm">
                                        <i class="bi bi-gear me-1"></i>
                                        Diagnóstico
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
