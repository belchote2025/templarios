<?php
// Vista para gestión de mensajes en el panel de administración
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-envelope me-2"></i>
                    Gestión de Mensajes
                </h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="refreshMessages()">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Actualizar
                    </button>
                    <a href="<?php echo URL_ROOT; ?>/admin" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Volver al Panel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo $messagesCount; ?></h4>
                            <p class="card-text">Total Mensajes</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-envelope fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo count(array_filter($messagesList, function($msg) { return strpos($msg['filename'], 'contacto') !== false; })); ?></h4>
                            <p class="card-text">Mensajes de Contacto</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-lines-fill fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo count(array_filter($messagesList, function($msg) { return strpos($msg['filename'], 'newsletter') !== false; })); ?></h4>
                            <p class="card-text">Suscripciones</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-newspaper fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo count(array_filter($messagesList, function($msg) { return (time() - strtotime($msg['modified'])) < 86400; })); ?></h4>
                            <p class="card-text">Últimas 24h</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-clock fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de mensajes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Lista de Mensajes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($messagesList)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <h5 class="text-muted mt-3">No hay mensajes</h5>
                            <p class="text-muted">Los mensajes aparecerán aquí cuando los usuarios envíen formularios.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($messagesList as $message): ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $filename = $message['filename'];
                                                if (strpos($filename, 'contacto') !== false) {
                                                    echo '<span class="badge bg-danger"><i class="bi bi-person-lines-fill me-1"></i>Contacto</span>';
                                                } elseif (strpos($filename, 'newsletter') !== false) {
                                                    echo '<span class="badge bg-success"><i class="bi bi-newspaper me-1"></i>Newsletter</span>';
                                                } elseif (strpos($filename, 'email') !== false) {
                                                    echo '<span class="badge bg-info"><i class="bi bi-envelope me-1"></i>Email</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary"><i class="bi bi-file-text me-1"></i>Otro</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <code><?php echo htmlspecialchars($message['filename']); ?></code>
                                            </td>
                                            <td>
                                                <?php echo formatBytes($message['size']); ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo date('d/m/Y H:i', strtotime($message['modified'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" onclick="viewMessageDirect('<?php echo htmlspecialchars($message['filename']); ?>', `<?php echo htmlspecialchars($message['content']); ?>`)">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success" onclick="downloadMessage('<?php echo htmlspecialchars($message['filename']); ?>')">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" onclick="deleteMessage('<?php echo htmlspecialchars($message['filename']); ?>')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver mensaje -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-envelope me-2"></i>
                    Ver Mensaje
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="downloadCurrentMessage()">
                    <i class="bi bi-download me-1"></i>
                    Descargar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentMessageFile = '';

// Función para formatear bytes
function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Ver mensaje directamente (sin fetch)
function viewMessageDirect(filename, content) {
    currentMessageFile = filename;
    
    // Formatear contenido según el tipo de archivo
    let formattedContent = content;
    
    if (filename.endsWith('.json')) {
        try {
            const jsonData = JSON.parse(content);
            formattedContent = JSON.stringify(jsonData, null, 2);
        } catch (e) {
            formattedContent = content;
        }
    }
    
    // Mostrar modal con contenido
    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    
    document.getElementById('messageContent').innerHTML = `
        <div class="mb-3">
            <h6><strong>Archivo:</strong> ${filename}</h6>
            <small class="text-muted">Tipo: ${filename.endsWith('.json') ? 'JSON' : 'Texto'}</small>
        </div>
        <div class="border rounded p-3" style="background-color: #f8f9fa; max-height: 400px; overflow-y: auto;">
            <pre style="white-space: pre-wrap; font-family: 'Courier New', monospace; font-size: 0.9em; margin: 0;">${formattedContent}</pre>
        </div>
    `;
    
    modal.show();
}

// Ver mensaje (método original con fetch)
function viewMessage(filename) {
    currentMessageFile = filename;
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    modal.show();
    
    // Cargar contenido
    fetch(`/prueba-php/public/admin/mensajes/view/${filename}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(content => {
            // Formatear contenido según el tipo de archivo
            let formattedContent = content;
            
            if (filename.endsWith('.json')) {
                try {
                    const jsonData = JSON.parse(content);
                    formattedContent = JSON.stringify(jsonData, null, 2);
                } catch (e) {
                    formattedContent = content;
                }
            }
            
            document.getElementById('messageContent').innerHTML = `
                <div class="mb-3">
                    <h6><strong>Archivo:</strong> ${filename}</h6>
                    <small class="text-muted">Tipo: ${filename.endsWith('.json') ? 'JSON' : 'Texto'}</small>
                </div>
                <div class="border rounded p-3" style="background-color: #f8f9fa; max-height: 400px; overflow-y: auto;">
                    <pre style="white-space: pre-wrap; font-family: 'Courier New', monospace; font-size: 0.9em; margin: 0;">${formattedContent}</pre>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('messageContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Error al cargar el mensaje: ${error.message}
                    <br><small>Verifica que el archivo existe y que tienes permisos para leerlo.</small>
                </div>
            `;
        });
}

// Descargar mensaje
function downloadMessage(filename) {
    window.open(`/prueba-php/public/admin/mensajes/download/${filename}`, '_blank');
}

// Descargar mensaje actual
function downloadCurrentMessage() {
    if (currentMessageFile) {
        downloadMessage(currentMessageFile);
    }
}

// Eliminar mensaje
function deleteMessage(filename) {
    if (confirm(`¿Estás seguro de que quieres eliminar el mensaje "${filename}"?`)) {
        fetch(`/prueba-php/public/admin/mensajes/delete/${filename}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar el mensaje: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error al eliminar el mensaje: ' + error.message);
        });
    }
}

// Actualizar mensajes
function refreshMessages() {
    location.reload();
}
</script>

<?php
// Función para formatear bytes
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}
?>
