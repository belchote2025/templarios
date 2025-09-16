<?php
// Página de perfil del usuario
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <!-- Mensajes Flash -->
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash_message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
                ?>
            <?php endif; ?>

            <!-- Header del Perfil -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0" style="color: white;">
                        <i class="bi bi-person-circle me-2"></i>Mi Perfil
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <!-- Avatar del Usuario -->
                            <div class="avatar-container mb-3">
                                <img id="avatar-preview" 
                                     src="<?= !empty($user->avatar) ? 'public/uploads/avatars/' . $user->avatar : 'public/assets/images/default-avatar.png' ?>" 
                                     alt="Avatar" 
                                     class="rounded-circle border border-3 border-primary" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="mt-2">
                                    <input type="file" id="avatar-input" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('avatar-input').click()">
                                        <i class="bi bi-camera me-1"></i>Cambiar Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h5 class="text-primary mb-2"><?= htmlspecialchars($user->nombre . ' ' . $user->apellidos) ?></h5>
                            <p class="text-muted mb-1"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($user->email) ?></p>
                            <p class="text-muted mb-1"><i class="bi bi-person-badge me-2"></i><?= ucfirst($user->rol) ?></p>
                            <p class="text-muted mb-0"><i class="bi bi-calendar me-2"></i>Miembro desde <?= date('d/m/Y', strtotime($user->fecha_registro)) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Columna Izquierda - Información Personal -->
                <div class="col-md-6">
                    <!-- Editar Información Personal -->
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-person-lines-fill me-2"></i>Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/prueba-php/public/update-profile" id="profile-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre *</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                                   value="<?= htmlspecialchars($user->nombre) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">Apellidos *</label>
                                            <input type="text" class="form-control" id="apellidos" name="apellidos" 
                                                   value="<?= htmlspecialchars($user->apellidos) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars($user->email) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           value="<?= htmlspecialchars($user->telefono ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="direccion" name="direccion" rows="2"><?= htmlspecialchars($user->direccion ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Estadísticas del Usuario -->
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-graph-up me-2"></i>Estadísticas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-1"><?= date('Y') - date('Y', strtotime($user->fecha_registro)) ?></h4>
                                        <small class="text-muted">Años</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-success mb-1"><?= $user->activo ? 'Activo' : 'Inactivo' ?></h4>
                                        <small class="text-muted">Estado</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-info mb-1"><?= $user->rol === 'admin' ? 'Admin' : 'Usuario' ?></h4>
                                    <small class="text-muted">Rol</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Seguridad y Configuración -->
                <div class="col-md-6">
                    <!-- Cambiar Contraseña -->
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-shield-lock me-2"></i>Seguridad
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/prueba-php/public/change-password" id="password-form">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Contraseña Actual</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                            <i class="bi bi-eye" id="current_password_icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                            <i class="bi bi-eye" id="new_password_icon"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Mínimo 6 caracteres</div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                            <i class="bi bi-eye" id="confirm_password_icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-key me-2"></i>Cambiar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Configuraciones -->
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-gear me-2"></i>Configuraciones
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notifications" checked>
                                <label class="form-check-label" for="notifications">
                                    Recibir notificaciones por email
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="newsletter" checked>
                                <label class="form-check-label" for="newsletter">
                                    Suscribirse al boletín de noticias
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="public_profile">
                                <label class="form-check-label" for="public_profile">
                                    Perfil público visible
                                </label>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-save me-1"></i>Guardar Configuración
                            </button>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-lightning me-2"></i>Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="/prueba-php/public/socios" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-2"></i>Volver a Socios
                                </a>
                                <a href="/prueba-php/public/tienda" class="btn btn-outline-success">
                                    <i class="bi bi-shop me-2"></i>Ir a Tienda
                                </a>
                                <a href="/prueba-php/public/contacto" class="btn btn-outline-info">
                                    <i class="bi bi-envelope me-2"></i>Contactar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para mostrar/ocultar contraseñas
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '_icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

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

// Subida de avatar
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const formData = new FormData();
        formData.append('avatar', file);
        
        fetch('/prueba-php/public/upload-avatar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('avatar-preview').src = 'public/uploads/avatars/' + data.filename;
                showAlert('Avatar actualizado correctamente', 'success');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showAlert('Error al subir el avatar', 'error');
        });
    }
});

// Función para mostrar alertas
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Formularios con AJAX
document.getElementById('profile-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/prueba-php/public/update-profile', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        }
    })
    .catch(error => {
        showAlert('Error al actualizar el perfil', 'error');
    });
});

document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/prueba-php/public/change-password', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        }
    })
    .catch(error => {
        showAlert('Error al cambiar la contraseña', 'error');
    });
});
</script>