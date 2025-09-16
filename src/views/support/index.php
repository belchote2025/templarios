<?php require_once APPROOT . '/views/inc/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Centro de Ayuda</h1>
                <p class="lead mb-4">Encuentra respuestas a las preguntas más frecuentes o contacta con nuestro equipo de soporte.</p>
                
                <!-- Search Bar -->
                <div class="search-container mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" id="faqSearch" class="form-control" placeholder="¿En qué podemos ayudarte hoy?">
                        <button class="btn btn-light" type="button" id="searchButton">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Categorías</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action active" data-category="all">
                        <i class="bi bi-grid me-2"></i> Todas las categorías
                    </a>
                    <?php foreach ($categories as $category): ?>
                    <a href="#" class="list-group-item list-group-item-action" data-category="<?= $category->id ?>">
                        <i class="bi <?= $category->icon ?? 'bi-question-circle' ?> me-2"></i>
                        <?= htmlspecialchars($category->name) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Contact Support -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">¿Necesitas ayuda?</h5>
                </div>
                <div class="card-body">
                    <p>Si no encuentras lo que buscas, nuestro equipo de soporte está aquí para ayudarte.</p>
                    <a href="#contactForm" class="btn btn-primary w-100" data-bs-toggle="collapse">
                        <i class="bi bi-envelope me-2"></i> Contactar soporte
                    </a>
                </div>
            </div>
        </div>
        
        <!-- FAQ Content -->
        <div class="col-lg-8">
            <!-- Featured FAQs -->
            <?php if (!empty($featuredFaqs)): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Preguntas destacadas</h5>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach ($featuredFaqs as $faq): ?>
                    <div class="list-group-item">
                        <h6 class="mb-1">
                            <a href="#" class="text-decoration-none faq-item" data-id="<?= $faq->id ?>">
                                <?= htmlspecialchars($faq->question) ?>
                            </a>
                        </h6>
                        <p class="text-muted small mb-0">
                            En <?= htmlspecialchars($faq->category_name ?? 'General') ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Search Results -->
            <div id="searchResults" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Resultados de búsqueda</h4>
                    <button id="clearSearch" class="btn btn-sm btn-outline-secondary">Limpiar búsqueda</button>
                </div>
                <div id="searchResultsList" class="list-group mb-4">
                    <!-- Results will be loaded here via JavaScript -->
                </div>
            </div>
            
            <!-- Contact Form (Collapsible) -->
            <div class="collapse" id="contactForm">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Enviar mensaje de soporte</h5>
                    </div>
                    <div class="card-body">
                        <form id="supportContactForm">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i> Enviar mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Live Chat -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chat en vivo</h5>
                    <span class="badge bg-success" id="chatStatus">En línea</span>
                </div>
                <div class="card-body p-0">
                    <div id="chatMessages" style="height: 300px; overflow-y: auto;" class="p-3 border-bottom">
                        <!-- Messages will be loaded here -->
                        <div class="text-center text-muted my-5">
                            <i class="bi bi-chat-square-text display-4 d-block mb-2"></i>
                            <p>Inicia una conversación con nuestro equipo de soporte</p>
                        </div>
                    </div>
                    <div class="p-3">
                        <form id="chatForm">
                            <div class="input-group">
                                <input type="text" id="chatMessage" class="form-control" placeholder="Escribe tu mensaje..." required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Modal -->
<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">Pregunta frecuente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="faqModalBody">
                <!-- FAQ content will be loaded here -->
            </div>
            <div class="modal-footer">
                <div class="me-auto text-muted small" id="faqMeta"></div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-outline-primary" id="markHelpful">
                    <i class="bi bi-hand-thumbs-up"></i> ¿Te resultó útil?
                </button>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<!-- JavaScript for Support System -->
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // FAQ Search
    let searchTimeout;
    $('#faqSearch').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();
        
        if (query.length >= 3) {
            searchTimeout = setTimeout(() => {
                searchFaqs(query);
            }, 500);
        } else if (query.length === 0) {
            $('#searchResults').addClass('d-none');
        }
    });

    // Clear search
    $('#clearSearch').on('click', function() {
        $('#faqSearch').val('');
        $('#searchResults').addClass('d-none');
    });

    // Search FAQs
    function searchFaqs(query, categoryId = null) {
        let url = `<?= URL_ROOT ?>/soporte/buscar?q=${encodeURIComponent(query)}`;
        if (categoryId) {
            url += `&category_id=${categoryId}`;
        }
        
        $.getJSON(url, function(response) {
            const results = $('#searchResults');
            const resultsList = $('#searchResultsList');
            
            resultsList.empty();
            
            if (response.results && response.results.length > 0) {
                response.results.forEach(function(faq) {
                    resultsList.append(`
                        <div class="list-group-item">
                            <h6 class="mb-1">
                                <a href="#" class="text-decoration-none faq-item" data-id="${faq.id}">
                                    ${faq.question}
                                </a>
                            </h6>
                            <p class="text-muted small mb-0">
                                ${faq.answer.substring(0, 150)}...
                            </p>
                        </div>
                    `);
                });
            } else {
                resultsList.append(`
                    <div class="text-center py-4">
                        <i class="bi bi-search display-4 text-muted mb-3"></i>
                        <p class="text-muted">No se encontraron resultados para tu búsqueda.</p>
                    </div>
                `);
            }
            
            results.removeClass('d-none');
        }).fail(function() {
            console.error('Error searching FAQs');
        });
    }

    // Load FAQ details in modal
    $(document).on('click', '.faq-item', function(e) {
        e.preventDefault();
        const faqId = $(this).data('id');
        
        // In a real implementation, you would fetch the FAQ details via AJAX
        // For now, we'll just show a placeholder
        $('#faqModalLabel').text('Cargando...');
        $('#faqModalBody').html('<p>Cargando pregunta frecuente...</p>');
        $('#faqMeta').html('');
        
        // Simulate loading
        setTimeout(() => {
            $('#faqModalLabel').text('Pregunta frecuente #' + faqId);
            $('#faqModalBody').html(`
                <h5>${$('.faq-item[data-id="' + faqId + '"]').text()}</h5>
                <div class="mt-3">
                    <p>Esta es una respuesta de ejemplo para la pregunta frecuente #${faqId}. En una implementación real, esto se cargaría desde la base de datos.</p>
                    <p>Puedes incluir aquí información detallada, pasos a seguir, enlaces a recursos relacionados, etc.</p>
                </div>
            `);
            $('#faqMeta').html('<i class="bi bi-eye"></i> 124 vistas');
        }, 500);
        
        const modal = new bootstrap.Modal(document.getElementById('faqModal'));
        modal.show();
        
        // Track view (in a real implementation)
        // $.post(`/api/faqs/${faqId}/view`);
    });

    // Chat functionality
    const chatMessages = $('#chatMessages');
    
    // Scroll to bottom of chat
    function scrollChatToBottom() {
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
    
    // Format message time
    function formatMessageTime(date) {
        return new Date(date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
    
    // Add message to chat
    function addMessage(message, isFromAdmin = false) {
        const messageClass = isFromAdmin ? 'admin-message' : 'user-message';
        const messageTime = formatMessageTime(new Date());
        
        const messageHtml = `
            <div class="mb-3 ${messageClass}">
                <div class="d-flex justify-content-${isFromAdmin ? 'start' : 'end'} mb-1">
                    <div class="message-bubble ${isFromAdmin ? 'bg-light' : 'bg-primary text-white'}">
                        ${message}
                        <div class="message-time text-${isFromAdmin ? 'muted' : 'white-50'} small mt-1">
                            ${messageTime}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        chatMessages.append(messageHtml);
        scrollChatToBottom();
    }
    
    // Handle chat form submission
    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        const messageInput = $('#chatMessage');
        const message = messageInput.val().trim();
        
        if (message) {
            // Add user message to chat
            addMessage(message, false);
            
            // In a real implementation, you would send this to the server
            // and receive a response from the support team
            messageInput.val('');
            
            // Simulate response after a delay
            setTimeout(() => {
                const responses = [
                    "Gracias por tu mensaje. ¿En qué más podemos ayudarte?",
                    "Hemos recibido tu consulta. Te responderemos lo antes posible.",
                    "Nuestro equipo ha sido notificado y te contactará pronto.",
                    "¿Hay algo más en lo que podamos ayudarte hoy?",
                    "Gracias por contactar con el soporte. Estamos aquí para ayudarte."
                ];
                const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                addMessage(randomResponse, true);
            }, 1000);
            
            // In a real implementation, you would use something like:
            // $.post('/soporte/chat/enviar', { message: message }, function(response) {
            //     // Handle response
            // });
        }
    });
    
    // Mark FAQ as helpful
    $('#markHelpful').on('click', function() {
        const button = $(this);
        button.prop('disabled', true).html('<i class="bi bi-check2"></i> ¡Gracias por tu feedback!');
        
        // In a real implementation, you would send this to the server
        // $.post(`/api/faqs/${faqId}/helpful`);
    });
    
    // Category filter
    $('.list-group-item[data-category]').on('click', function(e) {
        e.preventDefault();
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        
        const categoryId = $(this).data('category');
        const searchQuery = $('#faqSearch').val().trim();
        
        if (searchQuery.length >= 3) {
            searchFaqs(searchQuery, categoryId === 'all' ? null : categoryId);
        }
        // In a real implementation, you would filter the FAQs by category
    });
});
</script>

<style>
/* Chat Styles */
.message-bubble {
    max-width: 70%;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    display: inline-block;
    word-wrap: break-word;
}

.user-message .message-bubble {
    background-color: #0d6efd;
    color: white;
    border-bottom-right-radius: 0.25rem;
}

.admin-message .message-bubble {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-bottom-left-radius: 0.25rem;
}

.message-time {
    font-size: 0.7rem;
    text-align: right;
}

/* FAQ Styles */
.faq-item {
    color: #0d6efd;
    transition: color 0.2s;
}

.faq-item:hover {
    color: #0a58ca;
}

/* Search Results */
#searchResults {
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive Adjustments */
@media (max-width: 991.98px) {
    .message-bubble {
        max-width: 85%;
    }
}
</style>
