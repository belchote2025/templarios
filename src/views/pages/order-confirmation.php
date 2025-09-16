<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">
                        <i class="bi bi-check-circle me-2"></i>¡Pedido Confirmado!
                    </h2>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="text-success mb-3">Gracias por tu compra</h3>
                    
                    <p class="lead mb-4">
                        Tu pedido ha sido procesado correctamente y hemos enviado un correo de confirmación a tu dirección de email.
                    </p>
                    
                    <div class="alert alert-info">
                        <h5 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>Información del Pedido
                        </h5>
                        <p class="mb-0">
                            <strong>Número de Pedido:</strong> #<?= $data['pedido_id'] ?><br>
                            <strong>Fecha:</strong> <?= date('d/m/Y H:i') ?><br>
                            <strong>Estado:</strong> <span class="badge bg-warning">Procesando</span>
                        </p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-envelope me-2"></i>Correo de Confirmación
                                    </h5>
                                    <p class="card-text">
                                        Hemos enviado todos los detalles de tu pedido a tu dirección de email.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-truck me-2"></i>Envío
                                    </h5>
                                    <p class="card-text">
                                        Procesaremos tu pedido en las próximas 24-48 horas y te notificaremos cuando sea enviado.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/prueba-php/public/tienda" class="btn btn-primary me-3">
                            <i class="bi bi-shop me-2"></i>Seguir Comprando
                        </a>
                        <a href="/prueba-php/public/" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i>Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
