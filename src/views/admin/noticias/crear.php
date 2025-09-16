<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Filá Mariscales</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
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
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
            padding: 10px;
        }
        .image-preview-container {
            text-align: center;
            margin: 20px 0;
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
                            <i class="fas fa-plus me-2"></i>
                            Nueva Noticia
                        </h1>
                        <p class="text-muted mb-0">Crea una nueva noticia para la Filá Mariscales</p>
                    </div>
                    <div>
                        <a href="http://localhost/prueba-php/public/admin/noticias" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver a Noticias
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row">
            <div class="col-12">
                <form method="POST" enctype="multipart/form-data" id="newsForm">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-edit me-2"></i>
                                        Contenido de la Noticia
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label for="titulo" class="form-label">
                                            <i class="fas fa-heading me-1"></i>Título <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" 
                                               id="titulo" name="titulo" 
                                               placeholder="Ingresa el título de la noticia" required>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-3">
                                        <label for="contenido" class="form-label">
                                            <i class="fas fa-align-left me-1"></i>Contenido <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" 
                                                  id="contenido" name="contenido" rows="15" 
                                                  placeholder="Escribe el contenido de la noticia aquí..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Status and Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-cogs me-2"></i>
                                        Configuración
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">
                                            <i class="fas fa-tag me-1"></i>Estado
                                        </label>
                                        <select class="form-select" id="estado" name="estado">
                                            <option value="borrador" selected>Borrador</option>
                                            <option value="publicado">Publicado</option>
                                            <option value="archivado">Archivado</option>
                                        </select>
                                    </div>

                                    <!-- Publication Date -->
                                    <div class="mb-3">
                                        <label for="fecha_publicacion" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>Fecha de Publicación
                                        </label>
                                        <input type="datetime-local" class="form-control" 
                                               id="fecha_publicacion" name="fecha_publicacion" 
                                               value="<?= date('Y-m-d\TH:i') ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-image me-2"></i>
                                        Imagen de Portada
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label for="imagen_portada" class="form-label">
                                            Subir Imagen
                                        </label>
                                        <input type="file" class="form-control" 
                                               id="imagen_portada" name="imagen_portada" 
                                               accept="image/jpeg,image/png,image/gif" 
                                               onchange="previewImage(this)">
                                        <div class="form-text">
                                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="image-preview-container" style="display: none;">
                                        <img id="previewImg" class="image-preview" alt="Vista previa">
                                        <div class="mt-2">
                                            <small class="text-muted">Vista previa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>
                                            Crear Noticia
                                        </button>
                                        <a href="http://localhost/prueba-php/public/admin/noticias" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Image preview function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const previewImg = document.getElementById('previewImg');
                    
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Form validation
        document.getElementById('newsForm').addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            const contenido = document.getElementById('contenido').value.trim();
            
            if (!titulo) {
                e.preventDefault();
                alert('El título es requerido');
                document.getElementById('titulo').focus();
                return;
            }
            
            if (!contenido) {
                e.preventDefault();
                alert('El contenido es requerido');
                document.getElementById('contenido').focus();
                return;
            }
        });
        
        console.log('Página de nueva noticia cargada correctamente - sin Chart.js');
    </script>
</body>
</html>
