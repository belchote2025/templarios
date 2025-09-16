<!-- Hero Section -->
<section class="hero-section text-white text-center py-8 mb-8" style="background: linear-gradient(rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.05)), url('/mariscales1-php/public/assets/images/backgrounds/knight-templar-background.jpg') center/cover; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Zona de Descargas</h1>
        <p class="lead">Documentos y archivos para socios y simpatizantes</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Search and Filter -->
        <div class="row mb-5">
            <div class="col-md-8 mb-3 mb-md-0">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar documentos...">
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="categoryFilter">
                    <option value="">Todas las categorías</option>
                    <option value="documentos-oficiales">Documentos Oficiales</option>
                    <option value="formularios">Formularios</option>
                    <option value="publicaciones">Publicaciones</option>
                    <option value="multimedia">Multimedia</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
        </div>
        
        <!-- Documents Grid -->
        <div class="row g-4 mb-5">
            <!-- Document 1 -->
            <div class="col-md-6 col-lg-4" data-category="documentos-oficiales">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-pdf text-danger display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Estatutos de la Filá Mariscales</h5>
                                <p class="text-muted small mb-2">Actualizados en enero 2025</p>
                                <div class="badge bg-light text-dark mb-2">Documento Oficial</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Documento completo con los estatutos actualizados de la Filá Mariscales.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">PDF • 2.4 MB</span>
                            <a href="/mariscales1-php/public/assets/documents/estatutos-2025.pdf" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document 2 -->
            <div class="col-md-6 col-lg-4" data-category="formularios">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-word text-danger display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Solicitud de Alta como Socio</h5>
                                <p class="text-muted small mb-2">Formulario editable</p>
                                <div class="badge bg-light text-dark mb-2">Formulario</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Formulario para solicitar el alta como socio de la Filá Mariscales.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">DOCX • 1.1 MB</span>
                            <a href="/mariscales1-php/public/assets/documents/solicitud-alta-socio.docx" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document 3 -->
            <div class="col-md-6 col-lg-4" data-category="publicaciones">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-image text-success display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Revista Anual 2024</h5>
                                <p class="text-muted small mb-2">Publicación digital</p>
                                <div class="badge bg-light text-dark mb-2">Publicación</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Revista conmemorativa del año 2024 de la Filá Mariscales.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">PDF • 15.7 MB</span>
                            <a href="/mariscales1-php/public/assets/documents/revista-2024.pdf" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document 4 -->
            <div class="col-md-6 col-lg-4" data-category="multimedia">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-music text-warning display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Himno de la Filá (MP3)</h5>
                                <p class="text-muted small mb-2">Versión oficial</p>
                                <div class="badge bg-light text-dark mb-2">Audio</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Versión completa del himno de la Filá Mariscales en formato MP3.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">MP3 • 8.3 MB</span>
                            <a href="/mariscales1-php/public/assets/audio/himno-oficial.mp3" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document 5 -->
            <div class="col-md-6 col-lg-4" data-category="formularios">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-excel text-success display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Planilla de Inscripción Evento</h5>
                                <p class="text-muted small mb-2">Formulario editable</p>
                                <div class="badge bg-light text-dark mb-2">Formulario</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Planilla para inscribirse en los próximos eventos programados.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">XLSX • 0.8 MB</span>
                            <a href="/mariscales1-php/public/assets/documents/inscripcion-eventos.xlsx" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Document 6 -->
            <div class="col-md-6 col-lg-4" data-category="documentos-oficiales">
                <div class="card h-100 border-0 shadow-sm document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light p-3 rounded me-3">
                                <i class="bi bi-file-earmark-pdf text-danger display-6"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Memoria Anual 2024</h5>
                                <p class="text-muted small mb-2">Informe de actividades</p>
                                <div class="badge bg-light text-dark mb-2">Documento Oficial</div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">Memoria detallada de las actividades realizadas durante el año 2024.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">PDF • 5.2 MB</span>
                            <a href="/mariscales1-php/public/assets/documents/memoria-2024.pdf" class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upload Section (for logged-in users) -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-light">
                <h3 class="h5 mb-0">Subir Documento</h3>
            </div>
            <div class="card-body">
                <form id="uploadForm">
                    <div class="mb-3">
                        <label for="documentTitle" class="form-label">Título del Documento</label>
                        <input type="text" class="form-control" id="documentTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="documentCategory" class="form-label">Categoría</label>
                        <select class="form-select" id="documentCategory" required>
                            <option value="">Selecciona una categoría</option>
                            <option value="documentos-oficiales">Documentos Oficiales</option>
                            <option value="formularios">Formularios</option>
                            <option value="publicaciones">Publicaciones</option>
                            <option value="multimedia">Multimedia</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Archivo</label>
                        <input class="form-control" type="file" id="documentFile" required>
                        <div class="form-text">Formatos aceptados: PDF, DOCX, XLSX, JPG, PNG, MP3 (máx. 20MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="documentDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="documentDescription" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Subir Documento
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Help Section -->
        <div class="card border-0 bg-light">
            <div class="card-body text-center p-5">
                <i class="bi bi-question-circle display-4 text-danger mb-3"></i>
                <h3>¿Necesitas ayuda?</h3>
                <p class="lead">Si tienes problemas para descargar o encontrar algún documento, no dudes en contactarnos.</p>
                <a href="/prueba-php/public/contacto" class="btn btn-outline-primary">
                    <i class="bi bi-envelope me-1"></i> Contactar
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Document filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const clearSearchBtn = document.getElementById('clearSearch');
    const documentCards = document.querySelectorAll('.document-card');
    
    function filterDocuments() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        
        documentCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            const category = card.getAttribute('data-category');
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            if (matchesSearch && matchesCategory) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterDocuments);
    categoryFilter.addEventListener('change', filterDocuments);
    
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterDocuments();
    });
    
    // Form submission
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically handle the file upload via AJAX
            alert('Documento subido correctamente (simulación)');
            this.reset();
        });
    }
});
</script>
