<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden text-white py-8 py-lg-10 mb-6" style="background: rgba(220, 20, 60, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('<?= URL_ROOT ?>/assets/images/pattern-dots-light.svg') repeat; opacity: 0.1;"></div>
    <div class="position-absolute bottom-0 end-0">
        <div class="position-relative" style="width: 300px; height: 300px;">
            <div class="position-absolute bottom-0 end-0 w-100 h-100 bg-white bg-opacity-10 rounded-circle" style="animation: pulse 8s ease-in-out infinite;"></div>
            <div class="position-absolute bottom-0 end-0 w-100 h-100 bg-white bg-opacity-5 rounded-circle" style="animation: pulse 8s ease-in-out 2s infinite;"></div>
        </div>
    </div>
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <span class="badge bg-white bg-opacity-10 text-white px-4 py-2 rounded-pill mb-4 d-inline-flex align-items-center">
                    <i class="bi bi-newspaper me-2"></i>
                    <span>Últimas noticias</span>
                </span>
                <h1 class="display-3 fw-bold mb-3">Noticias y <span class="text-warning">Actualidad</span></h1>
                <p class="lead mb-0 mx-auto" style="max-width: 700px; opacity: 0.9;">Mantente informado sobre las últimas novedades, eventos y actividades de la Filá Mariscales de Caballeros Templarios de Elche.</p>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- News Section -->
<section class="py-6 py-lg-8 position-relative">
    <div class="container position-relative">
        <?php if (!empty($news)): ?>
            <div class="row g-4">
                <?php foreach($news as $index => $item): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <article class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="<?= !empty($item->imagen_portada) ? URL_ROOT . '/serve-image.php?path=uploads/news/' . urlencode($item->imagen_portada) : URL_ROOT . '/assets/images/noticia_placeholder.jpg' ?>" class="card-img-top h-100 w-100" alt="<?= htmlspecialchars($item->titulo) ?>" style="object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-danger bg-opacity-90 px-3 py-2">Novedad</span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark-top">
                                    <small class="text-white-50"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($item->fecha_publicacion)) ?></small>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5 card-title fw-bold mb-3 flex-grow-1"><?= htmlspecialchars($item->titulo) ?></h3>
                                <p class="card-text text-muted mb-4"><?= substr(strip_tags($item->contenido), 0, 120) ?>...</p>
                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <a href="<?= URL_ROOT ?>/noticia/<?= $item->id ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <span>Leer más</span>
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                    <small class="text-muted"><i class="bi bi-person me-1"></i> <?= htmlspecialchars(explode(' ', $item->autor_nombre)[0]) ?></small>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4>No hay noticias disponibles</h4>
                <p class="text-muted">Actualmente no hay noticias publicadas. Vuelve a visitarnos pronto.</p>
            </div>
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <nav aria-label="Paginación de noticias" class="mt-6" data-aos="fade-up">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item"><a class="page-link rounded-pill me-2" href="<?= URL_ROOT ?>/noticias/<?= $currentPage - 1 ?>"><i class="bi bi-chevron-left me-1"></i> Anterior</a></li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item d-none d-sm-block <?= $i == $currentPage ? 'active' : '' ?>"><a class="page-link rounded-circle mx-1" href="<?= URL_ROOT ?>/noticias/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item"><a class="page-link rounded-pill ms-2" href="<?= URL_ROOT ?>/noticias/<?= $currentPage + 1 ?>">Siguiente <i class="bi bi-chevron-right ms-1"></i></a></li>
                    <?php endif; ?>
                </ul>
                <div class="text-center mt-3">
                    <small class="text-muted">Página <?= $currentPage ?> de <?= $totalPages ?></small>
                </div>
            </nav>
        <?php endif; ?>
    </div>
    
    <!-- Background Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('<?= URL_ROOT ?>/assets/images/pattern-dots-light.svg') repeat; opacity: 0.05;"></div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-7 py-lg-9 position-relative overflow-hidden bg-light">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('<?= URL_ROOT ?>/assets/images/pattern-dots.svg') repeat; opacity: 0.03;"></div>
    <div class="position-absolute bottom-0 end-0">
        <div class="position-relative" style="width: 300px; height: 300px;">
            <div class="position-absolute bottom-0 end-0 w-100 h-100 bg-danger bg-opacity-10 rounded-circle" style="animation: pulse 8s ease-in-out infinite;"></div>
            <div class="position-absolute bottom-0 end-0 w-100 h-100 bg-danger bg-opacity-05 rounded-circle" style="animation: pulse 8s ease-in-out 2s infinite;"></div>
        </div>
    </div>
    
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <span class="badge bg-danger bg-opacity-10 text-danger px-4 py-2 rounded-pill mb-4 d-inline-flex align-items-center">
                    <i class="bi bi-envelope-paper-heart me-2"></i>
                    <span>Mantente informado</span>
                </span>
                <h2 class="display-5 fw-bold mb-4">Suscríbete a nuestro <span class="text-gradient">boletín</span></h2>
                <p class="lead text-muted mb-5 mx-auto" style="max-width: 600px;">Recibe las últimas noticias, eventos y actualizaciones directamente en tu correo electrónico. ¡No te pierdas nada de lo que ocurre en la Filá Mariscales!</p>
                
                <form id="newsletterForm" class="row g-3 justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-md-8">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-end-0" id="email-addon">
                                <i class="bi bi-envelope text-danger"></i>
                            </span>
                            <input type="email" id="emailInput" class="form-control border-start-0 ps-0" placeholder="tucorreo@ejemplo.com" aria-label="Correo electrónico" aria-describedby="email-addon" required>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" id="subscribeBtn" class="btn btn-primary btn-lg px-5 py-3 fw-semibold hover-lift shadow">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-send-check me-2"></i>
                                <span>Suscribirme</span>
                            </span>
                        </button>
                    </div>
                </form>
                
                <div class="mt-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="privacyPolicy" required>
                        <label class="form-check-label small text-muted" for="privacyPolicy">
                            Acepto la <a href="/prueba-php/public/privacidad" class="text-decoration-none">política de privacidad</a>
                        </label>
                    </div>
                </div>
                
                <div class="mt-5" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-muted mb-3">También puedes seguirnos en:</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-outline-primary rounded-circle p-3 hover-lift" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary rounded-circle p-3 hover-lift" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary rounded-circle p-3 hover-lift" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary rounded-circle p-3 hover-lift" data-bs-toggle="tooltip" data-bs-placement="top" title="YouTube">
                            <i class="bi bi-youtube fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="position-absolute bottom-0 start-0 w-100">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('emailInput');
    const subscribeBtn = document.getElementById('subscribeBtn');
    const privacyCheckbox = document.getElementById('privacyPolicy');
    
    // Función para enviar email usando FormSubmit
    function enviarEmailFormSubmit(formData) {
        // Crear formulario temporal para FormSubmit
        const tempForm = document.createElement('form');
        tempForm.action = 'https://formsubmit.co/edu300572@gmail.com';
        tempForm.method = 'POST';
        tempForm.style.display = 'none';
        
        // Agregar campos
        Object.keys(formData).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = formData[key];
            tempForm.appendChild(input);
        });
        
        // Agregar al DOM y enviar
        document.body.appendChild(tempForm);
        tempForm.submit();
        
        // Limpiar después de un momento
        setTimeout(() => {
            document.body.removeChild(tempForm);
        }, 1000);
    }
    
    // Función para mostrar mensaje de éxito
    function showSuccessMessage() {
        // Crear modal de éxito
        const modal = document.createElement('div');
        modal.className = 'modal fade show';
        modal.style.display = 'block';
        modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-check-circle me-2"></i>
                            ¡Suscripción Exitosa!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" onclick="cerrarModal()"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-envelope-check text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-success mb-3">¡Bienvenido a nuestro boletín!</h4>
                        <p class="text-muted">Te has suscrito correctamente a nuestro boletín de noticias. Recibirás las últimas novedades de la Filá Mariscales directamente en tu correo electrónico.</p>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>¡Email enviado!</strong> Hemos enviado un email de bienvenida a tu correo electrónico. Revisa tu bandeja de entrada (y la carpeta de spam si no lo encuentras).
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success" onclick="cerrarModal()">
                            <i class="bi bi-check me-2"></i>
                            Entendido
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Cerrar modal al hacer clic fuera
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModal();
            }
        });
    }
    
    // Función para cerrar modal
    window.cerrarModal = function() {
        const modal = document.querySelector('.modal');
        if (modal) {
            modal.remove();
        }
    };
    
    // Función para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Función para mostrar error
    function showError(message) {
        // Crear alerta de error
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        alert.style.top = '20px';
        alert.style.right = '20px';
        alert.style.zIndex = '9999';
        alert.style.minWidth = '300px';
        alert.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alert);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
    
    // Manejar envío del formulario
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = emailInput.value.trim();
        const privacyAccepted = privacyCheckbox.checked;
        
        // Validaciones
        if (!email) {
            showError('Por favor, introduce tu dirección de correo electrónico.');
            emailInput.focus();
            return;
        }
        
        if (!isValidEmail(email)) {
            showError('Por favor, introduce una dirección de correo electrónico válida.');
            emailInput.focus();
            return;
        }
        
        if (!privacyAccepted) {
            showError('Debes aceptar la política de privacidad para continuar.');
            privacyCheckbox.focus();
            return;
        }
        
        // Deshabilitar botón durante el envío
        subscribeBtn.disabled = true;
        subscribeBtn.innerHTML = `
            <span class="d-flex align-items-center">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                <span>Suscribiendo...</span>
            </span>
        `;
        
        // Enviar datos al servidor
        const formData = {
            email: email,
            privacy: privacyAccepted
        };
        
        fetch('/prueba-php/public/newsletter-formsubmit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Enviar email usando FormSubmit
                enviarEmailFormSubmit(data.formData);
                
                showSuccessMessage();
                
                // Limpiar formulario
                emailInput.value = '';
                privacyCheckbox.checked = false;
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión. Por favor, inténtalo de nuevo.');
        })
        .finally(() => {
            // Restaurar botón
            subscribeBtn.disabled = false;
            subscribeBtn.innerHTML = `
                <span class="d-flex align-items-center">
                    <i class="bi bi-send-check me-2"></i>
                    <span>Suscribirme</span>
                </span>
            `;
        });
    });
    
    // Validación en tiempo real del email
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        if (email && !isValidEmail(email)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Validación del checkbox de privacidad
    privacyCheckbox.addEventListener('change', function() {
        if (this.checked) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
