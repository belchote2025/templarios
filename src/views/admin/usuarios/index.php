<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Usuarios</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/prueba-php/public/admin/crearUsuario" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Usuario
        </a>
    </div>
</div>

<?php if (!empty($data['users'])): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Último Acceso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td>#<?= $user->id ?></td>
                        <td><?= htmlspecialchars($user->nombre . ' ' . $user->apellidos) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td>
                            <span class="badge bg-<?= $user->rol === 'admin' ? 'primary' : 'secondary' ?>">
                                <?= ucfirst($user->rol) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?= $user->activo ? 'success' : 'danger' ?>">
                                <?= $user->activo ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <?= $user->ultimo_acceso ? date('d/m/Y H:i', strtotime($user->ultimo_acceso)) : 'Nunca' ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/prueba-php/public/admin/editarUsuario/<?= $user->id ?>" class="btn btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-<?= $user->activo ? 'warning' : 'success' ?>" 
                                        onclick="toggleUserStatus(<?= $user->id ?>, <?= $user->activo ? 0 : 1 ?>, '<?= htmlspecialchars($user->nombre) ?>')"
                                        title="<?= $user->activo ? 'Desactivar' : 'Activar' ?>">
                                    <i class="fas fa-<?= $user->activo ? 'ban' : 'check' ?>"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete('usuario', <?= $user->id ?>, '<?= htmlspecialchars($user->nombre) ?>')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($data['totalPages'] > 1): ?>
        <nav aria-label="Paginación de usuarios">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $data['currentPage'] <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="/prueba-php/public/admin/usuarios/<?= $data['currentPage'] - 1 ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                    <li class="page-item <?= $i == $data['currentPage'] ? 'active' : '' ?>">
                        <a class="page-link" href="/prueba-php/public/admin/usuarios/<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $data['currentPage'] >= $data['totalPages'] ? 'disabled' : '' ?>">
                    <a class="page-link" href="/prueba-php/public/admin/usuarios/<?= $data['currentPage'] + 1 ?>" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
    
<?php else: ?>
    <div class="alert alert-info">
        No hay usuarios registrados en el sistema.
    </div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este <span id="entityType">usuario</span>? <br>
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
function confirmDelete(type, id, name) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('entityType').textContent = type;
    document.getElementById('entityName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/${type}s/eliminar/${id}`;
    modal.show();
}

function toggleUserStatus(userId, newStatus, userName) {
    const action = newStatus ? 'activar' : 'desactivar';
    const confirmMessage = `¿Estás seguro de que deseas ${action} al usuario "${userName}"?`;
    
    if (confirm(confirmMessage)) {
        // Mostrar indicador de carga
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Crear el token CSRF
        const csrfToken = '<?= generateCsrfToken() ?>';
        
        // Realizar la petición AJAX
        fetch(`/prueba-php/public/admin/toggleUserStatus/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                status: newStatus,
                csrf_token: csrfToken
            })
        })
        .then(response => response.json())
        .then(data => {
            // Restaurar el botón
            button.innerHTML = originalContent;
            button.disabled = false;
            
            if (data.success) {
                // Mostrar toast de éxito
                showToast('success', `Usuario ${action}do correctamente`);
                
                // Recargar la página para mostrar los cambios
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                // Mostrar toast de error
                showToast('error', data.message || `Error al ${action} el usuario`);
            }
        })
        .catch(error => {
            // Restaurar el botón
            button.innerHTML = originalContent;
            button.disabled = false;
            
            // Mostrar toast de error
            showToast('error', 'Error de conexión. Inténtalo de nuevo.');
            console.error('Error:', error);
        });
    }
}

function showToast(type, message) {
    // Crear el toast si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Crear el toast
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Mostrar el toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
    });
    toast.show();
    
    // Eliminar el toast del DOM después de que se oculte
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}
</script>
