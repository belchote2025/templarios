<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="bi bi-heart me-2"></i>Mis Favoritos
            </h1>
            
            <?php if (empty($data['wishlist'])): ?>
                <!-- Wishlist vacía -->
                <div class="text-center py-5">
                    <i class="bi bi-heart display-1 text-muted"></i>
                    <h3 class="mt-3">Tu lista de favoritos está vacía</h3>
                    <p class="text-muted">Añade productos que te gusten para verlos aquí</p>
                    <a href="/prueba-php/public/tienda" class="btn btn-primary">
                        <i class="bi bi-shop me-2"></i>Explorar Productos
                    </a>
                </div>
            <?php else: ?>
                <!-- Wishlist con productos -->
                <div class="row">
                    <?php foreach ($data['wishlist'] as $product): ?>
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                            <div class="card h-100 border-0 shadow-sm product-card">
                                <div class="position-relative">
                                    <?php if (!empty($product->imagen)): ?>
                                        <img src="/prueba-php/public/uploads/products/<?= htmlspecialchars($product->imagen) ?>" 
                                             class="card-img-top" 
                                             alt="<?= htmlspecialchars($product->nombre) ?>"
                                             style="height: 250px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 250px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Botón de eliminar de favoritos -->
                                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                                            onclick="removeFromWishlist(<?= $product->id ?>)" 
                                            title="Eliminar de favoritos">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                    
                                    <!-- Badge de favorito -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-danger">
                                            <i class="bi bi-heart-fill me-1"></i>Favorito
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($product->nombre) ?></h5>
                                        <small class="text-muted"><?= htmlspecialchars($product->categoria ?? 'General') ?></small>
                                    </div>
                                    
                                    <p class="card-text text-muted small flex-grow-1">
                                        <?= htmlspecialchars(substr($product->descripcion ?? 'Sin descripción', 0, 100)) ?>
                                        <?php if (strlen($product->descripcion ?? '') > 100): ?>...<?php endif; ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="h5 text-primary mb-0"><?= number_format($product->precio, 2) ?>€</span>
                                        </div>
                                        <div class="text-warning">
                                            <?php 
                                            $rating = $product->rating ?? 5;
                                            for ($i = 1; $i <= 5; $i++): 
                                            ?>
                                                <i class="bi bi-star<?= $i <= $rating ? '-fill' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <?php if ($product->stock > 0): ?>
                                            <button class="btn btn-primary flex-grow-1" onclick="addToCart(<?= $product->id ?>)">
                                                <i class="bi bi-cart-plus me-1"></i>Añadir al Carrito
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary flex-grow-1" disabled>
                                                <i class="bi bi-x-circle me-1"></i>Agotado
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-outline-primary" onclick="viewProduct(<?= $product->id ?>)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="bi bi-box me-1"></i>Stock: <?= $product->stock ?>
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>Añadido: <?= date('d/m/Y', strtotime($product->fecha_favorito)) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Acciones de la wishlist -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Gestionar Lista de Favoritos</h5>
                                <p class="card-text text-muted">
                                    Tienes <?= count($data['wishlist']) ?> producto<?= count($data['wishlist']) !== 1 ? 's' : '' ?> en tu lista de favoritos
                                </p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-outline-primary" onclick="addAllToCart()">
                                        <i class="bi bi-cart-plus me-2"></i>Añadir Todos al Carrito
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="clearWishlist()">
                                        <i class="bi bi-trash me-2"></i>Limpiar Lista
                                    </button>
                                    <a href="/prueba-php/public/tienda" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Seguir Explorando
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Añadir producto al carrito (reutilizar función de tienda)
function addToCart(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', 1);
    
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Añadiendo...';
    button.disabled = true;
    
    fetch('/prueba-php/public/cart/add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('success', data.message);
            button.innerHTML = '<i class="bi bi-check-circle me-1"></i>Añadido';
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
                button.disabled = false;
            }, 2000);
        } else {
            showMessage('error', data.message);
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'Error al añadir al carrito');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Eliminar de wishlist
function removeFromWishlist(productId) {
    if (confirm('¿Estás seguro de que quieres eliminar este producto de tus favoritos?')) {
        fetch('/prueba-php/public/order/remove-wishlist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', data.message);
                
                // Actualizar contador de favoritos en la navegación
                if (typeof updateWishlistCounter === 'function') {
                    updateWishlistCounter(data.wishlist_count || 0);
                }
                
                // Recargar página para actualizar la vista
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showMessage('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Error al eliminar de favoritos');
        });
    }
}

// Añadir todos al carrito
function addAllToCart() {
    const products = <?= json_encode(array_column($data['wishlist'], 'id')) ?>;
    
    if (products.length === 0) {
        showMessage('error', 'No hay productos en la lista de favoritos');
        return;
    }
    
    if (confirm(`¿Añadir ${products.length} productos al carrito?`)) {
        let added = 0;
        let errors = 0;
        
        products.forEach((productId, index) => {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            
            fetch('/prueba-php/public/cart/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    added++;
                } else {
                    errors++;
                }
                
                // Cuando se procesen todos los productos
                if (added + errors === products.length) {
                    if (added > 0) {
                        showMessage('success', `${added} productos añadidos al carrito`);
                    }
                    if (errors > 0) {
                        showMessage('error', `${errors} productos no se pudieron añadir`);
                    }
                }
            })
            .catch(error => {
                errors++;
                if (added + errors === products.length) {
                    showMessage('error', 'Error al añadir algunos productos');
                }
            });
        });
    }
}

// Limpiar wishlist
function clearWishlist() {
    if (confirm('¿Estás seguro de que quieres eliminar todos los productos de tus favoritos?')) {
        fetch('/prueba-php/public/order/clear-wishlist', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', data.message);
                
                // Actualizar contador de favoritos en la navegación
                if (typeof updateWishlistCounter === 'function') {
                    updateWishlistCounter(0);
                }
                
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showMessage('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Error al limpiar la lista de favoritos');
        });
    }
}

// Ver producto (placeholder)
function viewProduct(productId) {
    alert('Funcionalidad de vista de producto en desarrollo. ID: ' + productId);
}

// Mostrar mensajes
function showMessage(type, message) {
    let messageDiv = document.getElementById('wishlist-message');
    if (!messageDiv) {
        messageDiv = document.createElement('div');
        messageDiv.id = 'wishlist-message';
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
        `;
        document.body.appendChild(messageDiv);
    }
    
    if (type === 'success') {
        messageDiv.className = 'alert alert-success';
        messageDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span>${message}</span>
            </div>
        `;
    } else {
        messageDiv.className = 'alert alert-danger';
        messageDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span>${message}</span>
            </div>
        `;
    }
    
    setTimeout(() => {
        if (messageDiv) {
            messageDiv.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => {
                if (messageDiv && messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 300);
        }
    }, 3000);
}
</script>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>
