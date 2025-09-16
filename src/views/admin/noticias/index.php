<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Filá Mariscales</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Admin CSS -->
    <link href="/prueba-php/public/assets/css/admin.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card { 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .news-item {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .news-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .news-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .news-content-preview {
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>¡Éxito!</strong> La noticia se ha creado correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">
                            <i class="fas fa-newspaper me-2"></i>
                            Gestión de Noticias
                        </h1>
                        <p class="text-muted mb-0">Administra las noticias y publicaciones de la Filá</p>
                    </div>
                    <div>
                        <a href="http://localhost/prueba-php/public/admin/nueva-noticia" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i>Nueva Noticia
                        </a>
                        <a href="<?= URL_ROOT ?>/admin/dashboard" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Total</h5>
                                <h2 class="mb-0"><?= $newsStats['total'] ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-newspaper fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Publicadas</h5>
                                <h2 class="mb-0"><?= $newsStats['published'] ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Borradores</h5>
                                <h2 class="mb-0"><?= $newsStats['draft'] ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-edit fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Archivadas</h5>
                                <h2 class="mb-0"><?= $newsStats['archived'] ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-archive fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Este Mes</h5>
                                <h2 class="mb-0"><?= $newsStats['this_month'] ?? 0 ?></h2>
                            </div>
                            <i class="fas fa-calendar fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">Acciones</h5>
                                <h6 class="mb-0">Gestionar</h6>
                            </div>
                            <i class="fas fa-cogs fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-search me-2"></i>
                            Buscar y Filtrar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?= URL_ROOT ?>/admin/buscar-noticias">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="search" class="form-label">Buscar</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           placeholder="Buscar en título o contenido...">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="">Todos</option>
                                        <option value="publicado">Publicado</option>
                                        <option value="borrador">Borrador</option>
                                        <option value="archivado">Archivado</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecha_desde" class="form-label">Desde</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecha_hasta" class="form-label">Hasta</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- News List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Lista de Noticias
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($news)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-image me-1"></i>Imagen</th>
                                            <th><i class="fas fa-heading me-1"></i>Título</th>
                                            <th><i class="fas fa-user me-1"></i>Autor</th>
                                            <th><i class="fas fa-tag me-1"></i>Estado</th>
                                            <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                            <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($news as $item): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($item->imagen_portada)): ?>
                                                        <img src="http://localhost/prueba-php/public/serve-image.php?path=uploads/news/<?= urlencode($item->imagen_portada) ?>" 
                                                             class="news-image" alt="Imagen de portada">
                                                    <?php else: ?>
                                                        <div class="news-image bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong><?= htmlspecialchars($item->titulo) ?></strong>
                                                        <div class="news-content-preview text-muted small mt-1">
                                                            <?= htmlspecialchars(substr(strip_tags($item->contenido), 0, 100)) ?>...
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        <?= htmlspecialchars($item->autor_nombre . ' ' . $item->autor_apellidos) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($item->estado) {
                                                        case 'publicado':
                                                            $statusClass = 'bg-success';
                                                            $statusText = 'Publicado';
                                                            break;
                                                        case 'borrador':
                                                            $statusClass = 'bg-warning';
                                                            $statusText = 'Borrador';
                                                            break;
                                                        case 'archivado':
                                                            $statusClass = 'bg-secondary';
                                                            $statusText = 'Archivado';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?= $statusClass ?> status-badge"><?= $statusText ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <?= date('d/m/Y H:i', strtotime($item->fecha_publicacion)) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= URL_ROOT ?>/admin/ver-noticia/<?= $item->id ?>" 
                                                           class="btn btn-outline-primary" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= URL_ROOT ?>/admin/editar-noticia/<?= $item->id ?>" 
                                                           class="btn btn-outline-success" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <?php if ($item->estado !== 'publicado'): ?>
                                                            <a href="<?= URL_ROOT ?>/admin/cambiar-estado-noticia/<?= $item->id ?>/publicado" 
                                                               class="btn btn-outline-info" title="Publicar">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if ($item->estado !== 'archivado'): ?>
                                                            <a href="<?= URL_ROOT ?>/admin/cambiar-estado-noticia/<?= $item->id ?>/archivado" 
                                                               class="btn btn-outline-warning" title="Archivar">
                                                                <i class="fas fa-archive"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="<?= URL_ROOT ?>/admin/eliminar-noticia/<?= $item->id ?>" 
                                                           class="btn btn-outline-danger" title="Eliminar"
                                                           onclick="return confirm('¿Estás seguro de que quieres eliminar esta noticia?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <nav aria-label="Paginación de noticias">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($currentPage > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/noticias/<?= $currentPage - 1 ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/noticias/<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/noticias/<?= $currentPage + 1 ?>">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-newspaper"></i>
                                <h4>No hay noticias disponibles</h4>
                                <p>No se encontraron noticias en el sistema.</p>
                                <a href="http://localhost/prueba-php/public/admin/nueva-noticia" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Crear Primera Noticia
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-submit search form on filter change
        document.getElementById('estado').addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
        
        // Confirm delete actions
        document.querySelectorAll('a[href*="eliminar-noticia"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que quieres eliminar esta noticia? Esta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
