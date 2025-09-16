<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Eventos - Filá Mariscales</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .event-image { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/prueba-php/public/admin/dashboard">
                <i class="fas fa-shield-alt me-2"></i>Panel de Administración
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/prueba-php/public/admin/dashboard">Dashboard</a>
                <a class="nav-link" href="/prueba-php/public/admin/usuarios">Usuarios</a>
                <a class="nav-link active" href="/prueba-php/public/admin/eventos">Eventos</a>
                <a class="nav-link" href="/prueba-php/public/admin/galeria">Galería</a>
                <a class="nav-link" href="/prueba-php/public/admin/logout">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Gestión de Eventos</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="/prueba-php/public/admin/nuevoEvento" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Evento
                </a>
            </div>
        </div>

        <?php if (!empty($events)): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lista de Eventos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Título</th>
                                    <th>Fecha y Hora</th>
                                    <th>Lugar</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($event->imagen_url)): ?>
                                                <img src="<?= htmlspecialchars($event->imagen_url) ?>" 
                                                     alt="<?= htmlspecialchars($event->titulo) ?>" 
                                                     class="event-image">
                                            <?php else: ?>
                                                <div class="event-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($event->titulo) ?></strong>
                                            <?php if (!empty($event->descripcion)): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars(substr($event->descripcion, 0, 50)) ?>...</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold"><?= date('d/m/Y', strtotime($event->fecha)) ?></span>
                                                <small class="text-muted"><?= date('H:i', strtotime($event->hora)) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($event->ubicacion)): ?>
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                <?= htmlspecialchars($event->ubicacion) ?>
                                            <?php else: ?>
                                                <span class="text-muted">No especificado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($event->es_publico): ?>
                                                <span class="badge bg-success">Público</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Privado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="/prueba-php/public/admin/editarEvento/<?= $event->id ?>" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Editar evento">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/prueba-php/public/admin/eliminarEvento/<?= $event->id ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('¿Estás seguro de eliminar este evento? Esta acción no se puede deshacer.')"
                                                   title="Eliminar evento">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Navegación de páginas" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="/prueba-php/public/admin/eventos/<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No hay eventos programados</h4>
                <p class="text-muted">Crea tu primer evento para comenzar a gestionar la agenda.</p>
                <a href="/prueba-php/public/admin/nuevoEvento" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Crear Evento
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
