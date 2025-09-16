<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Mi Perfil
                    </h4>
                </div>
                <div class="card-body">
                    
                    <!-- Mostrar mensajes flash -->
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash_type'] ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['flash_message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php 
                        unset($_SESSION['flash_message']);
                        unset($_SESSION['flash_type']);
                        ?>
                    <?php endif; ?>
                    
                    <!-- Información del usuario -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Información Personal</h6>
                            <p><strong>Nombre:</strong> <?= htmlspecialchars($data['user']->nombre . ' ' . $data['user']->apellidos) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($data['user']->email) ?></p>
                            <p><strong>Rol:</strong> <span class="badge bg-primary"><?= ucfirst($data['user']->rol) ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Información de Cuenta</h6>
                            <p><strong>Fecha de Registro:</strong> <?= date('d/m/Y', strtotime($data['user']->fecha_registro)) ?></p>
                            <p><strong>Último Acceso:</strong> <?= date('d/m/Y H:i', strtotime($data['user']->ultimo_acceso)) ?></p>
                            <?php if (!empty($data['user']->temp_password)): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-key me-2"></i>
                                    <strong>Contraseña Temporal Activa</strong><br>
                                    <small>Debes cambiar tu contraseña temporal por una personal.</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Formulario de cambio de contraseña -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-lock me-2"></i>Cambiar Contraseña
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/prueba-php/public/profile/change-password">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Contraseña Actual</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                                            <div class="form-text">Mínimo 6 caracteres</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Cambiar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mt-4">
                        <h6>Información Importante</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-info-circle text-info me-2"></i>Tu contraseña debe tener al menos 6 caracteres</li>
                            <li><i class="fas fa-shield-alt text-success me-2"></i>Al cambiar tu contraseña, se eliminará cualquier contraseña temporal</li>
                            <li><i class="fas fa-user-shield text-warning me-2"></i>Mantén tu contraseña segura y no la compartas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validación de contraseñas en tiempo real
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
