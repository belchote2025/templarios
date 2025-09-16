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
        .news-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 2rem;
            border-radius: 8px 8px 0 0;
        }
        .news-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        .news-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .news-meta {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .action-buttons {
            position: sticky;
            top: 20px;
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
                            <i class="fas fa-eye me-2"></i>
                            Ver Noticia
                        </h1>
                        <p class="text-muted mb-0">Vista previa de la noticia</p>
                    </div>
                    <div>
                        <a href="<?= URL_ROOT ?>/admin/noticias" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver a Noticias
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card">
                    <!-- News Header -->
                    <div class="news-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="h2 mb-3"><?= htmlspecialchars($news->titulo) ?></h1>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i>
                                    <span class="me-4"><?= htmlspecialchars($news->autor_nombre . ' ' . $news->autor_apellidos) ?></span>
                                    <i class="fas fa-calendar me-2"></i>
                                    <span><?= date('d/m/Y H:i', strtotime($news->fecha_publicacion)) ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <?php
                                $statusClass = '';
                                $statusText = '';
                                switch ($news->estado) {
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
                                <span class="badge <?= $statusClass ?> status-badge">
                                    <i class="fas fa-<?= $news->estado == 'publicado' ? 'check-circle' : ($news->estado == 'borrador' ? 'edit' : 'archive') ?> me-1"></i>
                                    <?= $statusText ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- News Body -->
                    <div class="card-body">
                        <!-- Featured Image -->
                        <?php if (!empty($news->imagen_portada)): ?>
                            <div class="mb-4">
                                <img src="http://localhost/prueba-php/public/serve-image.php?path=uploads/news/<?= urlencode($news->imagen_portada) ?>" 
                                     class="news-image" alt="Imagen de portada">
                            </div>
                        <?php endif; ?>

                        <!-- News Content -->
                        <div class="news-content">
                            <?= nl2br(htmlspecialchars($news->contenido)) ?>
                        </div>

                        <!-- News Meta -->
                        <div class="news-meta mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-info-circle me-1"></i>Información
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>ID:</strong> #<?= $news->id ?></li>
                                        <li><strong>Estado:</strong> <?= ucfirst($news->estado) ?></li>
                                        <li><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($news->fecha_publicacion)) ?></li>
                                        <?php if ($news->fecha_actualizacion && $news->fecha_actualizacion != $news->fecha_publicacion): ?>
                                            <li><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($news->fecha_actualizacion)) ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-user me-1"></i>Autor
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Nombre:</strong> <?= htmlspecialchars($news->autor_nombre . ' ' . $news->autor_apellidos) ?></li>
                                        <li><strong>ID de autor:</strong> #<?= $news->autor_id ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body action-buttons">
                        <div class="d-grid gap-2">
                            <a href="<?= URL_ROOT ?>/admin/editar-noticia/<?= $news->id ?>" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i>Editar Noticia
                            </a>
                            
                            <?php if ($news->estado !== 'publicado'): ?>
                                <a href="<?= URL_ROOT ?>/admin/cambiar-estado-noticia/<?= $news->id ?>/publicado" 
                                   class="btn btn-success">
                                    <i class="fas fa-check me-1"></i>Publicar
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($news->estado !== 'borrador'): ?>
                                <a href="<?= URL_ROOT ?>/admin/cambiar-estado-noticia/<?= $news->id ?>/borrador" 
                                   class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i>Guardar como Borrador
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($news->estado !== 'archivado'): ?>
                                <a href="<?= URL_ROOT ?>/admin/cambiar-estado-noticia/<?= $news->id ?>/archivado" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-archive me-1"></i>Archivar
                                </a>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <a href="<?= URL_ROOT ?>/admin/eliminar-noticia/<?= $news->id ?>" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('¿Estás seguro de que quieres eliminar esta noticia? Esta acción no se puede deshacer.')">
                                <i class="fas fa-trash me-1"></i>Eliminar Noticia
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News Statistics -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Estadísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1"><?= strlen($news->contenido) ?></h4>
                                    <small class="text-muted">Caracteres</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1"><?= str_word_count($news->contenido) ?></h4>
                                <small class="text-muted">Palabras</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-info mb-1"><?= substr_count($news->contenido, "\n") + 1 ?></h4>
                                    <small class="text-muted">Párrafos</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-1">
                                    <?= $news->imagen_portada ? 'Sí' : 'No' ?>
                                </h4>
                                <small class="text-muted">Imagen</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Vista Previa
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            Vista previa de cómo se verá la noticia en el sitio web público.
                        </p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" onclick="previewNews()">
                                <i class="fas fa-eye me-1"></i>Vista Previa
                            </button>
                            <?php if ($news->estado == 'publicado'): ?>
                                <a href="<?= URL_ROOT ?>/noticias/<?= $news->id ?>" 
                                   class="btn btn-outline-success" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>Ver en Público
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Preview news function
        function previewNews() {
            // Create a modal with the news preview
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vista Previa - <?= htmlspecialchars($news->titulo) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="news-preview">
                                <h1><?= htmlspecialchars($news->titulo) ?></h1>
                                <div class="text-muted mb-3">
                                    <i class="fas fa-user me-1"></i>
                                    <?= htmlspecialchars($news->autor_nombre . ' ' . $news->autor_apellidos) ?>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= date('d/m/Y H:i', strtotime($news->fecha_publicacion)) ?>
                                </div>
                                <?php if (!empty($news->imagen_portada)): ?>
                                    <img src="http://localhost/prueba-php/public/serve-image.php?path=uploads/news/<?= urlencode($news->imagen_portada) ?>" 
                                         class="img-fluid mb-3" alt="Imagen de portada">
                                <?php endif; ?>
                                <div class="news-content">
                                    <?= nl2br(htmlspecialchars($news->contenido)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            // Remove modal from DOM when hidden
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        }
        
        // Confirm delete action
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
