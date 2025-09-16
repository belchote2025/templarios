<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="bi bi-credit-card me-2"></i>Finalizar Compra
            </h1>
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Formulario de Checkout -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-person me-2"></i>Información de Envío
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="checkoutForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre *</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                                   value="<?= htmlspecialchars($data['user']['nombre'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">Apellidos *</label>
                                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= htmlspecialchars($data['user']['email'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                                   value="<?= htmlspecialchars($data['user']['telefono'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección *</label>
                                    <textarea class="form-control" id="direccion" name="direccion" rows="2" required></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="ciudad" class="form-label">Ciudad *</label>
                                            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="codigo_postal" class="form-label">Código Postal *</label>
                                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="provincia" class="form-label">Provincia *</label>
                                            <input type="text" class="form-control" id="provincia" name="provincia" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Cupón de Descuento -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h6 class="mb-0 text-white">
                                            <i class="bi bi-ticket-perforated me-2"></i>Cupón de Descuento
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="cupon" name="cupon" 
                                                       placeholder="Introduce tu código de cupón">
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary w-100" onclick="validateCoupon()">
                                                    Aplicar
                                                </button>
                                            </div>
                                        </div>
                                        <div id="cupon-message" class="mt-2"></div>
                                    </div>
                                </div>
                                
                                <!-- Método de Pago -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h6 class="mb-0 text-white">
                                            <i class="bi bi-credit-card me-2"></i>Método de Pago
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                                    <label class="form-check-label" for="tarjeta">
                                                        <i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                                    <label class="form-check-label" for="paypal">
                                                        <i class="bi bi-paypal me-2"></i>PayPal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                                    <label class="form-check-label" for="transferencia">
                                                        <i class="bi bi-bank me-2"></i>Transferencia
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_pago" id="contra_entrega" value="contra_entrega">
                                                    <label class="form-check-label" for="contra_entrega">
                                                        <i class="bi bi-truck me-2"></i>Contra Entrega
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Notas -->
                                <div class="mb-3 mt-4">
                                    <label for="notas" class="form-label">Notas adicionales (opcional)</label>
                                    <textarea class="form-control" id="notas" name="notas" rows="3" 
                                              placeholder="Instrucciones especiales para la entrega..."></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="/prueba-php/public/cart" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Volver al Carrito
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Finalizar Pedido
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Resumen del Pedido -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-receipt me-2"></i>Resumen del Pedido
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Productos -->
                            <?php foreach ($data['cart_items'] as $item): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($item['imagen'])): ?>
                                            <img src="/prueba-php/public/uploads/products/<?= htmlspecialchars($item['imagen']) ?>" 
                                                 alt="<?= htmlspecialchars($item['nombre']) ?>" 
                                                 class="img-thumbnail me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div>
                                            <small class="fw-bold"><?= htmlspecialchars($item['nombre']) ?></small>
                                            <br><small class="text-muted">Cantidad: <?= $item['quantity'] ?></small>
                                        </div>
                                    </div>
                                    <small class="fw-bold"><?= number_format($item['precio'] * $item['quantity'], 2) ?>€</small>
                                </div>
                            <?php endforeach; ?>
                            
                            <hr>
                            
                            <!-- Totales -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal"><?= number_format($data['cart_total'], 2) ?>€</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Descuento:</span>
                                <span id="descuento" class="text-success">0.00€</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Envío:</span>
                                <span id="envio"><?= $data['cart_total'] >= 50 ? 'Gratis' : '5.99€' ?></span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong class="text-primary" id="total"><?= number_format($data['cart_total'] + ($data['cart_total'] >= 50 ? 0 : 5.99), 2) ?>€</strong>
                            </div>
                            
                            <!-- Información de Seguridad -->
                            <div class="alert alert-info small">
                                <i class="bi bi-shield-check me-2"></i>
                                <strong>Compra Segura:</strong> Tus datos están protegidos con encriptación SSL.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let appliedCoupon = null;

// Validar cupón
function validateCoupon() {
    const codigo = document.getElementById('cupon').value.trim();
    const total = <?= $data['cart_total'] ?>;
    
    if (!codigo) {
        showCouponMessage('error', 'Introduce un código de cupón');
        return;
    }
    
    const formData = new FormData();
    formData.append('codigo', codigo);
    formData.append('total', total);
    
    fetch('/prueba-php/public/order/validate-coupon', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            appliedCoupon = data.cupon;
            showCouponMessage('success', data.message);
            updateTotals(data.descuento);
        } else {
            appliedCoupon = null;
            showCouponMessage('error', data.message);
            updateTotals(0);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showCouponMessage('error', 'Error al validar el cupón');
    });
}

// Mostrar mensaje del cupón
function showCouponMessage(type, message) {
    const messageDiv = document.getElementById('cupon-message');
    if (type === 'success') {
        messageDiv.className = 'mt-2 alert alert-success';
        messageDiv.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
    } else {
        messageDiv.className = 'mt-2 alert alert-danger';
        messageDiv.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>${message}`;
    }
}

// Actualizar totales
function updateTotals(descuento) {
    const subtotal = <?= $data['cart_total'] ?>;
    const envio = subtotal >= 50 ? 0 : 5.99;
    const total = subtotal - descuento + envio;
    
    document.getElementById('descuento').textContent = descuento.toFixed(2) + '€';
    document.getElementById('envio').textContent = envio === 0 ? 'Gratis' : envio.toFixed(2) + '€';
    document.getElementById('total').textContent = total.toFixed(2) + '€';
}

// Procesar pedido
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    if (appliedCoupon) {
        formData.append('cupon', appliedCoupon.codigo);
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Procesando...';
    submitBtn.disabled = true;
    
    fetch('/prueba-php/public/order/process', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.payment_required) {
                // Procesar pago según el método seleccionado
                processPayment(data.pedido_id, data.total, data.payment_method, formData);
            } else {
                // Mostrar mensaje de éxito
                alert('¡Pedido procesado correctamente! ID: ' + data.pedido_id);
                
                // Redirigir a página de confirmación
                window.location.href = '/prueba-php/public/order/confirmation/' + data.pedido_id;
            }
        } else {
            alert('Error: ' + data.message);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar el pedido');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Procesar pago según el método seleccionado
function processPayment(pedido_id, total, payment_method, formData) {
    const email = formData.get('email');
    
    switch (payment_method) {
        case 'tarjeta':
            processStripePayment(pedido_id, total, email);
            break;
        case 'paypal':
            processPayPalPayment(pedido_id, total, email);
            break;
        case 'transferencia':
            processBankTransfer(pedido_id, email);
            break;
        case 'contra_entrega':
            // Para contra entrega, no se requiere pago online
            alert('¡Pedido confirmado! Te contactaremos para coordinar la entrega y el pago.');
            window.location.href = '/prueba-php/public/order/confirmation/' + pedido_id;
            break;
        default:
            alert('Método de pago no válido');
    }
}

// Procesar pago con Stripe
function processStripePayment(pedido_id, total, email) {
    // Simular token de Stripe (en producción se obtendría del frontend de Stripe)
    const stripe_token = 'tok_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    const paymentData = {
        stripe_token: stripe_token,
        amount: total,
        email: email,
        pedido_id: pedido_id
    };
    
    fetch('/prueba-php/public/payment/stripe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(paymentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Pago procesado correctamente! ID de transacción: ' + data.transaction_id);
            window.location.href = '/prueba-php/public/order/confirmation/' + pedido_id;
        } else {
            alert('Error en el pago: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar el pago');
    });
}

// Procesar pago con PayPal
function processPayPalPayment(pedido_id, total, email) {
    const paymentData = {
        amount: total,
        email: email,
        pedido_id: pedido_id
    };
    
    fetch('/prueba-php/public/payment/paypal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(paymentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.redirect_url) {
                // Redirigir a PayPal
                window.location.href = data.redirect_url;
            } else {
                alert('¡Pago procesado correctamente! ID de transacción: ' + data.transaction_id);
                window.location.href = '/prueba-php/public/order/confirmation/' + pedido_id;
            }
        } else {
            alert('Error en el pago: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar el pago');
    });
}

// Procesar transferencia bancaria
function processBankTransfer(pedido_id, email) {
    const paymentData = {
        pedido_id: pedido_id,
        email: email
    };
    
    fetch('/prueba-php/public/payment/bank-transfer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(paymentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Instrucciones de transferencia enviadas por correo! Revisa tu email para completar el pago.');
            window.location.href = '/prueba-php/public/order/confirmation/' + pedido_id;
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la transferencia');
    });
}
</script>
