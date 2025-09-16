// Procesar eventos dinámicos
$eventosPorMes = [];
$eventosProximos = [];

if (!empty($events)) {
    foreach ($events as $evento) {
        $fecha = new DateTime($evento->fecha);
        $mes = $fecha->format('n'); // Mes como número (1-12)
        $año = $fecha->format('Y');
        
        // Solo mostrar eventos del año actual o futuro
        if ($año >= date('Y')) {
            if (!isset($eventosPorMes[$mes])) {
                $eventosPorMes[$mes] = [];
            }
            $eventosPorMes[$mes][] = $evento;
            
            // Para eventos próximos, solo los que están en el futuro
            if ($fecha >= new DateTime()) {
                $eventosProximos[] = $evento;
            }
        }
    }
    
    // Ordenar eventos próximos por fecha
    usort($eventosProximos, function($a, $b) {
        return strtotime($a->fecha) - strtotime($b->fecha);
    });
    
    // Limitar a 5 eventos próximos
    $eventosProximos = array_slice($eventosProximos, 0, 5);
}

// Si no hay eventos, usar eventos por defecto
if (empty($eventosProximos)) {
    $eventosProximos = [
        (object)[
            'fecha' => '2025-01-15',
            'hora' => '19:00',
            'titulo' => 'Reunión de la Junta Directiva'
        ],
        (object)[
            'fecha' => '2025-01-20',
            'hora' => '18:30',
            'titulo' => 'Conferencia: Historia de los Moros y Cristianos'
        ],
        (object)[
            'fecha' => '2025-02-05',
            'hora' => '10:00',
            'titulo' => 'Torneo de Fútbol 7'
        ],
        (object)[
            'fecha' => '2025-03-15',
            'hora' => '00:00',
            'titulo' => 'Fiestas de Moros y Cristianos'
        ]
    ];
}
?>

<!-- Hero Section -->
<section class="hero-section text-white text-center py-8 mb-8" style="background: linear-gradient(rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.05)), url('/mariscales1-php/public/assets/images/backgrounds/knight-templar-background.jpg') center/cover; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Calendario Anual</h1>
        <p class="lead">Eventos y actividades programadas de la Filá Mariscales</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Year Navigation -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0"><?php echo date('Y'); ?></h2>
                    <div class="btn-group" role="group" aria-label="Navegación de meses">
                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-chevron-left"></i> <?php echo date('Y') - 1; ?></button>
                        <button type="button" class="btn btn-primary active"><?php echo date('Y'); ?></button>
                        <button type="button" class="btn btn-outline-primary"><?php echo date('Y') + 1; ?> <i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                
                <!-- Month Navigation -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php 
                    $months = [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ];
                    
                    foreach($months as $index => $month): 
                        $isCurrent = ($index + 1) === (int)date('n');
                        $hasEvents = isset($eventosPorMes[$index + 1]) && !empty($eventosPorMes[$index + 1]);
                    ?>
                        <a href="#month-<?php echo $index + 1; ?>" 
                           class="btn btn-sm <?php echo $isCurrent ? 'btn-primary' : ($hasEvents ? 'btn-success' : 'btn-outline-primary'); ?>">
                            <?php echo $month; ?>
                            <?php if ($hasEvents): ?>
                                <span class="badge bg-light text-dark ms-1"><?php echo count($eventosPorMes[$index + 1]); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Event Filters -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <span class="fw-bold">Filtrar por categoría:</span>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="filter-fiestas" checked>
                        <label class="form-check-label" for="filter-fiestas">Fiestas</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="filter-cultural" checked>
                        <label class="form-check-label" for="filter-cultural">Cultural</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="filter-deportivo" checked>
                        <label class="form-check-label" for="filter-deportivo">Deportivo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="filter-reuniones" checked>
                        <label class="form-check-label" for="filter-reuniones">Reuniones</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="filter-otros" checked>
                        <label class="form-check-label" for="filter-otros">Otros</label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Calendar Content -->
        <div class="row">
            <div class="col-lg-8">
                <?php foreach($months as $index => $month): ?>
                    <div class="card mb-5" id="month-<?php echo $index + 1; ?>">
                        <div class="card-header bg-light">
                            <h3 class="h5 mb-0"><?php echo $month; ?> <?php echo date('Y'); ?></h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php if (isset($eventosPorMes[$index + 1]) && !empty($eventosPorMes[$index + 1])): ?>
                                    <?php foreach($eventosPorMes[$index + 1] as $evento): ?>
                                        <div class="list-group-item p-3 event-item" data-category="otros">
                                            <div class="d-flex align-items-start">
                                                <div class="date-box bg-danger text-white text-center me-3 rounded" style="min-width: 70px;">
                                                    <div class="fw-bold fs-5"><?php echo date('j', strtotime($evento->fecha)); ?></div>
                                                    <div class="text-uppercase"><?php echo strtoupper(date('M', strtotime($evento->fecha))); ?></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <h5 class="mb-1"><?php echo htmlspecialchars($evento->titulo); ?></h5>
                                                        <span class="badge bg-<?php echo $evento->es_publico ? 'success' : 'warning'; ?>">
                                                            <?php echo $evento->es_publico ? 'Público' : 'Privado'; ?>
                                                        </span>
                                                    </div>
                                                    <p class="mb-1 text-muted">
                                                        <i class="bi bi-clock me-1"></i> 
                                                        <?php echo date('H:i', strtotime($evento->hora)); ?>
                                                        <?php if (!empty($evento->lugar)): ?>
                                                            - <i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($evento->lugar); ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <?php if (!empty($evento->descripcion)): ?>
                                                        <p class="mb-0"><?php echo htmlspecialchars($evento->descripcion); ?></p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($evento->imagen_url)): ?>
                                                        <div class="mt-2">
                                                            <img src="/<?php echo $evento->imagen_url; ?>" 
                                                                 alt="<?php echo htmlspecialchars($evento->titulo); ?>" 
                                                                 class="img-fluid rounded" style="max-height: 150px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="list-group-item p-4 text-center text-muted">
                                        <i class="bi bi-calendar-x fs-1 mb-3"></i>
                                        <p class="mb-0">No hay eventos programados para <?php echo $month; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- More months would follow the same pattern -->
                <div class="text-center my-4">
                    <button class="btn btn-outline-primary">Cargar más meses</button>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Upcoming Events -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h3 class="h5 mb-0">Próximos Eventos</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($eventosProximos)): ?>
                            <?php foreach($eventosProximos as $evento): ?>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="d-flex">
                                            <div class="date-box bg-light text-center me-3 rounded" style="min-width: 50px;">
                                                <div class="fw-bold"><?php echo date('j', strtotime($evento->fecha)); ?></div>
                                                <div class="small"><?php echo strtoupper(date('M', strtotime($evento->fecha))); ?></div>
                                            </div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($evento->titulo); ?></h6>
                                        </div>
                                        <small class="text-muted"><?php echo date('H:i', strtotime($evento->hora)); ?></small>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-center text-muted">
                                <p class="mb-0">No hay eventos próximos</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-sm btn-outline-primary">Ver todos los eventos</a>
                    </div>
                </div>
                
                <!-- Subscribe -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check display-4 text-danger mb-3"></i>
                        <h4>¡No te pierdas nada!</h4>
                        <p class="text-muted">Recibe recordatorios de nuestros eventos directamente en tu correo electrónico.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Suscribirme</button>
                        </form>
                    </div>
                </div>
                
                <!-- Categories -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="h5 mb-0">Categorías</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Fiestas
                            <span class="badge bg-danger rounded-pill">12</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Cultural
                            <span class="badge bg-danger rounded-pill">8</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Deportivo
                            <span class="badge bg-danger rounded-pill">6</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Reuniones
                            <span class="badge bg-danger rounded-pill">24</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Otros
                            <span class="badge bg-danger rounded-pill"><?php echo count($events); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add to Calendar Modal -->
<div class="modal fade" id="addToCalendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir a mi calendario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Selecciona tu calendario preferido:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary"><i class="bi bi-google me-2"></i>Google Calendar</button>
                    <button class="btn btn-outline-primary"><i class="bi bi-apple me-2"></i>Apple Calendar</button>
                    <button class="btn btn-outline-primary"><i class="bi bi-microsoft me-2"></i>Outlook</button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-download me-2"></i>Descargar .ics</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple filter functionality
const filters = document.querySelectorAll('input[type="checkbox"]');
const events = document.querySelectorAll('.event-item');

filters.forEach(filter => {
    filter.addEventListener('change', () => {
        const activeCategories = Array.from(filters)
            .filter(f => f.checked)
            .map(f => f.id.replace('filter-', ''));
        
        events.forEach(event => {
            const eventCategory = event.dataset.category;
            if (activeCategories.length === 0 || activeCategories.includes(eventCategory)) {
                event.style.display = '';
            } else {
                event.style.display = 'none';
            }
        });
    });
});
</script>
