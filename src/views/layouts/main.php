<?php
// Asegurar que las funciones de autenticación estén disponibles
if (!function_exists('isLoggedIn')) {
    require_once dirname(dirname(__DIR__)) . '/config/helpers.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> | <?php echo $data['title']; ?></title>
    <meta name="description" content="<?php echo isset($data['description']) ? $data['description'] : SITE_NAME; ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts Medieval -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/prueba-php/public/assets/css/style.css">
    <!-- Animations CSS -->
    <link rel="stylesheet" href="/prueba-php/public/assets/css/animations.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/prueba-php/public/">
                <i class="bi bi-shield-fill me-2"></i>
                Filá Mariscales
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('') ? 'active' : ''; ?>" href="/prueba-php/public/">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    </li>
                    
                    <!-- Quienes Somos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isActive('historia') || isActive('directiva') || isActive('blog') || isActive('libro') || isActive('noticias')) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people-fill me-1"></i>Quienes Somos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/historia">
                                    <i class="bi bi-clock-history me-2"></i>Historia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/directiva">
                                    <i class="bi bi-person-badge me-2"></i>Directiva
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/blog">
                                    <i class="bi bi-journal-text me-2"></i>Blog
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/libro">
                                    <i class="bi bi-book-open me-2"></i>Libro
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/noticias">
                                    <i class="bi bi-newspaper me-2"></i>Noticias
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Utilidades -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isActive('calendario') || isActive('musica') || isActive('descargas') || isActive('galeria')) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tools me-1"></i>Utilidades
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/calendario">
                                    <i class="bi bi-calendar-event me-2"></i>Calendario
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/musica">
                                    <i class="bi bi-music-note me-2"></i>Música
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/descargas">
                                    <i class="bi bi-download me-2"></i>Descargas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/galeria">
                                    <i class="bi bi-images me-2"></i>Galería
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Recursos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isActive('tienda') || isActive('patrocinadores') || isActive('hermanamientos') || isActive('interactiva')) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-collection me-1"></i>Recursos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/interactiva">
                                    <i class="bi bi-magic me-2"></i>Zona Interactiva
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/tienda">
                                    <i class="bi bi-shop me-2"></i>Tienda
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/patrocinadores">
                                    <i class="bi bi-star me-2"></i>Patrocinadores
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/prueba-php/public/hermanamientos">
                                    <i class="bi bi-heart me-2"></i>Hermanamientos
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Socios -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('socios') ? 'active' : ''; ?>" href="/prueba-php/public/socios">
                            <i class="bi bi-person-badge me-1"></i>Socios
                        </a>
                    </li>
                    
                    <!-- Usuario Dropdown -->
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <span class="d-none d-md-inline"><?php echo $_SESSION['user_name']; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile">
                                    <i class="bi bi-person me-2"></i>Mi Perfil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/prueba-php/public/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                </a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <!-- Carrito (solo mostrar si hay productos) -->
                    <?php 
                    $cart_count = 0;
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $cart_count += $item['quantity'];
                        }
                    }
                    ?>
                    <?php if ($cart_count > 0): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/prueba-php/public/cart">
                                <i class="bi bi-cart3 me-1"></i>Carrito
                                <span class="badge bg-danger ms-1 cart-counter"><?= $cart_count ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Favoritos (solo mostrar si hay productos) -->
                    <?php 
                    $wishlist_count = 0;
                    if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
                        $wishlist_count = count($_SESSION['wishlist']);
                    }
                    ?>
                    <?php if ($wishlist_count > 0): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/prueba-php/public/order/wishlist">
                                <i class="bi bi-heart me-1"></i>Favoritos
                                <span class="badge bg-danger ms-1 wishlist-counter"><?= $wishlist_count ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-admin" href="/prueba-php/public/admin">
                                    <i class="bi bi-gear me-1"></i>Admin
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-login" href="/prueba-php/public/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-admin" href="/prueba-php/public/registro">
                                <i class="bi bi-person-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="footer-templar mt-3">
        <div class="footer-top py-3">
            <div class="container">
                <div class="row g-3">
                    <!-- Información de la Filá -->
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-info">
                            <div class="footer-logo mb-2">
                                <i class="bi bi-shield-fill me-2"></i>
                                <h4 class="text-white mb-1">Filá Mariscales</h4>
                                <p class="text-light mb-0">Caballeros Templarios de Elche</p>
                            </div>
                            <p class="text-light mb-2">
                                Fundada en 1975, somos una de las filaes más tradicionales y respetadas 
                                de las Fiestas de Moros y Cristianos de Elche. Mantenemos viva la tradición 
                                templaria con honor y orgullo.
                            </p>
                            <div class="footer-social">
                                <h6 class="text-white mb-2">Síguenos</h6>
                                <div class="social-links">
                                    <a href="#" class="social-link" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="social-link" title="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link" title="YouTube">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                    <a href="#" class="social-link" title="WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto -->
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-contact">
                            <h6 class="text-white mb-2">Contacto</h6>
                            <div class="row">
                                <!-- Primera columna: Sede Social y Teléfono -->
                                <div class="col-6">
                                    <div class="contact-item mb-2">
                                        <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                                        <div>
                                            <strong class="text-white">Sede Social</strong><br>
                                            <span class="text-light">Calle Mayor, 123<br>03201 Elche, Alicante</span>
                                        </div>
                                    </div>
                                    <div class="contact-item mb-2">
                                        <i class="bi bi-telephone-fill me-2 text-danger"></i>
                                        <div>
                                            <strong class="text-white">Teléfono</strong><br>
                                            <a href="tel:+34966123456" class="text-light text-decoration-none">966 123 456</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna: Email y Horario -->
                                <div class="col-6">
                                    <div class="contact-item mb-2">
                                        <i class="bi bi-envelope-fill me-2 text-danger"></i>
                                        <div>
                                            <strong class="text-white">Email</strong><br>
                                            <a href="mailto:info@filamariscales.es" class="text-light text-decoration-none">info@filamariscales.es</a>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="bi bi-clock-fill me-2 text-danger"></i>
                                        <div>
                                            <strong class="text-white">Horario</strong><br>
                                            <span class="text-light">Lun-Vie: 18:00-22:00<br>Sáb: 10:00-14:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-light">
                            &copy; <?php echo date('Y'); ?> <strong>Filá Mariscales</strong>. Todos los derechos reservados.
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="footer-bottom-links">
                            <a href="/prueba-php/public/privacidad" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                            <a href="/prueba-php/public/cookies" class="text-light text-decoration-none me-3">Cookies</a>
                            <a href="/prueba-php/public/legal" class="text-light text-decoration-none">Aviso Legal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <button id="scrollToTop" class="scroll-to-top" title="Volver arriba">
            <i class="bi bi-arrow-up"></i>
        </button>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="/prueba-php/public/assets/js/main.js"></script>
    <!-- Animations JS -->
    <script src="/prueba-php/public/assets/js/animations.js"></script>
    
    <script>
        // Bootstrap-compatible dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing dropdowns...');
            
            // Try Bootstrap first, fallback to custom if needed
            if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                console.log('Using Bootstrap dropdowns');
                try {
                    // Initialize Bootstrap dropdowns
                    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                        return new bootstrap.Dropdown(dropdownToggleEl);
                    });
                    console.log('Bootstrap dropdowns initialized:', dropdownList.length);
                } catch (error) {
                    console.error('Bootstrap dropdown error:', error);
                    initializeCustomDropdowns();
                }
            } else {
                console.log('Bootstrap not available, using custom dropdowns');
                initializeCustomDropdowns();
            }
            
            function initializeCustomDropdowns() {
                console.log('Initializing custom dropdowns...');
                
                document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        console.log('Custom dropdown clicked');
                        
                        var dropdown = this.closest('.dropdown');
                        var menu = dropdown.querySelector('.dropdown-menu');
                        
                        if (menu) {
                            // Close all other dropdowns
                            document.querySelectorAll('.dropdown-menu.show').forEach(function(otherMenu) {
                                if (otherMenu !== menu) {
                                    otherMenu.classList.remove('show');
                                }
                            });
                            
                            // Toggle current dropdown
                            menu.classList.toggle('show');
                            console.log('Custom dropdown toggled, show:', menu.classList.contains('show'));
                        }
                    });
                });
                
                // Close dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.dropdown')) {
                        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                            menu.classList.remove('show');
                        });
                    }
                });
            }
        });

        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Flash messages
        <?php if (getFlashMessage()): ?>
            const flashMessage = <?php echo json_encode(getFlashMessage()); ?>;
            if (flashMessage) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${flashMessage.type} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
                alertDiv.innerHTML = `
                    ${flashMessage.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);
                
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
        <?php endif; ?>

        // Scroll to Top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');
        if (scrollToTopBtn) {
            // Show/hide button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            });

            // Smooth scroll to top when clicked
            scrollToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Footer animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate footer elements on scroll
            const footerElements = document.querySelectorAll('.footer-info, .footer-links, .footer-contact');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            footerElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
        });

        // Logout function
        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                // Crear un formulario para enviar el logout
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/prueba-php/public/logout';
                
                // Agregar token CSRF si existe
                var csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    form.appendChild(csrfInput);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Función para actualizar el contador del carrito en la navegación
        function updateCartCounter(count) {
            const cartLink = document.querySelector('.navbar-nav .nav-link[href*="cart"]');
            const cartCounter = document.querySelector('.cart-counter');
            
            if (count > 0) {
                // Mostrar enlace del carrito si no existe
                if (!cartLink) {
                    const navbarNav = document.querySelector('.navbar-nav');
                    const cartItem = document.createElement('li');
                    cartItem.className = 'nav-item';
                    cartItem.innerHTML = `
                        <a class="nav-link" href="/prueba-php/public/cart">
                            <i class="bi bi-cart3 me-1"></i>Carrito
                            <span class="badge bg-danger ms-1 cart-counter">${count}</span>
                        </a>
                    `;
                    
                    // Insertar antes del enlace de favoritos
                    const favoritosLink = document.querySelector('.navbar-nav .nav-link[href*="wishlist"]');
                    if (favoritosLink) {
                        favoritosLink.closest('li').before(cartItem);
                    } else {
                        navbarNav.appendChild(cartItem);
                    }
                } else {
                    // Actualizar contador existente
                    if (cartCounter) {
                        cartCounter.textContent = count;
                    } else {
                        // Añadir contador si no existe
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-danger ms-1 cart-counter';
                        badge.textContent = count;
                        cartLink.appendChild(badge);
                    }
                }
            } else {
                // Ocultar enlace del carrito si no hay productos
                if (cartLink) {
                    cartLink.closest('li').remove();
                }
            }
        }

        // Función para obtener información del carrito
        function getCartInfo() {
            fetch('/prueba-php/public/cart/info')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCounter(data.cart_count);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener información del carrito:', error);
                });
        }

        // Función para actualizar el contador de favoritos en la navegación
        function updateWishlistCounter(count) {
            const wishlistLink = document.querySelector('.navbar-nav .nav-link[href*="wishlist"]');
            const wishlistCounter = document.querySelector('.wishlist-counter');
            
            if (count > 0) {
                // Mostrar enlace de favoritos si no existe
                if (!wishlistLink) {
                    const navbarNav = document.querySelector('.navbar-nav');
                    const wishlistItem = document.createElement('li');
                    wishlistItem.className = 'nav-item';
                    wishlistItem.innerHTML = `
                        <a class="nav-link" href="/prueba-php/public/order/wishlist">
                            <i class="bi bi-heart me-1"></i>Favoritos
                            <span class="badge bg-danger ms-1 wishlist-counter">${count}</span>
                        </a>
                    `;
                    
                    // Insertar después del enlace del carrito o al final
                    const cartLink = document.querySelector('.navbar-nav .nav-link[href*="cart"]');
                    if (cartLink) {
                        cartLink.closest('li').after(wishlistItem);
                    } else {
                        navbarNav.appendChild(wishlistItem);
                    }
                } else {
                    // Actualizar contador existente
                    if (wishlistCounter) {
                        wishlistCounter.textContent = count;
                    } else {
                        // Añadir contador si no existe
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-danger ms-1 wishlist-counter';
                        badge.textContent = count;
                        wishlistLink.appendChild(badge);
                    }
                }
            } else {
                // Ocultar enlace de favoritos si no hay productos
                if (wishlistLink) {
                    wishlistLink.closest('li').remove();
                }
            }
        }

        // Función para obtener información de la wishlist
        function getWishlistInfo() {
            fetch('/prueba-php/public/order/wishlist/info')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateWishlistCounter(data.wishlist_count);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener información de favoritos:', error);
                });
        }

        // Actualizar contador del carrito al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            getCartInfo();
            getWishlistInfo();
        });
    </script>
    
    <!-- JavaScript para manejar dropdowns en menú hamburguesa -->
    <script>
    // Esperar a que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        console.log('JavaScript para dropdowns cargado');
        
        // Detectar si estamos en móvil/tablet
        function isMobile() {
            return window.innerWidth <= 991.98;
        }
        
        // Función para manejar clicks en dropdowns
        function handleDropdownClick(e) {
            if (isMobile()) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                console.log('Click en dropdown detectado');
                
                const dropdown = this.nextElementSibling;
                const isOpen = dropdown.classList.contains('show');
                
                // Cerrar todos los dropdowns abiertos
                document.querySelectorAll('.navbar-collapse .dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
                
                // Abrir/cerrar el dropdown actual
                if (!isOpen) {
                    dropdown.classList.add('show');
                    console.log('Dropdown abierto');
                } else {
                    console.log('Dropdown cerrado');
                }
                
                return false;
            }
        }
        
        // Deshabilitar Bootstrap dropdowns en móviles
        function disableBootstrapDropdowns() {
            if (isMobile()) {
                document.querySelectorAll('.navbar-collapse .dropdown-toggle').forEach(function(toggle) {
                    // Remover data-bs-toggle para deshabilitar Bootstrap
                    toggle.removeAttribute('data-bs-toggle');
                    toggle.removeAttribute('data-bs-auto-close');
                    
                    // Agregar nuestro event listener
                    toggle.addEventListener('click', handleDropdownClick, true);
                });
                
                // Agregar hover para dispositivos que lo soporten
                document.querySelectorAll('.navbar-collapse .dropdown').forEach(function(dropdown) {
                    dropdown.addEventListener('mouseenter', function() {
                        if (isMobile()) {
                            const menu = this.querySelector('.dropdown-menu');
                            if (menu) {
                                // Cerrar otros dropdowns
                                document.querySelectorAll('.navbar-collapse .dropdown-menu.show').forEach(function(otherMenu) {
                                    if (otherMenu !== menu) {
                                        otherMenu.classList.remove('show');
                                    }
                                });
                                // Abrir este dropdown
                                menu.classList.add('show');
                            }
                        }
                    });
                    
                    dropdown.addEventListener('mouseleave', function() {
                        if (isMobile()) {
                            const menu = this.querySelector('.dropdown-menu');
                            if (menu) {
                                // Cerrar dropdown al salir del hover
                                setTimeout(function() {
                                    menu.classList.remove('show');
                                }, 300);
                            }
                        }
                    });
                });
            }
        }
        
        // Habilitar Bootstrap dropdowns en desktop
        function enableBootstrapDropdowns() {
            if (!isMobile()) {
                document.querySelectorAll('.navbar-collapse .dropdown-toggle').forEach(function(toggle) {
                    // Restaurar data-bs-toggle para habilitar Bootstrap
                    toggle.setAttribute('data-bs-toggle', 'dropdown');
                    toggle.setAttribute('data-bs-auto-close', 'true');
                    
                    // Remover nuestro event listener
                    toggle.removeEventListener('click', handleDropdownClick, true);
                });
                
                // Remover event listeners de hover
                document.querySelectorAll('.navbar-collapse .dropdown').forEach(function(dropdown) {
                    dropdown.removeEventListener('mouseenter', arguments.callee);
                    dropdown.removeEventListener('mouseleave', arguments.callee);
                });
            }
        }
        
        // Inicializar
        disableBootstrapDropdowns();
        
        // Manejar resize de ventana
        window.addEventListener('resize', function() {
            if (isMobile()) {
                disableBootstrapDropdowns();
            } else {
                enableBootstrapDropdowns();
                // Cerrar todos los dropdowns al cambiar a desktop
                document.querySelectorAll('.navbar-collapse .dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
        
        // Cerrar dropdowns al hacer click fuera
        document.addEventListener('click', function(e) {
            if (isMobile() && !e.target.closest('.navbar-collapse .dropdown')) {
                document.querySelectorAll('.navbar-collapse .dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
    });
    </script>
</body>
</html>
