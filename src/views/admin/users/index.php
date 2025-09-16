<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Filá Mariscales</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-group .btn { margin-right: 2px; }
        
        /* Estilos para botones con texto */
        .btn-group .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            white-space: nowrap;
        }
        
        /* Asegurar que los botones de grupo tengan el mismo tamaño */
        .btn-group .btn {
            flex: 1;
            min-width: 0;
        }
        
        /* Espaciado entre icono y texto */
        .btn i {
            margin-right: 0.25rem;
        }
        
        /* Estilos para botones de acciones */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }
        
        .action-btn {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            min-width: auto;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .action-btn:active {
            transform: translateY(0);
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-edit:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            color: white;
        }
        
        .btn-activate {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            color: white;
        }
        
        .btn-activate:hover {
            background: linear-gradient(135deg, #4a9a1f 0%, #98d6bf 100%);
            color: white;
        }
        
        .btn-deactivate {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa8a8 100%);
            color: white;
        }
        
        .btn-deactivate:hover {
            background: linear-gradient(135deg, #ff5555 0%, #ff9898 100%);
            color: white;
        }
        
        .btn-password {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .btn-password:hover {
            background: linear-gradient(135deg, #ee85eb 0%, #f4475c 100%);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #ff2b5c 0%, #ff3b1b 100%);
            color: white;
        }
        
        /* Responsive para botones */
        @media (max-width: 1200px) {
            .action-btn span {
                display: none;
            }
            
            .action-btn {
                padding: 8px;
                min-width: 36px;
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 2px;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
                padding: 8px 12px;
                font-size: 0.85rem;
            }
            
            .action-btn span {
                display: inline;
            }
        }
        
        /* Modal personalizado */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .custom-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border: 1px solid #888;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .custom-modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .custom-modal-body {
            padding: 20px;
        }
        
        .custom-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
        }
        
        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <?php
    // Función simple para generar CSRF token
    if (!function_exists('generateCsrfToken')) {
        function generateCsrfToken() {
            return bin2hex(random_bytes(32));
        }
    }
    ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/prueba-php/public/admin/dashboard">
                <i class="fas fa-shield-alt me-2"></i>Panel de Administración
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/prueba-php/public/admin/dashboard">Dashboard</a>
                <a class="nav-link active" href="/prueba-php/public/admin/usuarios">Usuarios</a>
                <a class="nav-link" href="/prueba-php/public/admin/galeria">Galería</a>
                <a class="nav-link" href="/prueba-php/public/admin/logout">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Gestión de Usuarios</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="/prueba-php/public/admin/crearUsuario" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Usuario
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card" data-aos="fade-up">
            <div class="card-header">
                <h5 class="mb-0 text-white">Lista de Usuarios</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['users'])): ?>
                                <?php foreach ($data['users'] as $user): ?>
                                    <tr>
                                        <td><?= $user->id ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($user->nombre . ' ' . $user->apellidos) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($user->email) ?></td>
                                        <td>
                                            <?php if (!empty($user->password_plain)): ?>
                                                <code class="password-display" style="background: #f8f9fa; padding: 2px 6px; border-radius: 3px; font-size: 0.85em; color: #495057;">
                                                    <?= htmlspecialchars($user->password_plain) ?>
                                                </code>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $user->rol === 'admin' ? 'danger' : ($user->rol === 'socio' ? 'primary' : 'secondary') ?>">
                                                <?= ucfirst($user->rol) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($user->activo): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                                                                 <td><?= date('d/m/Y H:i', strtotime($user->fecha_registro)) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <!-- Botón Editar -->
                                                <button type="button" 
                                                        class="action-btn btn-edit" 
                                                        onclick="openEditModal(<?= $user->id ?>, '<?= htmlspecialchars($user->nombre) ?>', '<?= htmlspecialchars($user->apellidos) ?>', '<?= htmlspecialchars($user->email) ?>', '<?= $user->rol ?>', <?= $user->activo ? 'true' : 'false' ?>)"
                                                        title="Editar usuario">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Editar</span>
                                                </button>
                                                
                                                <!-- Botón Activar/Desactivar -->
                                                <?php if ($user->activo): ?>
                                                    <button type="button" 
                                                            class="action-btn btn-deactivate"
                                                            onclick="toggleUserStatus(<?= $user->id ?>, 'desactivar')"
                                                            title="Desactivar usuario">
                                                        <i class="fas fa-user-slash"></i>
                                                        <span>Desactivar</span>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" 
                                                            class="action-btn btn-activate"
                                                            onclick="toggleUserStatus(<?= $user->id ?>, 'activar')"
                                                            title="Activar usuario">
                                                        <i class="fas fa-user-check"></i>
                                                        <span>Activar</span>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <!-- Botón Cambiar Contraseña -->
                                                <button type="button" 
                                                        class="action-btn btn-password"
                                                        onclick="openResetModal(<?= $user->id ?>)"
                                                        title="Cambiar contraseña">
                                                    <i class="fas fa-key"></i>
                                                    <span>Contraseña</span>
                                                </button>
                                                
                                                <!-- Botón Eliminar -->
                                                <button type="button" 
                                                        class="action-btn btn-delete"
                                                        onclick="deleteUser(<?= $user->id ?>)"
                                                        title="Eliminar usuario">
                                                    <i class="fas fa-trash"></i>
                                                    <span>Eliminar</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay usuarios registrados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Mensaje de confirmación -->
        <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>¡Éxito!</strong> El usuario ha sido actualizado correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <!-- Botón de recarga manual -->
        <div class="text-center mt-3" data-aos="fade-up" data-aos-delay="200">
            <button type="button" class="btn btn-outline-secondary" onclick="forceRefresh()">
                <i class="fas fa-sync-alt me-2"></i>Recargar Lista
            </button>
            <button type="button" class="btn btn-outline-primary ms-2" onclick="refreshFromServer()">
                <i class="fas fa-database me-2"></i>Recargar desde Servidor
            </button>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editUserForm" method="POST">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <input type="hidden" id="editUserId" name="user_id" value="">
                <div class="custom-modal-body">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editApellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="editApellidos" name="apellidos">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRol" class="form-label">Rol</label>
                        <select class="form-select" id="editRol" name="rol">
                            <option value="user">Usuario</option>
                            <option value="socio">Socio</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editActivo" name="activo" value="1">
                        <label class="form-check-label" for="editActivo">
                            Usuario activo
                        </label>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="action-btn btn-deactivate" onclick="closeEditModal()">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </button>
                    <button type="submit" class="action-btn btn-edit">
                        <i class="fas fa-save"></i>
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="close" onclick="closeResetModal()">&times;</button>
            </div>
            <form id="resetPasswordForm" method="POST">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <div class="custom-modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-key me-2"></i>
                        <strong>Cambiar Contraseña</strong>
                    </div>
                    <p>Escribe la nueva contraseña para este usuario:</p>
                    
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="new_password" minlength="6" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Mínimo 6 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmNewPassword" name="confirm_password" minlength="6" required>
                        <div class="invalid-feedback" id="passwordMismatch" style="display: none;">
                            Las contraseñas no coinciden
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Importante:</strong> Esta contraseña será definitiva. El usuario podrá usarla inmediatamente.
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="action-btn btn-deactivate" onclick="closeResetModal()">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </button>
                    <button type="submit" class="action-btn btn-password">
                        <i class="fas fa-key"></i>
                        <span>Cambiar Contraseña</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
    // Variables globales
    let currentUserId;

    // Función para abrir modal de edición
    function openEditModal(userId, nombre, apellidos, email, rol, activo) {
        console.log('🚪 Abriendo modal de edición para usuario:', userId);
        console.log('📊 Datos del usuario:', { userId, nombre, apellidos, email, rol, activo });
        
        // Guardar el ID del usuario actual
        currentUserId = userId;
        console.log('💾 ID del usuario guardado:', currentUserId);
        
        // Llenar el formulario
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editApellidos').value = apellidos;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRol').value = rol;
        document.getElementById('editActivo').checked = activo;
        console.log('📝 Formulario llenado con datos del usuario');
        
        // Actualizar la acción del formulario
        const formAction = '/prueba-php/public/admin/editarUsuario/' + userId;
        document.getElementById('editUserForm').action = formAction;
        console.log('🔗 Form action set to:', formAction);
        
        // Agregar campo oculto con el ID del usuario
        let userIdField = document.getElementById('editUserId');
        if (!userIdField) {
            userIdField = document.createElement('input');
            userIdField.type = 'hidden';
            userIdField.id = 'editUserId';
            userIdField.name = 'user_id';
            document.getElementById('editUserForm').appendChild(userIdField);
        }
        userIdField.value = userId;
        
        // Mostrar el modal
        document.getElementById('editUserModal').style.display = 'block';
        console.log('👁️ Modal mostrado');
    }

    // Función para cerrar modal de edición
    function closeEditModal() {
        document.getElementById('editUserModal').style.display = 'none';
    }

    // Función para abrir modal de resetear contraseña
    function openResetModal(userId) {
        console.log('Abriendo modal de reset para usuario:', userId);
        
        // Actualizar la acción del formulario
        document.getElementById('resetPasswordForm').action = '/prueba-php/public/admin/resetearPassword/' + userId;
        
        // Limpiar campos del formulario
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmNewPassword').value = '';
        document.getElementById('passwordMismatch').style.display = 'none';
        document.getElementById('confirmNewPassword').classList.remove('is-invalid');
        
        // Mostrar el modal
        document.getElementById('resetPasswordModal').style.display = 'block';
        
        // Inicializar validaciones
        validatePasswords();
        togglePasswordVisibility();
    }

    // Función para cerrar modal de resetear contraseña
    function closeResetModal() {
        document.getElementById('resetPasswordModal').style.display = 'none';
    }

    // Función para activar/desactivar usuario
    function toggleUserStatus(userId, action) {
        const message = action === 'activar' ? 
            '¿Estás seguro de activar este usuario?' : 
            '¿Estás seguro de desactivar este usuario?';
            
        if (confirm(message)) {
            const url = action === 'activar' ? 
                '/prueba-php/public/admin/activarUsuario/' + userId :
                '/prueba-php/public/admin/desactivarUsuario/' + userId;
                
            // Crear formulario temporal y enviarlo
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?= generateCsrfToken() ?>';
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Función para eliminar usuario
    function deleteUser(userId) {
        if (confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')) {
            // Crear formulario temporal y enviarlo
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/prueba-php/public/admin/eliminarUsuario/' + userId;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?= generateCsrfToken() ?>';
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Event listener para el formulario de edición
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        console.log('🚀 Formulario de edición enviado');
        console.log('📍 Form action:', this.action);
        console.log('👤 Usuario ID:', currentUserId);
        
        // Log form values
        const formData = new FormData(this);
        console.log('📋 Datos del formulario:');
        for (let [key, value] of formData.entries()) {
            console.log('  - ' + key + ': ' + value);
        }
        
        // Verificar que el rol se está enviando correctamente
        const rolValue = document.getElementById('editRol').value;
        console.log('🎭 Rol seleccionado:', rolValue);
        
        // Verificar que el campo activo se esté enviando
        const activoValue = document.getElementById('editActivo').checked ? '1' : '0';
        console.log('✅ Campo activo:', activoValue);
        
        console.log('📤 Enviando formulario...');
        // No prevenir el envío por defecto, dejar que se envíe normalmente
    });

    // Cerrar modales al hacer clic fuera de ellos
    window.onclick = function(event) {
        const editModal = document.getElementById('editUserModal');
        const resetModal = document.getElementById('resetPasswordModal');
        
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === resetModal) {
            closeResetModal();
        }
    };

    // Función para forzar recarga completa
    function forceRefresh() {
        console.log('Forzando recarga completa...');
        // Agregar timestamp para evitar caché
        const timestamp = new Date().getTime();
        const currentUrl = window.location.href.split('?')[0];
        window.location.href = currentUrl + '?t=' + timestamp + '&force=1';
    }
    
    // Función para recargar desde servidor
    function refreshFromServer() {
        console.log('Recargando desde servidor...');
        // Hacer petición AJAX para obtener datos frescos
        fetch(window.location.href + '?ajax=1&t=' + new Date().getTime())
            .then(response => response.text())
            .then(html => {
                // Extraer solo la tabla de usuarios
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('.table-responsive');
                const currentTable = document.querySelector('.table-responsive');
                
                if (newTable && currentTable) {
                    currentTable.innerHTML = newTable.innerHTML;
                    console.log('Tabla actualizada desde servidor');
                    
                    // Mostrar mensaje de éxito
                    showMessage('✅ Lista actualizada desde el servidor', 'success');
                }
            })
            .catch(error => {
                console.error('Error al recargar:', error);
                showMessage('❌ Error al recargar desde servidor', 'danger');
            });
    }
    
    // Función para mostrar mensajes
    function showMessage(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insertar después de la tabla
        const tableCard = document.querySelector('.card');
        tableCard.parentNode.insertBefore(alertDiv, tableCard.nextSibling);
        
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎉 Página de usuarios cargada correctamente');
        console.log('🔍 Verificando elementos del formulario...');
        
        // Verificar que el formulario existe
        const editForm = document.getElementById('editUserForm');
        if (editForm) {
            console.log('✅ Formulario de edición encontrado');
            console.log('📍 Form action actual:', editForm.action);
        } else {
            console.error('❌ Formulario de edición NO encontrado');
        }
        
        // Inicializar AOS
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            console.log('AOS inicializado correctamente');
        } else {
            console.warn('AOS no está disponible');
        }
        
        // Event listener para el formulario de resetear contraseña
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            console.log('Reseteando contraseña...');
        });
        
        // Verificar si hay parámetros de actualización en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('updated')) {
            showMessage('✅ Usuario actualizado correctamente', 'success');
        }
        
        // Forzar recarga si se solicita
        if (urlParams.get('force')) {
            console.log('Recarga forzada solicitada');
            // Limpiar parámetros de la URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
    
    // Función para limpiar contraseña temporal
    function clearTempPassword(userId) {
        if (confirm('¿Estás seguro de que quieres limpiar la contraseña temporal de este usuario?')) {
            // Crear formulario para enviar la petición
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/prueba-php/public/admin/clearTempPassword/' + userId;
            
            // Agregar token CSRF
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?= generateCsrfToken() ?>';
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Validación de contraseñas en tiempo real
    function validatePasswords() {
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmNewPassword');
        const mismatchDiv = document.getElementById('passwordMismatch');
        
        if (newPassword && confirmPassword) {
            confirmPassword.addEventListener('input', function() {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    mismatchDiv.style.display = 'block';
                    confirmPassword.classList.add('is-invalid');
                } else {
                    confirmPassword.setCustomValidity('');
                    mismatchDiv.style.display = 'none';
                    confirmPassword.classList.remove('is-invalid');
                }
            });
            
            newPassword.addEventListener('input', function() {
                if (confirmPassword.value) {
                    confirmPassword.dispatchEvent(new Event('input'));
                }
            });
        }
    }
    
    // Toggle para mostrar/ocultar contraseña
    function togglePasswordVisibility() {
        const toggleBtn = document.getElementById('toggleNewPassword');
        const passwordInput = document.getElementById('newPassword');
        
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    }
    </script>
</body>
</html>
