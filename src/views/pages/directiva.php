<!-- Hero Section -->
<section class="hero-section text-white text-center py-8 mb-8" style="background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), url('/mariscales1-php/public/assets/images/backgrounds/knight-templar-background.jpg') center/cover; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Junta Directiva</h1>
        <p class="lead">Conoce al equipo que dirige la Filá Mariscales</p>
    </div>
</section>

<!-- Board Members Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h2 class="fw-bold mb-3">Nuestra Junta Directiva 2024-2026</h2>
                <p class="lead text-muted">Un equipo comprometido con el crecimiento y la tradición de nuestra filá</p>
            </div>
        </div>
        
        <!-- President -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <img src="/mariscales1-php/public/assets/images/presidente.jpg" class="img-fluid rounded-start" alt="Presidente">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title fw-bold mb-1">Juan Pérez</h4>
                                        <h5 class="text-danger mb-3">Presidente</h5>
                                    </div>
                                    <div class="social-icons">
                                        <a href="#" class="text-dark me-2"><i class="bi bi-envelope-fill"></i></a>
                                        <a href="#" class="text-dark"><i class="bi bi-telephone-fill"></i></a>
                                    </div>
                                </div>
                                <p class="card-text">Con más de 15 años en la directiva, Juan lidera nuestro proyecto con pasión y dedicación, trabajando incansablemente por el crecimiento de nuestra filá.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Vice President & Secretary -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="/mariscales1-php/public/assets/images/vicepresidente.jpg" class="rounded-circle mb-3" width="150" alt="Vicepresidente">
                        <h4 class="card-title fw-bold mb-1">María López</h4>
                        <h5 class="text-danger mb-3">Vicepresidenta</h5>
                        <p class="card-text">Apoyando la gestión y coordinando los diferentes departamentos para el correcto funcionamiento de la filá.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="/mariscales1-php/public/assets/images/secretario.jpg" class="rounded-circle mb-3" width="150" alt="Secretario">
                        <h4 class="card-title fw-bold mb-1">Carlos Martínez</h4>
                        <h5 class="text-danger mb-3">Secretario</h5>
                        <p class="card-text">Encargado de la documentación, actas y comunicación oficial de la filá.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Treasurer & Members -->
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="/mariscales1-php/public/assets/images/tesorero.jpg" class="rounded-circle mb-3" width="120" alt="Tesorero">
                        <h5 class="fw-bold mb-1">Antonio García</h5>
                        <p class="text-muted mb-3">Tesorero</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="/mariscales1-php/public/assets/images/vocal1.jpg" class="rounded-circle mb-3" width="120" alt="Vocal 1">
                        <h5 class="fw-bold mb-1">Laura Sánchez</h5>
                        <p class="text-muted mb-3">Vocal de Actividades</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="/mariscales1-php/public/assets/images/vocal2.jpg" class="rounded-circle mb-3" width="120" alt="Vocal 2">
                        <h5 class="fw-bold mb-1">David Torres</h5>
                        <p class="text-muted mb-3">Vocal de Comunicación</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-4">¿Quieres contactar con nosotros?</h2>
                <p class="lead mb-4">Estamos a tu disposición para cualquier consulta o sugerencia</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/prueba-php/public/contacto" class="btn btn-danger btn-lg">Enviar mensaje</a>
                    <button type="button" class="btn btn-outline-danger btn-lg" onclick="mostrarTelefono()">Llamar ahora</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function mostrarTelefono() {
    const numero = '+34 900 123 456';
    
    // Crear modal personalizado
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.display = 'block';
    modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-telephone me-2"></i>
                        Número de Teléfono
                    </h5>
                    <button type="button" class="btn-close btn-close-white" onclick="cerrarModal()"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-telephone-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="text-danger mb-3">${numero}</h3>
                    <p class="text-muted">Horario de atención: Lunes a Viernes 18:00 - 20:00</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="copiarNumero('${numero}')">
                            <i class="bi bi-clipboard me-2"></i>
                            Copiar
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="cerrarModal()">
                            <i class="bi bi-x-circle me-2"></i>
                            Cerrar
                        </button>
                    </div>
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

function cerrarModal() {
    const modal = document.querySelector('.modal');
    if (modal) {
        modal.remove();
    }
}

function copiarNumero(numero) {
    navigator.clipboard.writeText(numero).then(function() {
        // Mostrar mensaje de confirmación
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-2"></i>Copiado!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        alert('No se pudo copiar el número: ' + err);
    });
}
</script>
