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
    
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
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
                <a class="nav-link" href="/prueba-php/public/admin/eventos">Eventos</a>
                <a class="nav-link" href="/prueba-php/public/admin/galeria">Galería</a>
                <a class="nav-link" href="/prueba-php/public/admin/logout">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $title ?></h1>
            <a href="/prueba-php/public/admin/eventos" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Eventos
            </a>
        </div>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger">
                <?= $errors['general'] ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/prueba-php/public/admin/nuevoEvento" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Información del Evento</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título del Evento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= !empty($errors['titulo']) ? 'is-invalid' : '' ?>" 
                                       id="titulo" name="titulo" value="<?= htmlspecialchars($event->titulo ?? '') ?>" required>
                                <?php if (!empty($errors['titulo'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['titulo'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="5"><?= 
                                    htmlspecialchars($event->descripcion ?? '') 
                                ?></textarea>
                                <div class="form-text">Describe los detalles del evento, actividades, requisitos, etc.</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control <?= !empty($errors['fecha']) ? 'is-invalid' : '' ?>" 
                                               id="fecha" name="fecha" value="<?= $event->fecha ?? date('Y-m-d') ?>" required>
                                        <?php if (!empty($errors['fecha'])): ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['fecha'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="hora" class="form-label">Hora <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="hora" name="hora" 
                                               value="<?= $event->hora ?? '20:00' ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación/Lugar</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                                       value="<?= htmlspecialchars($event->ubicacion ?? '') ?>"
                                       placeholder="Ej: Sede de la Filá, Plaza Mayor, etc.">
                                <div class="form-text">Especifica dónde se realizará el evento</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Configuración</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="es_publico" class="form-label">Visibilidad del Evento</label>
                                <select class="form-select" id="es_publico" name="es_publico">
                                    <option value="1" <?= ($event->es_publico ?? 1) == 1 ? 'selected' : '' ?>>Público</option>
                                    <option value="0" <?= ($event->es_publico ?? 1) == 0 ? 'selected' : '' ?>>Privado</option>
                                </select>
                                <div class="form-text">
                                    Los eventos públicos son visibles para todos los visitantes.<br>
                                    Los eventos privados solo son visibles para usuarios registrados.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen del Evento</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                                <div class="form-text">
                                    Formatos: JPG, PNG, GIF. Tamaño máximo: 5MB
                                </div>
                            </div>
                            
                            <?php if (!empty($event->imagen_url)): ?>
                                <div class="mb-3">
                                    <label class="form-label">Imagen Actual</label>
                                    <img src="<?= htmlspecialchars($event->imagen_url) ?>" 
                                         alt="Imagen del evento" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Evento
                                </button>
                                <a href="/prueba-php/public/admin/eventos" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Auto-save draft functionality
    let autoSaveTimer;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                // Save form data to localStorage
                const formData = new FormData(form);
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                localStorage.setItem('eventDraft', JSON.stringify(data));
            }, 2000);
        });
    });
    
    // Load draft on page load
    window.addEventListener('load', () => {
        const draft = localStorage.getItem('eventDraft');
        if (draft && !document.querySelector('input[name="titulo"]').value) {
            const data = JSON.parse(draft);
            Object.keys(data).forEach(key => {
                const input = document.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                }
            });
        }
    });
    
    // Clear draft on successful submit
    form.addEventListener('submit', () => {
        localStorage.removeItem('eventDraft');
    });
    </script>
</body>
</html>
