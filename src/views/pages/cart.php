<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-white">
                <i class="bi bi-cart3 me-2"></i>Carrito de Compras
            </h1>
            
            <?php if (empty($data['cart_items'])): ?>
                <!-- Carrito vacío -->
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h3 class="mt-3">Tu carrito está vacío</h3>
                    <p class="text-muted">Añade algunos productos para comenzar tu compra</p>
                    <a href="/prueba-php/public/tienda" class="btn btn-primary">
                        <i class="bi bi-shop me-2"></i>Ir a la Tienda
                    </a>
                </div>
            <?php else: ?>
                <!-- Carrito con productos -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white">Productos en tu carrito</h5>
                                <button class="btn btn-outline-danger btn-sm" onclick="clearCart()">
                                    <i class="bi bi-trash me-1"></i>Vaciar Carrito
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['cart_items'] as $item): ?>
                                                <tr id="cart-item-<?= $item['id'] ?>">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <?php if (!empty($item['imagen'])): ?>
                                                                <img src="/prueba-php/public/uploads/products/<?= htmlspecialchars($item['imagen']) ?>" 
                                                                     alt="<?= htmlspecialchars($item['nombre']) ?>" 
                                                                     class="img-thumbnail me-3" 
                                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                            <?php else: ?>
                                                                <div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                                     style="width: 60px; height: 60px; border-radius: 4px;">
                                                                    <i class="bi bi-image text-muted"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div>
                                                                <h6 class="mb-0"><?= htmlspecialchars($item['nombre']) ?></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold"><?= number_format($item['precio'], 2) ?>€</span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group" style="width: 120px;">
                                                            <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                                    onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                            <input type="number" class="form-control form-control-sm text-center" 
                                                                   value="<?= $item['quantity'] ?>" min="1" 
                                                                   onchange="updateQuantity(<?= $item['id'] ?>, this.value)">
                                                            <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                                    onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary">
                                                            <?= number_format($item['precio'] * $item['quantity'], 2) ?>€
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-danger btn-sm" 
                                                                onclick="removeFromCart(<?= $item['id'] ?>)"
                                                                title="Eliminar del carrito">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-white">Resumen del Pedido</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Productos (<?= $data['cart_count'] ?>):</span>
                                    <span><?= number_format($data['cart_total'], 2) ?>€</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Envío:</span>
                                    <span class="text-success">Gratis</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-primary"><?= number_format($data['cart_total'], 2) ?>€</strong>
                                </div>
                                
                                <button class="btn btn-success w-100 mb-2" onclick="proceedToCheckout()">
                                    <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                                </button>
                                
                                <a href="/prueba-php/public/tienda" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
                                </a>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6 class="card-title text-white">
                                    <i class="bi bi-shield-check text-success me-2"></i>Compra Segura
                                </h6>
                                <p class="card-text small text-muted">
                                    Tus datos están protegidos con encriptación SSL. 
                                    Procesamos pagos de forma segura.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Función para actualizar cantidad
function updateQuantity(productId, quantity) {
    if (quantity < 1) {
        removeFromCart(productId);
        return;
    }
    
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    
    fetch('/prueba-php/public/cart/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar página para actualizar vista
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el carrito');
    });
}

// Función para eliminar producto del carrito
function removeFromCart(productId) {
    if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
        const formData = new FormData();
        formData.append('product_id', productId);
        
        fetch('/prueba-php/public/cart/remove', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Eliminar fila de la tabla
                const row = document.getElementById('cart-item-' + productId);
                if (row) {
                    row.remove();
                }
                
                // Actualizar contador del carrito en la navegación
                if (typeof updateCartCounter === 'function') {
                    updateCartCounter(data.cart_count);
                }
                
                // Si el carrito está vacío, recargar página
                if (data.cart_count === 0) {
                    window.location.reload();
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar del carrito');
        });
    }
}

// Función para vaciar carrito
function clearCart() {
    if (confirm('¿Estás seguro de que quieres vaciar todo el carrito?')) {
        fetch('/prueba-php/public/cart/clear', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al vaciar el carrito');
        });
    }
}

// Función para proceder al pago
function proceedToCheckout() {
    window.location.href = '/prueba-php/public/order/checkout';
}

</script>
