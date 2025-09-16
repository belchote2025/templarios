<?php
// Página interactiva con elementos dinámicos
?>

<!-- Hero Section Interactivo -->
<section class="hero-interactive py-5 particles">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center scroll-reveal">
                <h1 class="display-3 fw-bold text-gradient mb-4 animate-fadeInDown">
                    <i class="bi bi-magic me-3 animate-float"></i>
                    <span class="text-shimmer">Zona Interactiva</span>
                </h1>
                <p class="lead mb-5 animate-fadeInUp">
                    Descubre la tradición templaria de forma interactiva
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Contadores Animados -->
<section class="counters-section py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="counter-card card-animated hover-lift">
                    <div class="counter-icon animate-bounce">
                        <i class="bi bi-calendar-event fs-1 text-danger"></i>
                    </div>
                    <h3 class="counter text-gradient" data-target="50">0</h3>
                    <p class="text-muted">Años de Tradición</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="counter-card card-animated hover-lift">
                    <div class="counter-icon animate-bounce">
                        <i class="bi bi-people-fill fs-1 text-success"></i>
                    </div>
                    <h3 class="counter text-gradient" data-target="150">0</h3>
                    <p class="text-muted">Miembros Activos</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="counter-card card-animated hover-lift">
                    <div class="counter-icon animate-bounce">
                        <i class="bi bi-trophy-fill fs-1 text-warning"></i>
                    </div>
                    <h3 class="counter text-gradient" data-target="25">0</h3>
                    <p class="text-muted">Premios Obtenidos</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="counter-card card-animated hover-lift">
                    <div class="counter-icon animate-bounce">
                        <i class="bi bi-heart-fill fs-1 text-danger"></i>
                    </div>
                    <h3 class="counter text-gradient" data-target="1000">0</h3>
                    <p class="text-muted">Seguidores</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Tarjetas Interactivas -->
<section class="interactive-cards py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 scroll-reveal">
                <h2 class="display-5 fw-bold text-gradient animate-fadeInUp">
                    <i class="bi bi-stars me-3 animate-glow"></i>
                    Explora Nuestra Historia
                </h2>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="interactive-card card-tilt hover-lift scroll-reveal">
                    <div class="card-header bg-danger text-white">
                        <i class="bi bi-shield-fill fs-1 animate-float"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Orígenes Templarios</h5>
                        <p class="card-text">Descubre cómo comenzó nuestra tradición en 1975 y los valores que nos guían.</p>
                        <button class="btn btn-danger btn-animated" onclick="showModal('templarios')">
                            <i class="bi bi-eye me-2"></i>Explorar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="interactive-card card-tilt hover-lift scroll-reveal">
                    <div class="card-header bg-danger text-white">
                        <i class="bi bi-music-note-beamed fs-1 animate-float"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Bandas de Música</h5>
                        <p class="card-text">Conoce nuestras bandas y la música que nos acompaña en cada desfile.</p>
                        <button class="btn btn-danger btn-animated" onclick="showModal('bandas')">
                            <i class="bi bi-play-circle me-2"></i>Escuchar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="interactive-card card-tilt hover-lift scroll-reveal">
                    <div class="card-header bg-danger text-white">
                        <i class="bi bi-calendar-event fs-1 animate-float"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Eventos Anuales</h5>
                        <p class="card-text">Participa en nuestros eventos y actividades durante todo el año.</p>
                        <button class="btn btn-danger btn-animated" onclick="showModal('eventos')">
                            <i class="bi bi-calendar-check me-2"></i>Ver Eventos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Timeline Interactivo -->
<section class="timeline-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 scroll-reveal">
                <h2 class="display-5 fw-bold text-gradient animate-fadeInUp">
                    <i class="bi bi-clock-history me-3 animate-pulse"></i>
                    Nuestra Historia
                </h2>
            </div>
        </div>
        
        <div class="timeline">
            <div class="timeline-item scroll-reveal">
                <div class="timeline-marker animate-glow"></div>
                <div class="timeline-content card-animated">
                    <h5>1975 - Fundación</h5>
                    <p>Se funda la Filá Mariscales de Caballeros Templarios en Elche.</p>
                </div>
            </div>
            
            <div class="timeline-item scroll-reveal">
                <div class="timeline-marker animate-glow"></div>
                <div class="timeline-content card-animated">
                    <h5>1980 - Primer Desfile</h5>
                    <p>Participamos por primera vez en las Fiestas de Moros y Cristianos.</p>
                </div>
            </div>
            
            <div class="timeline-item scroll-reveal">
                <div class="timeline-marker animate-glow"></div>
                <div class="timeline-content card-animated">
                    <h5>1995 - Expansión</h5>
                    <p>Ampliamos nuestras actividades y creamos nuevas secciones.</p>
                </div>
            </div>
            
            <div class="timeline-item scroll-reveal">
                <div class="timeline-marker animate-glow"></div>
                <div class="timeline-content card-animated">
                    <h5>2020 - Modernización</h5>
                    <p>Incorporamos nuevas tecnologías y mejoramos nuestra presencia digital.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Juegos Interactivos -->
<section class="games-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 scroll-reveal">
                <h2 class="display-5 fw-bold text-gradient animate-fadeInUp">
                    <i class="bi bi-controller me-3 animate-bounce"></i>
                    Zona de Juegos
                </h2>
                <p class="lead">Diviértete con nuestros juegos temáticos sobre la tradición templaria</p>
            </div>
        </div>
        
        <!-- Selector de Juegos -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="game-selector text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-danger active" onclick="showGame('quiz')">
                            <i class="bi bi-question-circle me-2"></i>Quiz
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="showGame('memory')">
                            <i class="bi bi-card-text me-2"></i>Memoria
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="showGame('sequence')">
                            <i class="bi bi-music-note-beamed me-2"></i>Secuencia
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="showGame('puzzle')">
                            <i class="bi bi-puzzle me-2"></i>Puzzle
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="showGame('clicker')">
                            <i class="bi bi-hand-index me-2"></i>Clicker
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Juego de Quiz -->
        <div class="game-container" id="quiz-game">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="quiz-container card-animated scroll-reveal">
                    <div class="quiz-header">
                        <h4>¿Cuánto sabes sobre nosotros?</h4>
                        <div class="progress mb-3">
                            <div class="progress-bar animate-pulse" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="quiz-content">
                        <div class="question" id="question1">
                                <h5>Cargando pregunta...</h5>
                            <div class="answers">
                                    <!-- Las preguntas se cargarán dinámicamente -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="quiz-results" style="display: none;">
                        <h4 class="text-center">¡Resultados!</h4>
                        <div class="score-display">
                            <h2 class="text-gradient counter" data-target="0">0</h2>
                            <p>puntos obtenidos</p>
                        </div>
                        <button class="btn btn-danger btn-animated" onclick="restartQuiz()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Jugar de Nuevo
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Juego de Memoria -->
        <div class="game-container" id="memory-game" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="memory-container card-animated scroll-reveal">
                        <div class="memory-header text-center mb-4">
                            <h4>Juego de Memoria Templaria</h4>
                            <p>Encuentra las parejas de símbolos templarios</p>
                            <div class="memory-stats">
                                <span class="badge bg-danger me-2">Movimientos: <span id="memory-moves">0</span></span>
                                <span class="badge bg-success me-2">Parejas: <span id="memory-pairs">0</span>/8</span>
                                <span class="badge bg-warning">Tiempo: <span id="memory-time">00:00</span></span>
                            </div>
                        </div>
                        <div class="memory-grid" id="memory-grid">
                            <!-- Las cartas se generarán dinámicamente -->
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-danger btn-animated" onclick="startMemoryGame()">
                                <i class="bi bi-play-circle me-2"></i>Iniciar Juego
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Juego de Secuencia Musical -->
        <div class="game-container" id="sequence-game" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="sequence-container card-animated scroll-reveal">
                        <div class="sequence-header text-center mb-4">
                            <h4>Secuencia Musical Templaria</h4>
                            <p>Reproduce la secuencia de notas musicales</p>
                            <div class="sequence-stats">
                                <span class="badge bg-danger me-2">Nivel: <span id="sequence-level">1</span></span>
                                <span class="badge bg-success me-2">Puntuación: <span id="sequence-score">0</span></span>
                            </div>
                        </div>
                        <div class="sequence-buttons">
                            <button class="btn btn-outline-danger sequence-btn" data-note="1">
                                <i class="bi bi-music-note"></i>
                            </button>
                            <button class="btn btn-outline-success sequence-btn" data-note="2">
                                <i class="bi bi-music-note"></i>
                            </button>
                            <button class="btn btn-outline-warning sequence-btn" data-note="3">
                                <i class="bi bi-music-note"></i>
                            </button>
                            <button class="btn btn-outline-danger sequence-btn" data-note="4">
                                <i class="bi bi-music-note"></i>
                            </button>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-danger btn-animated" onclick="startSequenceGame()">
                                <i class="bi bi-play-circle me-2"></i>Iniciar Secuencia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Juego de Puzzle -->
        <div class="game-container" id="puzzle-game" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="puzzle-container card-animated scroll-reveal">
                        <div class="puzzle-header text-center mb-4">
                            <h4>Puzzle del Escudo Templario</h4>
                            <p>Arma el escudo templario moviendo las piezas</p>
                            <div class="puzzle-stats">
                                <span class="badge bg-danger me-2">Movimientos: <span id="puzzle-moves">0</span></span>
                                <span class="badge bg-success me-2">Tiempo: <span id="puzzle-time">00:00</span></span>
                            </div>
                        </div>
                        <div class="puzzle-board" id="puzzle-board">
                            <!-- El puzzle se generará dinámicamente -->
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-danger btn-animated" onclick="startPuzzleGame()">
                                <i class="bi bi-shuffle me-2"></i>Mezclar y Jugar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Juego Clicker -->
        <div class="game-container" id="clicker-game" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="clicker-container card-animated scroll-reveal">
                        <div class="clicker-header text-center mb-4">
                            <h4>Recolector Templario</h4>
                            <p>Haz clic para recolectar elementos templarios</p>
                        </div>
                        <div class="clicker-stats text-center mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h3 class="text-danger" id="clicker-coins">0</h3>
                                        <p>Monedas</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h3 class="text-success" id="clicker-level">1</h3>
                                        <p>Nivel</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h3 class="text-warning" id="clicker-cps">1</h3>
                                        <p>Por segundo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clicker-main text-center">
                            <button class="btn btn-danger btn-lg clicker-btn" onclick="clickCoin()">
                                <i class="bi bi-coin"></i>
                            </button>
                        </div>
                        <div class="clicker-upgrades mt-4">
                            <h5>Mejoras</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-danger upgrade-btn" onclick="buyUpgrade('cps')">
                                        <i class="bi bi-lightning me-2"></i>Velocidad (+1/s) - 10 monedas
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-danger upgrade-btn" onclick="buyUpgrade('multiplier')">
                                        <i class="bi bi-star me-2"></i>Multiplicador x2 - 50 monedas
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modales Interactivos -->
<div class="modal fade" id="interactiveModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para la página interactiva */
.counter-card {
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,249,250,0.8) 100%);
    border: 2px solid #dc143c;
    color: #000000;
    backdrop-filter: blur(10px);
}

.counter-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(220,20,60,0.2);
    background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%);
    color: #ffffff;
}

.interactive-card {
    height: 100%;
    border: 2px solid #dc143c;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
}

.interactive-card .card-header {
    padding: 2rem;
    text-align: center;
    border: none;
    background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%);
    color: #ffffff;
}

.timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #dc143c, #8b0000);
    transform: translateX(-50%);
    box-shadow: 0 0 10px rgba(220,20,60,0.5);
}

.timeline-item {
    position: relative;
    margin-bottom: 3rem;
    width: 50%;
}

.timeline-item:nth-child(odd) {
    left: 0;
    padding-right: 3rem;
}

.timeline-item:nth-child(even) {
    left: 50%;
    padding-left: 3rem;
}

.timeline-marker {
    position: absolute;
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%);
    border-radius: 50%;
    top: 0;
    border: 4px solid #ffffff;
    box-shadow: 0 0 0 4px #dc143c, 0 0 15px rgba(220,20,60,0.6);
}

.timeline-item:nth-child(odd) .timeline-marker {
    right: -10px;
}

.timeline-item:nth-child(even) .timeline-marker {
    left: -10px;
}

.timeline-content {
    padding: 1.5rem;
    border-radius: 10px;
    background: rgba(255,255,255,0.9);
    border: 2px solid #dc143c;
    box-shadow: 0 5px 15px rgba(220,20,60,0.2);
    color: #000000;
    backdrop-filter: blur(10px);
}

.quiz-container {
    padding: 2rem;
    border-radius: 15px;
    background: rgba(255,255,255,0.9);
    border: 2px solid #dc143c;
    box-shadow: 0 10px 30px rgba(220,20,60,0.2);
    backdrop-filter: blur(10px);
}

.answers {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.answer-btn {
    padding: 1rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 2px solid #dc143c;
    background: rgba(255,255,255,0.9);
    color: #000000;
    backdrop-filter: blur(5px);
}

.answer-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220,20,60,0.3);
    background: #dc143c;
    color: #ffffff;
}

.answer-btn.correct {
    background: #dc143c;
    color: #ffffff;
    border-color: #8b0000;
    box-shadow: 0 0 15px rgba(220,20,60,0.5);
}

.answer-btn.incorrect {
    background: #000000;
    color: #ffffff;
    border-color: #000000;
    box-shadow: 0 0 15px rgba(0,0,0,0.5);
}

.score-display {
    text-align: center;
    padding: 2rem;
}

/* Estilos para los juegos */
.game-selector .btn-group {
    flex-wrap: wrap;
    gap: 0.5rem;
}

.game-selector .btn-outline-danger {
    border-color: #dc143c;
    color: #dc143c;
    background: #ffffff;
    transition: all 0.3s ease;
}

.game-selector .btn-outline-danger:hover {
    background: #dc143c;
    color: #ffffff;
    border-color: #8b0000;
    box-shadow: 0 5px 15px rgba(220,20,60,0.3);
}

.game-selector .btn-outline-danger.active {
    background: #dc143c;
    color: #ffffff;
    border-color: #8b0000;
    box-shadow: 0 0 15px rgba(220,20,60,0.5);
}

.game-container {
    min-height: 400px;
}

.memory-container, .sequence-container, .puzzle-container, .clicker-container {
    padding: 2rem;
    border-radius: 15px;
    background: rgba(255,255,255,0.9);
    border: 2px solid #dc143c;
    box-shadow: 0 10px 30px rgba(220,20,60,0.2);
    backdrop-filter: blur(10px);
}

.memory-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    max-width: 400px;
    margin: 0 auto;
}

.memory-card {
    aspect-ratio: 1;
    border-radius: 10px;
    background: rgba(255,255,255,0.9);
    border: 2px solid #dc143c;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #000000;
    backdrop-filter: blur(5px);
}

.memory-card:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(220,20,60,0.3);
    background: #dc143c;
    color: #ffffff;
}

.memory-card.flipped {
    background: #dc143c;
    color: #ffffff;
    border-color: #8b0000;
    box-shadow: 0 0 15px rgba(220,20,60,0.5);
}

.memory-card.matched {
    background: #000000;
    color: #ffffff;
    border-color: #000000;
    box-shadow: 0 0 15px rgba(0,0,0,0.5);
    animation: pulse 0.5s ease-in-out;
}

.sequence-buttons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    max-width: 300px;
    margin: 0 auto;
}

.sequence-btn {
    aspect-ratio: 1;
    font-size: 2rem;
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 2px solid #dc143c;
    background: rgba(255,255,255,0.9);
    color: #000000;
    backdrop-filter: blur(5px);
}

.sequence-btn:hover {
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(220,20,60,0.3);
}

.sequence-btn.active {
    transform: scale(1.1);
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(220,20,60,0.5);
}

.sequence-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f8f9fa;
    color: #6c757d;
    border-color: #dee2e6;
}

.puzzle-board {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    max-width: 300px;
    margin: 0 auto;
    background: #000000;
    padding: 2px;
    border-radius: 10px;
    border: 2px solid #dc143c;
}

.puzzle-piece {
    aspect-ratio: 1;
    background: rgba(255,255,255,0.9);
    border: 1px solid #dc143c;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #000000;
    backdrop-filter: blur(5px);
}

.puzzle-piece:hover {
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 0 10px rgba(220,20,60,0.5);
}

.puzzle-piece.empty {
    background: #000000;
    cursor: default;
    border-color: #000000;
}

.puzzle-piece.correct {
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 0 15px rgba(220,20,60,0.7);
}

.clicker-btn {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    font-size: 3rem;
    transition: all 0.2s ease;
    border: 4px solid #dc143c;
    background: #ffffff;
    color: #000000;
}

.clicker-btn:hover {
    transform: scale(1.1);
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 10px 25px rgba(220,20,60,0.4);
}

.clicker-btn:active {
    transform: scale(0.95);
    background: #8b0000;
}

.stat-item {
    padding: 1rem;
    border-radius: 10px;
    background: rgba(255,255,255,0.9);
    border: 2px solid #dc143c;
    margin-bottom: 1rem;
    color: #000000;
    backdrop-filter: blur(5px);
}

.upgrade-btn {
    width: 100%;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    border: 2px solid #dc143c;
    background: rgba(255,255,255,0.9);
    color: #000000;
    backdrop-filter: blur(5px);
}

.upgrade-btn:hover {
    transform: translateY(-2px);
    background: #dc143c;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(220,20,60,0.3);
}

.upgrade-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f8f9fa;
    color: #6c757d;
    border-color: #dee2e6;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }
    
    .timeline-item {
        width: 100%;
        left: 0 !important;
        padding-left: 3rem !important;
        padding-right: 0 !important;
    }
    
    .timeline-marker {
        left: 10px !important;
    }
    
    .memory-grid {
        grid-template-columns: repeat(3, 1fr);
        max-width: 300px;
    }
    
    .sequence-buttons {
        grid-template-columns: repeat(2, 1fr);
        max-width: 250px;
    }
    
    .puzzle-board {
        max-width: 250px;
    }
    
    .clicker-btn {
        width: 120px;
        height: 120px;
        font-size: 2.5rem;
    }
}
</style>

<script>
// Funciones para la página interactiva
function showModal(type) {
    const modal = new bootstrap.Modal(document.getElementById('interactiveModal'));
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');
    
    switch(type) {
        case 'templarios':
            title.textContent = 'Orígenes Templarios';
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="img-fluid rounded" alt="Templarios">
                    </div>
                    <div class="col-md-6">
                        <h6>Nuestra Historia</h6>
                        <p>La Filá Mariscales de Caballeros Templarios fue fundada en 1975, inspirada en la noble tradición de los caballeros templarios medievales.</p>
                        <ul>
                            <li>Fundación: 1975</li>
                            <li>Valores: Honor, Lealtad, Tradición</li>
                            <li>Colores: Rojo y Negro</li>
                            <li>Símbolo: Cruz Templaria</li>
                        </ul>
                    </div>
                </div>
            `;
            break;
        case 'bandas':
            title.textContent = 'Bandas de Música';
            content.innerHTML = `
                <div class="text-center">
                    <i class="bi bi-music-note-beamed fs-1 text-danger mb-3"></i>
                    <h6>Nuestras Bandas</h6>
                    <p>Contamos con varias bandas de música que nos acompañan en todos nuestros desfiles y eventos.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Banda Principal</h6>
                            <p>La banda principal de la filá</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Banda Juvenil</h6>
                            <p>Formada por nuestros miembros más jóvenes</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Banda de Tambores</h6>
                            <p>Especializada en percusión</p>
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'eventos':
            title.textContent = 'Eventos Anuales';
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Eventos Principales</h6>
                        <ul>
                            <li>Fiestas de Moros y Cristianos (Abril)</li>
                            <li>Cena Anual de Hermandad (Marzo)</li>
                            <li>Ensayos Generales (Febrero)</li>
                            <li>Celebración de San Jorge (Abril)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Actividades Regulares</h6>
                        <ul>
                            <li>Ensayos semanales</li>
                            <li>Reuniones de directiva</li>
                            <li>Actividades sociales</li>
                            <li>Eventos benéficos</li>
                        </ul>
                    </div>
                </div>
            `;
            break;
    }
    
    modal.show();
}

// Funciones del quiz
let currentQuestion = 0;
let score = 0;
let quizQuestions = [
    {
        question: "¿En qué año se fundó la Filá Mariscales?",
        answers: ["1975", "1980", "1970", "1985"],
        correct: 0,
        explanation: "La Filá Mariscales de Caballeros Templarios fue fundada en 1975."
    },
    {
        question: "¿Cuáles son los colores principales de la filá?",
        answers: ["Rojo y Negro", "Azul y Blanco", "Verde y Dorado", "Morado y Plateado"],
        correct: 0,
        explanation: "Los colores tradicionales de la Filá Mariscales son el rojo y el negro."
    },
    {
        question: "¿Qué símbolo representa a los Caballeros Templarios?",
        answers: ["Cruz Templaria", "Águila Imperial", "León Rampante", "Corona Real"],
        correct: 0,
        explanation: "La Cruz Templaria es el símbolo distintivo de los Caballeros Templarios."
    },
    {
        question: "¿En qué ciudad se encuentra la Filá Mariscales?",
        answers: ["Elche", "Alicante", "Valencia", "Murcia"],
        correct: 0,
        explanation: "La Filá Mariscales tiene su sede en la ciudad de Elche."
    },
    {
        question: "¿Cuántos años de tradición tiene la filá?",
        answers: ["50 años", "45 años", "40 años", "55 años"],
        correct: 0,
        explanation: "Desde su fundación en 1975, la filá tiene más de 50 años de tradición."
    },
    {
        question: "¿Qué tipo de música acompaña a la filá?",
        answers: ["Bandas de música", "Orquesta sinfónica", "Música electrónica", "Coro a capella"],
        correct: 0,
        explanation: "Las bandas de música son una parte fundamental de la tradición de la filá."
    },
    {
        question: "¿Cuál es el evento principal en el que participa la filá?",
        answers: ["Fiestas de Moros y Cristianos", "Feria de Abril", "Fallas de Valencia", "Semana Santa"],
        correct: 0,
        explanation: "Las Fiestas de Moros y Cristianos son el evento principal de la filá."
    },
    {
        question: "¿Qué valores representa la filá?",
        answers: ["Honor, Lealtad y Tradición", "Poder, Riqueza y Gloria", "Libertad, Igualdad y Fraternidad", "Paz, Amor y Armonía"],
        correct: 0,
        explanation: "Los valores fundamentales de la filá son el Honor, la Lealtad y la Tradición."
    },
    {
        question: "¿En qué mes se celebran principalmente las Fiestas de Moros y Cristianos?",
        answers: ["Abril", "Mayo", "Junio", "Julio"],
        correct: 0,
        explanation: "Las Fiestas de Moros y Cristianos se celebran principalmente en el mes de abril."
    },
    {
        question: "¿Qué tipo de desfile es característico de la filá?",
        answers: ["Desfile de Entrada", "Desfile de Salida", "Desfile de Gala", "Desfile de Despedida"],
        correct: 0,
        explanation: "El Desfile de Entrada es uno de los más característicos y esperados de la filá."
    },
    {
        question: "¿Cuántos miembros activos tiene aproximadamente la filá?",
        answers: ["150 miembros", "100 miembros", "200 miembros", "250 miembros"],
        correct: 0,
        explanation: "La Filá Mariscales cuenta con aproximadamente 150 miembros activos."
    },
    {
        question: "¿Qué instrumento musical es fundamental en las bandas de la filá?",
        answers: ["Tambor", "Guitarra", "Piano", "Violín"],
        correct: 0,
        explanation: "El tambor es un instrumento fundamental en las bandas de música de la filá."
    },
    {
        question: "¿En qué década se expandió significativamente la filá?",
        answers: ["1990s", "1980s", "2000s", "2010s"],
        correct: 0,
        explanation: "En la década de 1990, la filá se expandió significativamente y creó nuevas secciones."
    },
    {
        question: "¿Qué actividad se realiza durante los ensayos generales?",
        answers: ["Preparación para desfiles", "Reuniones de directiva", "Actividades sociales", "Eventos benéficos"],
        correct: 0,
        explanation: "Los ensayos generales se realizan para preparar a todos los miembros para los desfiles."
    },
    {
        question: "¿Cuál es el nombre completo de la filá?",
        answers: ["Filá Mariscales de Caballeros Templarios", "Filá Mariscales de Elche", "Filá Templarios de Mariscales", "Filá Caballeros de Mariscales"],
        correct: 0,
        explanation: "El nombre completo es 'Filá Mariscales de Caballeros Templarios'."
    },
    {
        question: "¿Qué tipo de premios ha obtenido la filá?",
        answers: ["Premios de desfiles", "Premios musicales", "Premios deportivos", "Premios literarios"],
        correct: 0,
        explanation: "La filá ha obtenido numerosos premios en los desfiles de Moros y Cristianos."
    },
    {
        question: "¿En qué año participó por primera vez en las Fiestas de Moros y Cristianos?",
        answers: ["1980", "1975", "1985", "1990"],
        correct: 0,
        explanation: "La filá participó por primera vez en las Fiestas de Moros y Cristianos en 1980."
    },
    {
        question: "¿Qué representa el escudo de la filá?",
        answers: ["Símbolos templarios", "Símbolos musicales", "Símbolos de Elche", "Símbolos de Valencia"],
        correct: 0,
        explanation: "El escudo de la filá contiene símbolos relacionados con la tradición templaria."
    },
    {
        question: "¿Cuántas bandas de música tiene la filá?",
        answers: ["Varias bandas", "Una sola banda", "Dos bandas", "Tres bandas"],
        correct: 0,
        explanation: "La filá cuenta con varias bandas de música, incluyendo la banda principal y la juvenil."
    },
    {
        question: "¿Qué evento se celebra en marzo?",
        answers: ["Cena Anual de Hermandad", "Ensayos Generales", "Fiestas de Moros y Cristianos", "Celebración de San Jorge"],
        correct: 0,
        explanation: "La Cena Anual de Hermandad se celebra tradicionalmente en el mes de marzo."
    },
    {
        question: "¿Qué modernización se incorporó en 2020?",
        answers: ["Nuevas tecnologías digitales", "Nuevos instrumentos musicales", "Nuevos uniformes", "Nueva sede"],
        correct: 0,
        explanation: "En 2020 se incorporaron nuevas tecnologías y se mejoró la presencia digital de la filá."
    },
    {
        question: "¿Cuál es el objetivo principal de la filá?",
        answers: ["Mantener la tradición templaria", "Ganar premios", "Hacer música", "Organizar eventos"],
        correct: 0,
        explanation: "El objetivo principal es mantener y transmitir la tradición templaria a las nuevas generaciones."
    },
    {
        question: "¿Qué tipo de actividades sociales realiza la filá?",
        answers: ["Eventos de hermandad", "Conciertos públicos", "Competiciones deportivas", "Exposiciones de arte"],
        correct: 0,
        explanation: "La filá realiza diversos eventos de hermandad para fortalecer los lazos entre sus miembros."
    },
    {
        question: "¿En qué consiste la celebración de San Jorge?",
        answers: ["Festividad religiosa y cultural", "Concierto musical", "Desfile especial", "Cena de gala"],
        correct: 0,
        explanation: "La celebración de San Jorge es una festividad que combina aspectos religiosos y culturales."
    },
    {
        question: "¿Qué significa 'Filá' en el contexto de las fiestas?",
        answers: ["Grupo o comparsa", "Banda de música", "Tipo de desfile", "Evento festivo"],
        correct: 0,
        explanation: "'Filá' se refiere al grupo o comparsa que participa en las Fiestas de Moros y Cristianos."
    }
];

function checkAnswer(button) {
    const isCorrect = button.getAttribute('data-correct') === 'true';
    
    // Deshabilitar todos los botones
    document.querySelectorAll('.answer-btn').forEach(btn => {
        btn.disabled = true;
        if (btn.getAttribute('data-correct') === 'true') {
            btn.classList.add('correct');
        } else if (btn === button && !isCorrect) {
            btn.classList.add('incorrect');
        }
    });
    
    if (isCorrect) {
        score += 10;
        showNotification('¡Correcto! +10 puntos', 'success');
    } else {
        const correctAnswer = quizQuestions[currentQuestion].answers[quizQuestions[currentQuestion].correct];
        showNotification(`Incorrecto. La respuesta correcta era: ${correctAnswer}`, 'error');
    }
    
    // Actualizar progreso
    const progressBar = document.querySelector('.progress-bar');
    const progress = ((currentQuestion + 1) / quizQuestions.length) * 100;
    progressBar.style.width = progress + '%';
    
    // Mostrar siguiente pregunta o resultados
    setTimeout(() => {
        if (currentQuestion < quizQuestions.length - 1) {
            nextQuestion();
        } else {
        showResults();
        }
    }, 2000);
}

function nextQuestion() {
    currentQuestion++;
    loadQuestion(currentQuestion);
    
    // Resetear botones
    document.querySelectorAll('.answer-btn').forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('correct', 'incorrect');
    });
}

function loadQuestion(questionIndex) {
    const question = quizQuestions[questionIndex];
    const questionElement = document.querySelector('.question h5');
    const answersContainer = document.querySelector('.answers');
    
    questionElement.textContent = question.question;
    answersContainer.innerHTML = '';
    
    question.answers.forEach((answer, index) => {
        const button = document.createElement('button');
        button.className = 'btn btn-outline-danger answer-btn';
        button.textContent = answer;
        button.setAttribute('data-correct', index === question.correct ? 'true' : 'false');
        button.onclick = () => checkAnswer(button);
        answersContainer.appendChild(button);
    });
}

function showResults() {
    document.querySelector('.quiz-content').style.display = 'none';
    document.querySelector('.quiz-results').style.display = 'block';
    
    // Animar contador de puntuación
    const scoreElement = document.querySelector('.score-display .counter');
    scoreElement.setAttribute('data-target', score);
    
    // Iniciar animación del contador
    animateCounter(scoreElement);
}

function restartQuiz() {
    currentQuestion = 0;
    score = 0;
    
    document.querySelector('.quiz-content').style.display = 'block';
    document.querySelector('.quiz-results').style.display = 'none';
    
    // Cargar la primera pregunta
    loadQuestion(0);
    
    // Resetear progreso
    document.querySelector('.progress-bar').style.width = '0%';
}

// Variables globales para los juegos
let currentGame = 'quiz';
let memoryGame = {
    cards: [],
    flippedCards: [],
    matchedPairs: 0,
    moves: 0,
    startTime: null,
    timer: null
};

let sequenceGame = {
    sequence: [],
    playerSequence: [],
    level: 1,
    score: 0,
    isPlaying: false,
    isPlayerTurn: false
};

let puzzleGame = {
    board: [],
    emptyIndex: 8,
    moves: 0,
    startTime: null,
    timer: null
};

let clickerGame = {
    coins: 0,
    level: 1,
    coinsPerSecond: 1,
    multiplier: 1,
    upgrades: {
        cps: { cost: 10, level: 0 },
        multiplier: { cost: 50, level: 0 }
    },
    interval: null
};

// Función para cambiar entre juegos
function showGame(gameType) {
    // Ocultar todos los juegos
    document.querySelectorAll('.game-container').forEach(game => {
        game.style.display = 'none';
    });
    
    // Remover clase active de todos los botones
    document.querySelectorAll('.game-selector .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Mostrar el juego seleccionado
    document.getElementById(gameType + '-game').style.display = 'block';
    
    // Activar el botón correspondiente
    event.target.classList.add('active');
    
    currentGame = gameType;
}

// === JUEGO DE MEMORIA ===
function startMemoryGame() {
    const symbols = ['🛡️', '⚔️', '🏰', '👑', '⚡', '🔥', '⭐', '💎'];
    const cards = [...symbols, ...symbols]; // Duplicar para hacer parejas
    
    // Mezclar las cartas
    for (let i = cards.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [cards[i], cards[j]] = [cards[j], cards[i]];
    }
    
    memoryGame.cards = cards;
    memoryGame.flippedCards = [];
    memoryGame.matchedPairs = 0;
    memoryGame.moves = 0;
    memoryGame.startTime = Date.now();
    
    // Crear el grid de cartas
    const grid = document.getElementById('memory-grid');
    grid.innerHTML = '';
    
    cards.forEach((symbol, index) => {
        const card = document.createElement('div');
        card.className = 'memory-card';
        card.dataset.index = index;
        card.dataset.symbol = symbol;
        card.innerHTML = '?';
        card.onclick = () => flipCard(index);
        grid.appendChild(card);
    });
    
    // Iniciar timer
    memoryGame.timer = setInterval(updateMemoryTimer, 1000);
    updateMemoryStats();
}

function flipCard(index) {
    const card = document.querySelector(`[data-index="${index}"]`);
    if (card.classList.contains('flipped') || card.classList.contains('matched')) return;
    
    card.classList.add('flipped');
    card.innerHTML = card.dataset.symbol;
    memoryGame.flippedCards.push(index);
    
    if (memoryGame.flippedCards.length === 2) {
        memoryGame.moves++;
        updateMemoryStats();
        
        setTimeout(() => {
            checkMemoryMatch();
        }, 1000);
    }
}

function checkMemoryMatch() {
    const [index1, index2] = memoryGame.flippedCards;
    const card1 = document.querySelector(`[data-index="${index1}"]`);
    const card2 = document.querySelector(`[data-index="${index2}"]`);
    
    if (card1.dataset.symbol === card2.dataset.symbol) {
        card1.classList.add('matched');
        card2.classList.add('matched');
        memoryGame.matchedPairs++;
        
        if (memoryGame.matchedPairs === 8) {
            clearInterval(memoryGame.timer);
            showNotification('¡Felicidades! Has completado el juego de memoria', 'success');
        }
    } else {
        card1.classList.remove('flipped');
        card2.classList.remove('flipped');
        card1.innerHTML = '?';
        card2.innerHTML = '?';
    }
    
    memoryGame.flippedCards = [];
    updateMemoryStats();
}

function updateMemoryStats() {
    document.getElementById('memory-moves').textContent = memoryGame.moves;
    document.getElementById('memory-pairs').textContent = memoryGame.matchedPairs;
}

function updateMemoryTimer() {
    if (!memoryGame.startTime) return;
    
    const elapsed = Math.floor((Date.now() - memoryGame.startTime) / 1000);
    const minutes = Math.floor(elapsed / 60);
    const seconds = elapsed % 60;
    
    document.getElementById('memory-time').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// === JUEGO DE SECUENCIA ===
function startSequenceGame() {
    sequenceGame.sequence = [];
    sequenceGame.playerSequence = [];
    sequenceGame.level = 1;
    sequenceGame.score = 0;
    sequenceGame.isPlaying = true;
    sequenceGame.isPlayerTurn = false;
    
    addToSequence();
    playSequence();
    updateSequenceStats();
}

function addToSequence() {
    const randomNote = Math.floor(Math.random() * 4) + 1;
    sequenceGame.sequence.push(randomNote);
}

function playSequence() {
    let index = 0;
    const playNext = () => {
        if (index < sequenceGame.sequence.length) {
            const note = sequenceGame.sequence[index];
            const button = document.querySelector(`[data-note="${note}"]`);
            
            button.classList.add('active');
            setTimeout(() => {
                button.classList.remove('active');
                index++;
                setTimeout(playNext, 300);
            }, 500);
        } else {
            sequenceGame.isPlayerTurn = true;
            enableSequenceButtons();
        }
    };
    
    disableSequenceButtons();
    setTimeout(playNext, 1000);
}

function enableSequenceButtons() {
    document.querySelectorAll('.sequence-btn').forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('disabled');
    });
}

function disableSequenceButtons() {
    document.querySelectorAll('.sequence-btn').forEach(btn => {
        btn.disabled = true;
        btn.classList.add('disabled');
    });
}

function playSequenceNote(note) {
    if (!sequenceGame.isPlayerTurn) return;
    
    const button = document.querySelector(`[data-note="${note}"]`);
    button.classList.add('active');
    setTimeout(() => button.classList.remove('active'), 200);
    
    sequenceGame.playerSequence.push(note);
    
    const currentIndex = sequenceGame.playerSequence.length - 1;
    if (sequenceGame.playerSequence[currentIndex] !== sequenceGame.sequence[currentIndex]) {
        // Error
        showNotification('Secuencia incorrecta. ¡Inténtalo de nuevo!', 'error');
        startSequenceGame();
        return;
    }
    
    if (sequenceGame.playerSequence.length === sequenceGame.sequence.length) {
        // Nivel completado
        sequenceGame.score += sequenceGame.level * 10;
        sequenceGame.level++;
        sequenceGame.playerSequence = [];
        
        setTimeout(() => {
            addToSequence();
            playSequence();
            updateSequenceStats();
        }, 1000);
    }
}

function updateSequenceStats() {
    document.getElementById('sequence-level').textContent = sequenceGame.level;
    document.getElementById('sequence-score').textContent = sequenceGame.score;
}

// === JUEGO DE PUZZLE ===
function startPuzzleGame() {
    const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 0]; // 0 es el espacio vacío
    
    // Mezclar los números
    for (let i = numbers.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [numbers[i], numbers[j]] = [numbers[j], numbers[i]];
    }
    
    puzzleGame.board = numbers;
    puzzleGame.emptyIndex = numbers.indexOf(0);
    puzzleGame.moves = 0;
    puzzleGame.startTime = Date.now();
    
    renderPuzzle();
    updatePuzzleStats();
    
    // Iniciar timer
    puzzleGame.timer = setInterval(updatePuzzleTimer, 1000);
}

function renderPuzzle() {
    const board = document.getElementById('puzzle-board');
    board.innerHTML = '';
    
    puzzleGame.board.forEach((number, index) => {
        const piece = document.createElement('button');
        piece.className = 'puzzle-piece';
        
        if (number === 0) {
            piece.classList.add('empty');
            piece.innerHTML = '';
        } else {
            piece.innerHTML = number;
            piece.onclick = () => movePuzzlePiece(index);
        }
        
        board.appendChild(piece);
    });
}

function movePuzzlePiece(index) {
    const emptyIndex = puzzleGame.emptyIndex;
    const row = Math.floor(index / 3);
    const col = index % 3;
    const emptyRow = Math.floor(emptyIndex / 3);
    const emptyCol = emptyIndex % 3;
    
    // Verificar si es un movimiento válido (adyacente)
    const isValidMove = (Math.abs(row - emptyRow) === 1 && col === emptyCol) ||
                       (Math.abs(col - emptyCol) === 1 && row === emptyRow);
    
    if (isValidMove) {
        // Intercambiar piezas
        [puzzleGame.board[index], puzzleGame.board[emptyIndex]] = 
        [puzzleGame.board[emptyIndex], puzzleGame.board[index]];
        
        puzzleGame.emptyIndex = index;
        puzzleGame.moves++;
        
        renderPuzzle();
        updatePuzzleStats();
        
        // Verificar si el puzzle está resuelto
        if (isPuzzleSolved()) {
            clearInterval(puzzleGame.timer);
            showNotification('¡Felicidades! Has resuelto el puzzle', 'success');
        }
    }
}

function isPuzzleSolved() {
    for (let i = 0; i < 8; i++) {
        if (puzzleGame.board[i] !== i + 1) return false;
    }
    return puzzleGame.board[8] === 0;
}

function updatePuzzleStats() {
    document.getElementById('puzzle-moves').textContent = puzzleGame.moves;
}

function updatePuzzleTimer() {
    if (!puzzleGame.startTime) return;
    
    const elapsed = Math.floor((Date.now() - puzzleGame.startTime) / 1000);
    const minutes = Math.floor(elapsed / 60);
    const seconds = elapsed % 60;
    
    document.getElementById('puzzle-time').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// === JUEGO CLICKER ===
function clickCoin() {
    clickerGame.coins += clickerGame.multiplier;
    updateClickerStats();
    
    // Efecto visual
    const btn = document.querySelector('.clicker-btn');
    btn.style.transform = 'scale(0.95)';
    setTimeout(() => {
        btn.style.transform = 'scale(1)';
    }, 100);
    
    // Verificar subida de nivel
    if (clickerGame.coins >= clickerGame.level * 100) {
        clickerGame.level++;
        showNotification(`¡Subiste al nivel ${clickerGame.level}!`, 'success');
    }
}

function buyUpgrade(type) {
    const upgrade = clickerGame.upgrades[type];
    
    if (clickerGame.coins >= upgrade.cost) {
        clickerGame.coins -= upgrade.cost;
        upgrade.level++;
        upgrade.cost = Math.floor(upgrade.cost * 1.5);
        
        if (type === 'cps') {
            clickerGame.coinsPerSecond++;
        } else if (type === 'multiplier') {
            clickerGame.multiplier *= 2;
        }
        
        updateClickerStats();
        updateUpgradeButtons();
        showNotification(`¡Mejora ${type} comprada!`, 'success');
    }
}

function updateClickerStats() {
    document.getElementById('clicker-coins').textContent = clickerGame.coins;
    document.getElementById('clicker-level').textContent = clickerGame.level;
    document.getElementById('clicker-cps').textContent = clickerGame.coinsPerSecond;
}

function updateUpgradeButtons() {
    const cpsBtn = document.querySelector('[onclick="buyUpgrade(\'cps\')"]');
    const multBtn = document.querySelector('[onclick="buyUpgrade(\'multiplier\')"]');
    
    cpsBtn.innerHTML = `<i class="bi bi-lightning me-2"></i>Velocidad (+1/s) - ${clickerGame.upgrades.cps.cost} monedas`;
    multBtn.innerHTML = `<i class="bi bi-star me-2"></i>Multiplicador x2 - ${clickerGame.upgrades.multiplier.cost} monedas`;
    
    cpsBtn.disabled = clickerGame.coins < clickerGame.upgrades.cps.cost;
    multBtn.disabled = clickerGame.coins < clickerGame.upgrades.multiplier.cost;
}

function startClickerGame() {
    if (clickerGame.interval) return;
    
    clickerGame.interval = setInterval(() => {
        clickerGame.coins += clickerGame.coinsPerSecond;
        updateClickerStats();
        updateUpgradeButtons();
    }, 1000);
}

// Función para mostrar notificaciones
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}

// Agregar event listeners a los botones de respuesta
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el quiz con la primera pregunta
    loadQuestion(0);
    
    // Event listeners para el juego de secuencia
    document.querySelectorAll('.sequence-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const note = parseInt(this.dataset.note);
            playSequenceNote(note);
        });
    });
    
    // Inicializar juego clicker
    startClickerGame();
});
</script>
