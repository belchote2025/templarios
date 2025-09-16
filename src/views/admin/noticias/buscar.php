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
        }
        .search-highlight {
            background-color: #fff3cd;
            padding: 0.1rem 0.2rem;
            border-radius: 3px;
        }
        .filter-badge {
            font-size: 0.8rem;
            margin: 0.2rem;
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">
                            <i class="fas fa-search me-2"></i>
                            Búsqueda de Noticias
                        </h1>
                        <p class="text-muted mb-0">Resultados de búsqueda</p>
                    </div>
                    <div>
                        <a href="<?= URL_ROOT ?>/admin/noticias" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver a Noticias
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-filter me-2"></i>
                            Filtros de Búsqueda
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?= URL_ROOT ?>/admin/buscar-noticias">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="search" class="form-label">Buscar</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                                           placeholder="Buscar en título o contenido...">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="">Todos</option>
                                        <option value="publicado" <?= ($filters['estado'] ?? '') == 'publicado' ? 'selected' : '' ?>>
                                            Publicado
                                        </option>
                                        <option value="borrador" <?= ($filters['estado'] ?? '') == 'borrador' ? 'selected' : '' ?>>
                                            Borrador
                                        </option>
                                        <option value="archivado" <?= ($filters['estado'] ?? '') == 'archivado' ? 'selected' : '' ?>>
                                            Archivado
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecha_desde" class="form-label">Desde</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde"
                                           value="<?= htmlspecialchars($filters['fecha_desde'] ?? '') ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecha_hasta" class="form-label">Hasta</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta"
                                           value="<?= htmlspecialchars($filters['fecha_hasta'] ?? '') ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>Buscar
                                        </button>
                                        <a href="<?= URL_ROOT ?>/admin/buscar-noticias" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>Limpiar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Filters -->
        <?php if (!empty(array_filter($filters))): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-tags me-2"></i>Filtros Activos
                            </h6>
                            <div class="d-flex flex-wrap">
                                <?php foreach ($filters as $key => $value): ?>
                                    <?php if (!empty($value)): ?>
                                        <span class="badge bg-primary filter-badge">
                                            <?php
                                            $label = '';
                                            switch ($key) {
                                                case 'search':
                                                    $label = 'Búsqueda: ' . $value;
                                                    break;
                                                case 'estado':
                                                    $label = 'Estado: ' . ucfirst($value);
                                                    break;
                                                case 'fecha_desde':
                                                    $label = 'Desde: ' . $value;
                                                    break;
                                                case 'fecha_hasta':
                                                    $label = 'Hasta: ' . $value;
                                                    break;
                                            }
                                            ?>
                                            <?= $label ?>
                                            <a href="<?= URL_ROOT ?>/admin/buscar-noticias?<?= http_build_query(array_diff_key($filters, [$key => ''])) ?>" 
                                               class="text-white ms-1" style="text-decoration: none;">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Results -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Resultados de Búsqueda
                            <span class="badge bg-secondary ms-2"><?= $totalNews ?> encontradas</span>
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
                                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="Imagen de portada">
                                                    <?php else: ?>
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 60px; border-radius: 4px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>
                                                            <?php if (!empty($filters['search'])): ?>
                                                                <?= str_ireplace($filters['search'], '<span class="search-highlight">' . $filters['search'] . '</span>', htmlspecialchars($item->titulo)) ?>
                                                            <?php else: ?>
                                                                <?= htmlspecialchars($item->titulo) ?>
                                                            <?php endif; ?>
                                                        </strong>
                                                        <div class="news-content-preview text-muted small mt-1">
                                                            <?php
                                                            $content = substr(strip_tags($item->contenido), 0, 100);
                                                            if (!empty($filters['search'])) {
                                                                $content = str_ireplace($filters['search'], '<span class="search-highlight">' . $filters['search'] . '</span>', $content);
                                                            }
                                                            echo $content . '...';
                                                            ?>
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
                                                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
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
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <nav aria-label="Paginación de resultados">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($currentPage > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/buscar-noticias?<?= http_build_query(array_merge($filters, ['page' => $currentPage - 1])) ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/buscar-noticias?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= URL_ROOT ?>/admin/buscar-noticias?<?= http_build_query(array_merge($filters, ['page' => $currentPage + 1])) ?>">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h4>No se encontraron resultados</h4>
                                <p class="text-muted">No hay noticias que coincidan con los criterios de búsqueda.</p>
                                <a href="<?= URL_ROOT ?>/admin/noticias" class="btn btn-primary">
                                    <i class="fas fa-list me-1"></i>Ver Todas las Noticias
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
        // Auto-submit form on filter change
        document.getElementById('estado').addEventListener('change', function() {
            this.form.submit();
        });
        
        // Clear all filters
        document.querySelector('a[href*="buscar-noticias"]').addEventListener('click', function(e) {
            if (this.textContent.includes('Limpiar')) {
                e.preventDefault();
                window.location.href = '<?= URL_ROOT ?>/admin/buscar-noticias';
            }
        });
    </script>
</body>
</html>
