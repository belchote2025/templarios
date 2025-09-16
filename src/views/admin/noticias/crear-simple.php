<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Noticia - Filá Mariscales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1>Nueva Noticia</h1>
                <p>Formulario para crear una nueva noticia</p>
                
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h5>Errores encontrados:</h5>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="10" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="borrador">Borrador</option>
                            <option value="publicado">Publicado</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen_portada" accept="image/*" onchange="previewImage(this)">
                        
                        <!-- Vista previa de la imagen -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="previewImg" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Crear Noticia
                    </button>
                    
                    <a href="http://localhost/prueba-php/public/admin/noticias" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función para mostrar vista previa de la imagen
        function previewImage(input) {
            console.log('previewImage called');
            console.log('Input files:', input.files);
            
            if (input.files && input.files[0]) {
                console.log('File selected:', input.files[0].name);
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    console.log('FileReader onload called');
                    const preview = document.getElementById('imagePreview');
                    const previewImg = document.getElementById('previewImg');
                    
                    console.log('Preview element:', preview);
                    console.log('PreviewImg element:', previewImg);
                    
                    if (preview && previewImg) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                        console.log('Image preview shown');
                    } else {
                        console.error('Preview elements not found');
                    }
                };
                
                reader.onerror = function(e) {
                    console.error('FileReader error:', e);
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                console.log('No file selected');
                const preview = document.getElementById('imagePreview');
                if (preview) {
                    preview.style.display = 'none';
                }
            }
        }
        
        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
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
            
            // Mostrar mensaje de confirmación
            if (!confirm('¿Estás seguro de que quieres crear esta noticia?')) {
                e.preventDefault();
                return;
            }
        });
        
        console.log('Formulario de nueva noticia cargado correctamente');
        
        // Verificar que los elementos existen al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const imageInput = document.getElementById('imagen');
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            console.log('Image input:', imageInput);
            console.log('Preview div:', preview);
            console.log('Preview img:', previewImg);
            
            if (imageInput) {
                console.log('Image input found, adding event listener');
                // Agregar event listener adicional por si acaso
                imageInput.addEventListener('change', function() {
                    console.log('Change event triggered');
                    previewImage(this);
                });
            }
        });
    </script>
</body>
</html>
