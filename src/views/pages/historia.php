<?php
/**
 * Página de Historia - Filá Mariscales
 * Historia y tradiciones de la Filá Mariscales de Caballeros Templarios
 */
?>

<style>
    /* Estilos translúcidos para historia con blur de 3 */
    body {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%), 
                    url('/prueba-php/public/assets/images/backgrounds/knight-templar-background.jpg') center/cover fixed;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(3px);
        z-index: -1;
    }
    
    .navbar {
        background: rgba(52, 58, 64, 0.9) !important;
        backdrop-filter: blur(3px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        width: 100% !important;
    }
    
    .card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(3px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        z-index: 2;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn {
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.9), rgba(0, 86, 179, 0.9));
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.9), rgba(200, 35, 51, 0.9));
        border: none;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: rgba(0, 123, 255, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .alert {
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(3px);
    }
    
    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        border-color: rgba(40, 167, 69, 0.3);
    }
    
    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border-color: rgba(220, 53, 69, 0.3);
    }
    
    .alert-info {
        background: rgba(23, 162, 184, 0.1);
        border-color: rgba(23, 162, 184, 0.3);
    }
    
    .alert-warning {
        background: rgba(255, 193, 7, 0.1);
        border-color: rgba(255, 193, 7, 0.3);
    }
    
    /* Cabeceras translúcidas */
    .card-header {
        background: rgba(220, 53, 69, 0.9) !important;
        backdrop-filter: blur(3px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px 12px 0 0 !important;
    }
    
    .bg-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.9), rgba(200, 35, 51, 0.9)) !important;
        backdrop-filter: blur(3px);
    }
    
    .bg-primary {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.9), rgba(0, 86, 179, 0.9)) !important;
        backdrop-filter: blur(3px);
    }
    
    .bg-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.9), rgba(30, 126, 52, 0.9)) !important;
        backdrop-filter: blur(3px);
    }
    
    .bg-info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.9), rgba(17, 122, 139, 0.9)) !important;
        backdrop-filter: blur(3px);
    }
    
    .bg-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.9), rgba(255, 152, 0, 0.9)) !important;
        backdrop-filter: blur(3px);
    }
    
    /* Fondos de imagen translúcidos con blur de 3 */
    .hero-section, .hero, .carousel-item, .carousel-image-container {
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .hero-section::before, .hero::before, .carousel-item::before, .carousel-image-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(3px);
        z-index: 1;
    }
    
    .hero-section > *, .hero > *, .carousel-item > *, .carousel-image-container > * {
        position: relative;
        z-index: 2;
    }
    
    /* Secciones con fondo de imagen */
    section[style*="background"], div[style*="background"], .bg-image {
        position: relative;
    }
    
    section[style*="background"]::before, div[style*="background"]::before, .bg-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(3px);
        z-index: 1;
    }
    
    section[style*="background"] > *, div[style*="background"] > *, .bg-image > * {
        position: relative;
        z-index: 2;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card {
            margin: 10px;
            border-radius: 10px;
        }
        
        .btn {
            padding: 10px 20px;
        }
        
        .hero-section, .hero, .carousel-item, .carousel-image-container {
            background-attachment: scroll;
        }
    }
</style>

<div class="container-fluid py-5" style="position: relative; z-index: 1; padding-top: 100px !important;">
    <!-- Header de la página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 medieval-text text-danger mb-3">
                <i class="bi bi-clock-history me-3"></i>Historia de la Filá Mariscales
            </h1>
            <p class="lead text-muted">Descubre la rica tradición y el legado de los Caballeros Templarios de Elche</p>
            <hr class="my-4" style="border-color: var(--gold);">
        </div>
    </div>

    <!-- Sección de Orígenes -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-lg-6">
            <div class="card medieval-border h-100">
                <div class="card-body">
                    <h2 class="card-title text-danger medieval-text">
                        <i class="bi bi-castle me-2"></i>Nuestros Orígenes
                    </h2>
                    <p class="card-text">
                        La Filá Mariscales nació en el corazón de Elche, inspirada en la noble tradición de los Caballeros Templarios. 
                        Fundada con el propósito de preservar y honrar las tradiciones medievales, nuestra filá se ha convertido en 
                        un símbolo de hermandad y honor en las Fiestas de Moros y Cristianos.
                    </p>
                    <p class="card-text">
                        Desde nuestros inicios, hemos mantenido vivo el espíritu de los antiguos caballeros, combinando la elegancia 
                        medieval con la pasión por nuestras raíces culturales. Cada miembro de nuestra filá porta con orgullo el 
                        legado de aquellos valientes guerreros que defendieron la fe y la justicia.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card medieval-border h-100">
                <img src="https://via.placeholder.com/600x400/8B4513/FFFFFF?text=Orígenes+Mariscales" 
                     class="card-img-top" alt="Orígenes de la Filá Mariscales">
                <div class="card-body">
                    <h3 class="card-title text-danger">Fundación</h3>
                    <p class="card-text">
                        Fundada en el año 1985, la Filá Mariscales ha sido testigo de la evolución de las Fiestas de Moros y Cristianos 
                        de Elche, participando activamente en cada celebración y contribuyendo al engrandecimiento de nuestra tradición local.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Tradiciones -->
    <div class="row mb-5" data-aos="fade-up" data-aos-delay="200">
        <div class="col-12">
            <h2 class="text-center text-danger medieval-text mb-4">
                <i class="bi bi-shield-fill me-2"></i>Nuestras Tradiciones
            </h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card medieval-border h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-music-note-beamed display-4 text-danger mb-3"></i>
                    <h4 class="card-title text-danger">Himno de la Filá</h4>
                    <p class="card-text">
                        Nuestro himno, compuesto especialmente para la filá, evoca la grandeza de los templarios y la nobleza 
                        de nuestros antepasados. Cada nota transporta a nuestros miembros a épocas de honor y valentía.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card medieval-border h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-award display-4 text-danger mb-3"></i>
                    <h4 class="card-title text-danger">Insignias y Condecoraciones</h4>
                    <p class="card-text">
                        Nuestras insignias representan la jerarquía y los logros de cada miembro. Cada condecoración cuenta 
                        una historia de dedicación y servicio a la filá y a la tradición.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card medieval-border h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-calendar-event display-4 text-danger mb-3"></i>
                    <h4 class="card-title text-danger">Rituales y Ceremonias</h4>
                    <p class="card-text">
                        Mantenemos vivas las ceremonias tradicionales que honran a nuestros fundadores y celebran la hermandad 
                        que une a todos los miembros de la filá.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Logros -->
    <div class="row mb-5" data-aos="fade-up" data-aos-delay="400">
        <div class="col-12">
            <h2 class="text-center text-danger medieval-text mb-4">
                <i class="bi bi-trophy me-2"></i>Logros y Reconocimientos
            </h2>
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker bg-danger"></div>
                    <div class="timeline-content">
                        <h5 class="text-danger">1985 - Fundación</h5>
                        <p>Nacimiento oficial de la Filá Mariscales con 25 miembros fundadores.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-success"></div>
                    <div class="timeline-content">
                        <h5 class="text-success">1990 - Primer Premio</h5>
                        <p>Primer premio en el concurso de filás durante las Fiestas de Moros y Cristianos.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <h5 class="text-warning">1995 - Hermanamiento</h5>
                        <p>Primer hermanamiento con otra filá templaria de la región.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-info"></div>
                    <div class="timeline-content">
                        <h5 class="text-info">2000 - Sede Social</h5>
                        <p>Inauguración de nuestra sede social actual.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-danger"></div>
                    <div class="timeline-content">
                        <h5 class="text-danger">2010 - 25 Aniversario</h5>
                        <p>Celebración del 25º aniversario con eventos especiales y reconocimientos.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker bg-danger"></div>
                    <div class="timeline-content">
                        <h5 class="text-danger">2020 - Expansión</h5>
                        <p>Alcanzamos los 150 miembros activos y múltiples reconocimientos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Miembros Destacados -->
    <div class="row mb-5" data-aos="fade-up" data-aos-delay="600">
        <div class="col-12">
            <h2 class="text-center text-danger medieval-text mb-4">
                <i class="bi bi-people-fill me-2"></i>Miembros Destacados
            </h2>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card medieval-border text-center">
                <div class="card-body">
                    <img src="https://via.placeholder.com/150x150/8B4513/FFFFFF?text=Fundador" 
                         class="rounded-circle mb-3" alt="Fundador">
                    <h5 class="card-title text-danger">Don Carlos Mariscal</h5>
                    <p class="card-text text-muted">Fundador y Primer Capitán</p>
                    <p class="card-text small">
                        Visionario que estableció los cimientos de nuestra filá y definió los valores que nos guían hasta hoy.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card medieval-border text-center">
                <div class="card-body">
                    <img src="https://via.placeholder.com/150x150/8B4513/FFFFFF?text=Capitán" 
                         class="rounded-circle mb-3" alt="Capitán Actual">
                    <h5 class="card-title text-danger">Don Antonio García</h5>
                    <p class="card-text text-muted">Capitán Actual</p>
                    <p class="card-text small">
                        Líder que mantiene vivo el espíritu templario y guía a la filá hacia nuevos logros.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card medieval-border text-center">
                <div class="card-body">
                    <img src="https://via.placeholder.com/150x150/8B4513/FFFFFF?text=Maestro" 
                         class="rounded-circle mb-3" alt="Maestro de Armas">
                    <h5 class="card-title text-danger">Don Miguel Rodríguez</h5>
                    <p class="card-text text-muted">Maestro de Armas</p>
                    <p class="card-text small">
                        Experto en las artes marciales medievales y responsable de la formación de nuevos caballeros.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card medieval-border text-center">
                <div class="card-body">
                    <img src="https://via.placeholder.com/150x150/8B4513/FFFFFF?text=Heraldo" 
                         class="rounded-circle mb-3" alt="Heraldo">
                    <h5 class="card-title text-danger">Don Francisco López</h5>
                    <p class="card-text text-muted">Heraldo de la Filá</p>
                    <p class="card-text small">
                        Guardián de nuestras tradiciones y responsable de comunicar nuestros logros y eventos.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Valores -->
    <div class="row mb-5" data-aos="fade-up" data-aos-delay="800">
        <div class="col-12">
            <h2 class="text-center text-danger medieval-text mb-4">
                <i class="bi bi-heart-fill me-2"></i>Nuestros Valores
            </h2>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card medieval-border h-100">
                <div class="card-body">
                    <h4 class="card-title text-danger">
                        <i class="bi bi-shield-check me-2"></i>Honor
                    </h4>
                    <p class="card-text">
                        El honor es el pilar fundamental de nuestra filá. Cada miembro se compromete a actuar con integridad, 
                        respeto y nobleza en todas sus acciones, tanto dentro como fuera de la filá.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card medieval-border h-100">
                <div class="card-body">
                    <h4 class="card-title text-danger">
                        <i class="bi bi-people-fill me-2"></i>Hermandad
                    </h4>
                    <p class="card-text">
                        La hermandad une a todos los miembros de la filá. Nos apoyamos mutuamente, compartimos experiencias 
                        y creamos lazos que duran toda la vida.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card medieval-border h-100">
                <div class="card-body">
                    <h4 class="card-title text-danger">
                        <i class="bi bi-book me-2"></i>Tradición
                    </h4>
                    <p class="card-text">
                        Preservamos y honramos las tradiciones que nos han sido legadas. Cada ritual, cada ceremonia 
                        y cada costumbre tiene un significado profundo que transmitimos a las nuevas generaciones.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card medieval-border h-100">
                <div class="card-body">
                    <h4 class="card-title text-danger">
                        <i class="bi bi-star-fill me-2"></i>Excelencia
                    </h4>
                    <p class="card-text">
                        Buscamos la excelencia en todo lo que hacemos. Desde la preparación de nuestros desfiles hasta 
                        la organización de nuestros eventos, nos esforzamos por alcanzar la perfección.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row" data-aos="fade-up" data-aos-delay="1000">
        <div class="col-12 text-center">
            <div class="card medieval-border bg-danger text-white">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="bi bi-shield-fill me-2"></i>¿Quieres Ser Parte de Nuestra Historia?
                    </h3>
                    <p class="card-text">
                        Únete a la Filá Mariscales y forma parte de una tradición centenaria. 
                        Descubre el honor, la hermandad y la nobleza de los Caballeros Templarios.
                    </p>
                    <a href="/prueba-php/public/registro" class="btn btn-warning btn-lg me-3">
                        <i class="bi bi-person-plus me-2"></i>Únete a la Filá
                    </a>
                    <a href="/prueba-php/public/contacto" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para la página de historia */
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--gold) 100%);
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: 50%;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    transform: translateX(-50%);
    border: 3px solid white;
    box-shadow: 0 0 0 3px var(--primary);
}

.timeline-content {
    position: relative;
    width: 45%;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: 2px solid var(--primary);
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-left: 0;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: 55%;
}

.timeline-content::before {
    content: '';
    position: absolute;
    top: 20px;
    width: 0;
    height: 0;
    border: 10px solid transparent;
}

.timeline-item:nth-child(odd) .timeline-content::before {
    right: -20px;
    border-left-color: white;
}

.timeline-item:nth-child(even) .timeline-content::before {
    left: -20px;
    border-right-color: white;
}

@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }
    
    .timeline-marker {
        left: 20px;
    }
    
    .timeline-content {
        width: calc(100% - 60px);
        margin-left: 60px !important;
    }
    
    .timeline-content::before {
        left: -20px !important;
        border-right-color: white !important;
        border-left-color: transparent !important;
    }
}
</style> 