<?php 
// Función simple para generar CSRF token
if (!function_exists('generateCsrfToken')) {
    function generateCsrfToken() {
        return bin2hex(random_bytes(32));
    }
}

// Set default values if not provided
$user = (object) array_merge([
    'id' => '',
    'nombre' => '',
    'apellidos' => '',
    'email' => '',
    'rol' => 'user',
    'activo' => 1
], (array)($data ?? []));

$isNew = empty($user->id);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $isNew ? 'Nuevo Usuario' : 'Editar Usuario' ?></h1>
</div>

<?php if (!empty($data['errors']['general'])): ?>
    <div class="alert alert-danger">
        <?= $data['errors']['general'] ?>
    </div>
<?php endif; ?>

<form method="POST" action="/prueba-php/public/admin/editarUsuario/<?= $user->id ?>">
    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
    <input type="hidden" name="user_id" value="<?= $user->id ?>">
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= !empty($data['errors']['nombre']) ? 'is-invalid' : '' ?>" 
                       id="nombre" name="nombre" value="<?= htmlspecialchars($user->nombre) ?>" required>
                <?php if (!empty($data['errors']['nombre'])): ?>
                    <div class="invalid-feedback">
                        <?= $data['errors']['nombre'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" 
                       value="<?= htmlspecialchars($user->apellidos) ?>">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control <?= !empty($data['errors']['email']) ? 'is-invalid' : '' ?>" 
               id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required 
               <?= !$isNew ? 'readonly' : '' ?>>
        <?php if (!empty($data['errors']['email'])): ?>
            <div class="invalid-feedback">
                <?= $data['errors']['email'] ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password" class="form-label">
                    Contraseña <?= $isNew ? '<span class="text-danger">*</span>' : '' ?>
                </label>
                <div class="input-group">
                    <input type="password" class="form-control <?= !empty($data['errors']['password']) ? 'is-invalid' : '' ?>" 
                           id="password" name="password" <?= $isNew ? 'required' : '' ?>>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                    <?php if (!empty($data['errors']['password'])): ?>
                        <div class="invalid-feedback">
                            <?= $data['errors']['password'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!$isNew): ?>
                    <div class="form-text">Dejar en blanco para mantener la contraseña actual</div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="confirm_password" class="form-label">
                    Confirmar Contraseña <?= $isNew ? '<span class="text-danger">*</span>' : '' ?>
                </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                       <?= $isNew ? 'required' : '' ?>>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol">
                    <option value="user" <?= $user->rol === 'user' ? 'selected' : '' ?>>Usuario</option>
                    <option value="socio" <?= $user->rol === 'socio' ? 'selected' : '' ?>>Socio</option>
                    <option value="admin" <?= $user->rol === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" 
                           value="1" <?= ($user->activo == 1 || $user->activo === true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="activo">
                        <?= ($user->activo == 1 || $user->activo === true) ? 'Activo' : 'Inactivo' ?>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
        <a href="/prueba-php/public/admin/usuarios" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        
        <div>
            <?php if (!$isNew): ?>
                <button type="button" class="btn btn-danger me-2" 
                        onclick="confirmDelete(<?= $user->id ?>, '<?= htmlspecialchars($user->nombre) ?>')">
                    <i class="fas fa-trash me-1"></i> Eliminar
                </button>
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </div>
</form>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este usuario? <br>
                <strong id="entityName"></strong>
                <p class="text-danger mt-2">¡Esta acción no se puede deshacer!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    // Only validate password if it's a new user or password is being changed
    if (password && (password.required || password.value)) {
        if (password.value.length < 8) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 8 caracteres');
            password.focus();
            return false;
        }
        
        if (confirmPassword && password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Las contraseñas no coinciden');
            confirmPassword.focus();
            return false;
        }
    }
    
    // Log form data for debugging
    console.log('Formulario enviado - Rol seleccionado:', document.getElementById('rol').value);
    console.log('Formulario enviado - Activo:', document.getElementById('activo').checked);
});

// Add event listener for role changes
document.getElementById('rol').addEventListener('change', function(e) {
    console.log('Rol cambiado a:', e.target.value);
    console.log('Valor anterior:', this.dataset.previousValue || 'N/A');
    this.dataset.previousValue = e.target.value;
});

// Add event listener for active status changes
document.getElementById('activo').addEventListener('change', function(e) {
    console.log('Estado activo cambiado a:', e.target.checked);
});

// Initialize previous values
document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('rol');
    const activoCheckbox = document.getElementById('activo');
    
    if (rolSelect) {
        rolSelect.dataset.previousValue = rolSelect.value;
        console.log('Rol inicial:', rolSelect.value);
    }
    
    if (activoCheckbox) {
        console.log('Estado activo inicial:', activoCheckbox.checked);
    }
    
    console.log('Formulario de edición inicializado');
});

// Delete confirmation
function confirmDelete(id, name) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('entityName').textContent = name;
    document.getElementById('deleteForm').action = `/prueba-php/public/admin/eliminarUsuario/${id}`;
    modal.show();
}
</script>
