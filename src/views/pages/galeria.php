<?php
// Cargar imágenes de la galería dinámicamente
$galeria_items = [];

if (!empty($gallery_images)) {
    foreach ($gallery_images as $index => $image) {
        $galeria_items[] = [
            'titulo' => $image['caption'] ?? 'Imagen de la Filá Mariscales',
            'descripcion' => 'Imagen de la galería de la Filá Mariscales de Caballeros Templarios',
            'imagen' => $image['full'],
            'categoria' => 'galeria',
            'fecha' => date('d/m/Y'),
            'tipo' => 'foto'
        ];
    }
} else {
    // Datos de la galería por defecto si no hay imágenes subidas
    $galeria_items = [
        [
            'titulo' => 'Desfile Principal 2023',
            'descripcion' => 'La Filá Mariscales en su máximo esplendor durante el desfile principal de las Fiestas de Moros y Cristianos',
            'imagen' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'categoria' => 'desfiles',
            'fecha' => '15/04/2023',
            'tipo' => 'foto'
        ],
        [
            'titulo' => 'Entrada de Bandas',
            'descripcion' => 'Nuestras bandas de música en la tradicional entrada de bandas',
            'imagen' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'categoria' => 'bandas',
            'fecha' => '22/04/2023',
            'tipo' => 'foto'
        ],
        [
            'titulo' => 'Cena Anual de Hermandad',
            'descripcion' => 'Momentos de camaradería en nuestra cena anual de hermandad',
            'imagen' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'categoria' => 'eventos',
            'fecha' => '10/03/2023',
            'tipo' => 'foto'
        ]
    ];
}

$categorias = [
    'todos' => 'Todos',
    'galeria' => 'Galería',
    'desfiles' => 'Desfiles',
    'bandas' => 'Bandas',
    'eventos' => 'Eventos',
    'procesiones' => 'Procesiones'
];
?>

<!-- Hero Section -->
<section class="hero-section py-5 particles" style="background: linear-gradient(135deg, rgba(220, 20, 60, 0.05) 0%, rgba(255, 255, 255, 0.05) 50%, rgba(220, 20, 60, 0.05) 100%); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
<div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center scroll-reveal">
                <h1 class="display-4 fw-bold text-gradient mb-4 animate-fadeInDown">
                    <i class="bi bi-images me-3 animate-float"></i>
                    <span class="text-shimmer">Galería Multimedia</span>
                </h1>
                <p class="lead mb-5 animate-fadeInUp">Revive los mejores momentos de la Filá Mariscales de Caballeros Templarios</p>
                <div class="gallery-stats d-flex justify-content-center gap-4 mb-5 stagger-animation">
                    <div class="stat-item card-animated animate-fadeInLeft">
                        <h3 class="text-gradient mb-0 counter" data-target="<?php echo count($galeria_items); ?>">0</h3>
                        <small class="text-muted">Imágenes</small>
                    </div>
                    <div class="stat-item card-animated animate-fadeInUp">
                        <h3 class="text-gradient mb-0 counter" data-target="<?php echo count($categorias) - 1; ?>">0</h3>
                        <small class="text-muted">Categorías</small>
                    </div>
                    <div class="stat-item card-animated animate-fadeInRight">
                        <h3 class="text-gradient mb-0">2025</h3>
                        <small class="text-muted">Año Actual</small>
                    </div>
                </div>
            </div>
        </div>
                        </div>
</section>

<!-- Gallery Filters -->
<section class="gallery-filters py-4 scroll-reveal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="filter-buttons d-flex flex-wrap gap-2 justify-content-center">
                    <?php foreach ($categorias as $key => $categoria): ?>
                    <button class="filter-btn btn-animated hover-glow <?php echo $key === 'todos' ? 'active' : ''; ?>" 
                            data-filter="<?php echo $key; ?>">
                        <i class="bi bi-<?php echo $key === 'todos' ? 'grid-fill' : ($key === 'desfiles' ? 'flag-fill' : ($key === 'bandas' ? 'music-note-beamed' : ($key === 'eventos' ? 'calendar-event' : 'cross'))) ?> me-2"></i>
                        <?php echo $categoria; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery-content py-5">
    <div class="container">
        <div class="row g-4 stagger-animation" id="galleryGrid">
            <?php foreach ($galeria_items as $index => $item): ?>
            <div class="col-md-6 col-lg-4 gallery-item scroll-reveal" data-category="<?php echo $item['categoria']; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                <div class="gallery-card card-animated hover-lift">
                    <div class="gallery-image img-zoom">
                        <img src="<?php echo $item['imagen']; ?>" 
                             alt="<?php echo $item['titulo']; ?>" 
                             class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <h5 class="animate-fadeInUp"><?php echo $item['titulo']; ?></h5>
                                <p class="animate-fadeInUp"><?php echo $item['descripcion']; ?></p>
                                <div class="overlay-actions animate-fadeInUp">
                                    <button class="btn btn-light btn-sm btn-animated" onclick="openLightbox('<?php echo $item['imagen']; ?>', '<?php echo $item['titulo']; ?>', '<?php echo $item['descripcion']; ?>')">
                                        <i class="bi bi-zoom-in me-1"></i>Ampliar
                                    </button>
                                    <span class="badge bg-danger ms-2 animate-pulse">
                                        <i class="bi bi-image me-1"></i><?php echo ucfirst($item['tipo']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-info">
                        <h6 class="gallery-title"><?php echo $item['titulo']; ?></h6>
                        <div class="gallery-meta">
                            <span class="category-badge"><?php echo ucfirst($item['categoria']); ?></span>
                            <span class="date-badge"><?php echo $item['fecha']; ?></span>
                </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lightboxTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="lightboxImage" src="" alt="" class="img-fluid">
                <p id="lightboxDescription" class="mt-3 text-muted"></p>
            </div>
        </div>
    </div>
</div>

<style>
/* Gallery Styles */
.hero-section {
    background: linear-gradient(135deg, rgba(220, 20, 60, 0.05) 0%, rgba(255, 255, 255, 0.05) 50%, rgba(220, 20, 60, 0.05) 100%);
    backdrop-filter: blur(4px);
}

.gallery-stats .stat-item {
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    border: 2px solid var(--primary);
    min-width: 120px;
    backdrop-filter: blur(10px);
}

.gallery-filters {
    background: linear-gradient(135deg, rgba(220, 20, 60, 0.8) 0%, rgba(139, 0, 0, 0.8) 100%);
    backdrop-filter: blur(10px);
}

.filter-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 20, 60, 0.3);
}

.gallery-content {
    background: rgba(248, 249, 250, 0.8);
    backdrop-filter: blur(10px);
}

.gallery-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 2px solid transparent;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(220, 20, 60, 0.2);
    border-color: var(--primary);
}

.gallery-image {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16/9;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(220, 20, 60, 0.9) 0%, rgba(139, 0, 0, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(5px);
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    padding: 1rem;
}

.overlay-content h5 {
    font-family: 'Cinzel', serif;
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
}

.overlay-content p {
    font-size: 0.9rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.overlay-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.gallery-info {
    padding: 1.5rem;
}

.gallery-title {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.gallery-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category-badge {
    background: var(--primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.date-badge {
    color: #6c757d;
    font-size: 0.8rem;
}

/* Animation for filtering */
.gallery-item {
    transition: all 0.3s ease;
}

.gallery-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

/* Modal styles */
.modal-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 2px solid var(--primary);
}

.modal-header {
    border-bottom: 2px solid var(--primary);
}

.modal-title {
    font-family: 'Cinzel', serif;
    color: var(--primary);
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .filter-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .filter-btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            
            // Update active button
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Filter items
            galleryItems.forEach(item => {
                const category = item.dataset.category;
                
                if (filter === 'todos' || category === filter) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
            });
        });
        
// Lightbox functionality
function openLightbox(imageSrc, title, description) {
    const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
    document.getElementById('lightboxImage').src = imageSrc;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDescription').textContent = description;
    modal.show();
}

// Add smooth animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.gallery-item').forEach(item => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(20px)';
    item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(item);
});
</script>
