<!-- Hero Section -->
<section class="hero-section text-white text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                    <span class="text-gradient">Filá Mariscales</span>
                </h1>
                <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">
                    Caballeros Templarios de Elche
                </p>
                <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                    <a href="#about" class="btn btn-light btn-lg px-4 py-3 hover-lift">
                        <i class="bi bi-info-circle me-2"></i>Conócenos
                    </a>
                    <a href="#events" class="btn btn-outline-light btn-lg px-4 py-3 hover-lift">
                        <i class="bi bi-calendar-event me-2"></i>Próximos Eventos
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-7 py-lg-9">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="text-danger mb-2 d-inline-block fw-semibold">Sobre Nosotros</span>
                <h2 class="fw-bold display-5 mb-4">Nuestra <span class="text-gradient">Historia</span></h2>
                <p class="lead text-muted mb-4">
                    La Filá Mariscales es una de las filaes más antiguas y tradicionales de los Caballeros Templarios de Elche. 
                    Fundada en 1945, hemos mantenido viva la tradición de las fiestas de Moros y Cristianos de Elche durante más de 75 años.
                </p>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-shield-check text-danger display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-semibold mb-1">Tradición</h5>
                                <p class="text-muted mb-0">Más de 75 años de historia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-people text-danger display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-semibold mb-1">Comunidad</h5>
                                <p class="text-muted mb-0">Familias unidas por la tradición</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="/prueba-php/public/historia" class="btn btn-primary btn-lg px-4 py-3 hover-lift me-3">
                        <i class="bi bi-book me-2"></i>Más sobre nosotros
                    </a>
                    <a href="/prueba-php/public/libro" class="btn btn-outline-primary btn-lg px-4 py-3 hover-lift">
                        <i class="bi bi-journal-text me-2"></i>Historia de la Filá Mariscales
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-5">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="display-4 fw-bold text-danger">75+</div>
                                <p class="text-muted mb-0">Años de Historia</p>
                            </div>
                            <div class="col-6">
                                <div class="display-4 fw-bold text-danger">1945</div>
                                <p class="text-muted mb-0">Tradición desde</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="py-7 py-lg-9 bg-light">
    <div class="container">
        <div class="text-center mb-6" data-aos="fade-up">
            <span class="text-danger mb-2 d-inline-block fw-semibold">Nuestros Eventos</span>
            <h2 class="fw-bold display-5 mb-3">Próximas <span class="text-gradient">Actividades</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Descubre los próximos eventos y actividades que tenemos preparados para ti. ¡No te pierdas nada!
            </p>
        </div>
        
        <div class="row g-4">
            <?php if (isset($data['upcoming_events']) && is_array($data['upcoming_events'])): ?>
                <?php foreach ($data['upcoming_events'] as $index => $event): ?>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="position-relative overflow-hidden rounded-top">
                            <img src="<?php echo $event['image']; ?>" class="card-img-top" alt="<?php echo $event['title']; ?>">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-<?php echo $event['status'] === 'Próximamente' ? 'primary' : 'success'; ?> bg-opacity-90 px-3 py-2">
                                    <?php echo $event['status']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $event['title']; ?></h5>
                            <p class="card-text text-muted"><?php echo $event['description']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt-fill me-1"></i><?php echo $event['location']; ?>
                                </small>
                                <a href="#" class="btn btn-sm btn-outline-primary">Más info</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No hay eventos próximos disponibles.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-6" data-aos="fade-up" data-aos-delay="100">
            <a href="/prueba-php/public/calendario" class="btn btn-primary btn-lg px-5 py-3 hover-lift">
                <span class="d-flex align-items-center">
                    <span>Ver todos los eventos</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-7 py-lg-9">
    <div class="container">
        <div class="text-center mb-6" data-aos="fade-up">
            <span class="text-danger mb-2 d-inline-block fw-semibold">Nuestra Galería</span>
            <h2 class="fw-bold display-5 mb-3">Momentos <span class="text-gradient">Inolvidables</span></h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Revive los mejores momentos de nuestra filá a través de estas imágenes que capturan la esencia de nuestra tradición.
            </p>
        </div>
        
        <div class="row g-4">
            <?php if (isset($data['gallery']) && is_array($data['gallery'])): ?>
                <?php 
                $galleryItems = array_slice($data['gallery'], 0, 6);
                foreach ($galleryItems as $index => $image): 
                ?>
                <div class="col-md-4 col-6" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                    <div class="gallery-item position-relative overflow-hidden rounded-3 shadow-sm hover-scale">
                        <div class="gallery-image-container">
                            <img src="<?php echo $image['thumb']; ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>" class="gallery-image">
                        </div>
                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 transition-all">
                            <div class="text-white text-center p-3">
                                <i class="bi bi-zoom-in display-6 mb-2"></i>
                                <h6 class="mb-0 fw-semibold"><?php echo htmlspecialchars($image['caption']); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No hay imágenes disponibles en la galería.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-6" data-aos="fade-up" data-aos-delay="100">
            <a href="/prueba-php/public/galeria" class="btn btn-outline-danger btn-lg px-5 py-3 hover-lift">
                <span class="d-flex align-items-center">
                    <span>Ver galería completa</span>
                    <i class="bi bi-images ms-2"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<style>
/* Estilos para la galería de fotos uniforme */
.gallery-item {
    height: 100%;
}

.gallery-image-container {
    width: 100%;
    height: 300px; /* Altura fija para todas las imágenes */
    overflow: hidden;
    border-radius: 15px;
    position: relative;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Mantiene la proporción y cubre todo el contenedor */
    object-position: center; /* Centra la imagen */
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-image {
    transform: scale(1.05);
}

.gallery-overlay {
    border-radius: 15px;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .gallery-image-container {
        height: 250px;
    }
}

@media (max-width: 576px) {
    .gallery-image-container {
        height: 200px;
    }
}
</style>