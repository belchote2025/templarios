<!-- Hero Section with Carousel -->
<div class="hero particles" style="position: relative; min-height: 100vh; display: flex; align-items: center; overflow: hidden;">
    
    <!-- Carrusel de Fotos -->
    <div id="heroCarousel" class="carousel slide" style="position: absolute; width: 100%; height: 100%; z-index: 1; background: rgba(0,0,0,0.3);" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner" style="height: 100%;">
            
            <?php if (!empty($carousel_images)): ?>
                <?php foreach ($carousel_images as $index => $image): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" style="height: 100vh;">
                        <div class="carousel-image-container" style="width: 100%; height: 100%; background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo $image['url']; ?>') center/cover; position: absolute; top: 0; left: 0;"></div>
                        <div class="carousel-caption d-none d-md-block scroll-reveal">
                            <h2 class="animate-fadeInDown text-shimmer" style="font-size: 3rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);"><?php echo htmlspecialchars($image['name']); ?></h2>
                            <p class="animate-fadeInUp" style="font-size: 1.5rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Filá Mariscales</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback si no hay imágenes -->
                <div class="carousel-item active" style="height: 100vh;">
                    <div class="carousel-image-container" style="width: 100%; height: 100%; background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover; position: absolute; top: 0; left: 0;"></div>
                    <div class="carousel-caption d-none d-md-block">
                        <h2 style="font-size: 3rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Caballeros Templarios</h2>
                        <p style="font-size: 1.5rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Tradición y Honor</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Controles del Carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 50px; height: 50px; background: rgba(139, 0, 0, 0.5); border: 2px solid #FFFFFF; border-radius: 50%; top: 50%; transform: translateY(-50%); z-index: 10;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 50px; height: 50px; background: rgba(139, 0, 0, 0.5); border: 2px solid #FFFFFF; border-radius: 50%; top: 50%; transform: translateY(-50%); z-index: 10;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
        
        <!-- Indicadores del Carrusel -->
        <?php if (!empty($carousel_images)): ?>
            <div class="carousel-indicators" style="bottom: 30px; z-index: 10;">
                <?php foreach ($carousel_images as $index => $image): ?>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $index; ?>" 
                            class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                            aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                            aria-label="Slide <?php echo $index + 1; ?>" 
                            style="width: 12px; height: 12px; border-radius: 50%; background-color: <?php echo $index === 0 ? '#FFFFFF' : 'rgba(255, 255, 255, 0.5)'; ?>; border: 2px solid #FFFFFF; margin: 0 5px;"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Contenido del Hero -->
    <div class="container" style="position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 style="font-size: 3.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8); color: white; margin-bottom: 1rem;">Bienvenidos a la Filá Mariscales</h1>
                <p style="font-size: 1.5rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.8); color: white; margin-bottom: 2rem;">Caballeros Templarios de Elche</p>
                <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <a href="/prueba-php/public/historia" style="background: linear-gradient(135deg, #FFFFFF 0%, #f0f0f0 100%); color: #8B0000; border: 2px solid #FFFFFF; padding: 12px 30px; border-radius: 25px; font-weight: bold; text-decoration: none; display: inline-block;">
                        <i class="bi bi-shield-fill me-2"></i>Conócenos
                    </a>
                    <a href="/prueba-php/public/calendario" style="background: linear-gradient(135deg, #FFFFFF 0%, #f0f0f0 100%); color: #8B0000; border: 2px solid #FFFFFF; padding: 12px 30px; border-radius: 25px; font-weight: bold; text-decoration: none; display: inline-block;">
                        <i class="bi bi-calendar-event me-2"></i>Próximos Eventos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-7">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-gradient mb-4">Sobre la Filá Mariscales</h2>
                <p class="lead mb-4">Somos una de las filaes más tradicionales y respetadas de las Fiestas de Moros y Cristianos de Elche, fundada en 1985.</p>
                <p class="mb-4">Nuestra filá representa a los Caballeros Templarios, una de las órdenes militares más importantes de la Edad Media. Con más de 35 años de historia, hemos mantenido viva la tradición y el espíritu de las fiestas.</p>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <h3 class="text-gradient mb-0">150+</h3>
                        <p class="small text-muted">Miembros</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient mb-0">35</h3>
                        <p class="small text-muted">Años de Historia</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient mb-0">25+</h3>
                        <p class="small text-muted">Eventos Anuales</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/600x400/8B4513/FFFFFF?text=Filá+Mariscales" alt="Filá Mariscales" class="img-fluid rounded-3 shadow-lg">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-dark rounded-3" style="opacity: 0.3;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
<section class="py-7 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="text-gradient mb-5">Próximos Eventos</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($upcoming_events as $event): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card hover-lift h-100">
                    <img src="<?php echo $event['image']; ?>" class="card-img-top" alt="<?php echo $event['title']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $event['title']; ?></h5>
                        <p class="card-text"><?php echo $event['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i><?php echo $event['date']; ?>
                            </small>
                            <span class="badge bg-<?php echo $event['status'] === 'Confirmado' ? 'success' : 'warning'; ?>"><?php echo $event['status']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="text-gradient mb-5">Galería de Fotos</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($gallery as $item): ?>
            <div class="col-lg-4 col-md-6">
                <div class="gallery-item position-relative hover-scale">
                    <div class="gallery-image-container">
                        <img src="<?php echo $item['thumb']; ?>" class="gallery-image" alt="<?php echo $item['alt']; ?>">
                    </div>
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-0 transition-all rounded-3 d-flex align-items-center justify-content-center">
                        <div class="text-white text-center">
                            <h5><?php echo $item['caption']; ?></h5>
                            <a href="<?php echo $item['full']; ?>" class="btn btn-light btn-sm" target="_blank">
                                <i class="bi bi-zoom-in me-1"></i>Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
ob_end_flush(); // End output buffering
?>

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

/* Estilos para el carrusel uniforme */
.carousel-image-container {
    width: 100%;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: absolute;
    top: 0;
    left: 0;
    transition: all 0.5s ease;
}

.carousel-item {
    height: 100vh;
    position: relative;
}

.carousel-item.active .carousel-image-container {
    transform: scale(1);
}

.carousel-item:not(.active) .carousel-image-container {
    transform: scale(1.05);
}

/* Responsive para el carrusel */
@media (max-width: 768px) {
    .carousel-image-container {
        height: 100vh;
    }
    
    .carousel-caption h2 {
        font-size: 2rem !important;
    }
    
    .carousel-caption p {
        font-size: 1.2rem !important;
    }
}

@media (max-width: 576px) {
    .carousel-caption h2 {
        font-size: 1.5rem !important;
    }
    
    .carousel-caption p {
        font-size: 1rem !important;
    }
}
</style>
