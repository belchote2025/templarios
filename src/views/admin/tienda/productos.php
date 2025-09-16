<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestión de Productos' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn {
            border-radius: 0.375rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .badge {
            font-size: 0.75em;
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
        
        .btn-delete {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #ff2b5c 0%, #ff3b1b 100%);
            color: white;
        }
        
        .btn-photo {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }
        
        .btn-photo:hover {
            background: linear-gradient(135deg, #45b7aa 0%, #3d8b7a 100%);
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/prueba-php/public/admin/dashboard">
                <i class="fas fa-tachometer-alt me-2"></i>Panel Admin
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/prueba-php/public/admin/dashboard">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/prueba-php/public/admin/productos">
                            <i class="fas fa-shopping-cart me-1"></i>Tienda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/prueba-php/public/admin/usuarios">
                            <i class="fas fa-users me-1"></i>Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/prueba-php/public/admin/eventos">
                            <i class="fas fa-calendar me-1"></i>Eventos
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/prueba-php/public/admin/logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php 
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><?= htmlspecialchars($title) ?></h1>
                <a href="/prueba-php/public/admin/nuevo-producto" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Producto
                </a>
            </div>

            <!-- Filtros de Categorías -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn btn-outline-primary active" onclick="filterProducts('all')">
                            <i class="fas fa-th me-2"></i>Todos los productos
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterProducts('Ropa')">
                            <i class="fas fa-tshirt me-2"></i>Ropa
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterProducts('Accesorios')">
                            <i class="fas fa-gem me-2"></i>Accesorios
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterProducts('Recuerdos')">
                            <i class="fas fa-gift me-2"></i>Recuerdos
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lista de productos -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($products)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Categoría</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="products-table-body">
                                    <?php foreach ($products as $product): ?>
                                        <tr class="product-row" data-category="<?= htmlspecialchars(trim($product->categoria_nombre ?? 'Sin categoría')) ?>">
                                            <td><?= $product->id ?></td>
                                            <td>
                                                <?php if (!empty($product->imagen)): ?>
                                                    <img src="/prueba-php/public/uploads/products/<?= htmlspecialchars($product->imagen) ?>" 
                                                         alt="<?= htmlspecialchars($product->nombre) ?>" 
                                                         class="img-thumbnail" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($product->nombre) ?></td>
                                            <td>€<?= number_format($product->precio, 2) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') ?>">
                                                    <?= $product->stock ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($product->categoria_nombre ?? 'Sin categoría') ?></td>
                                            <td>
                                                <span class="badge bg-<?= $product->activo ? 'success' : 'secondary' ?>">
                                                    <?= $product->activo ? 'Activo' : 'Inactivo' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="/prueba-php/public/admin/editar-producto/<?= $product->id ?>" class="action-btn btn-edit" title="Editar producto">
                                                        <i class="fas fa-edit"></i>
                                                        <span>Editar</span>
                                                    </a>
                                                    <button class="action-btn btn-photo" onclick="subirFoto(<?= $product->id ?>, '<?= htmlspecialchars($product->nombre) ?>')" title="Subir foto del producto">
                                                        <i class="fas fa-camera"></i>
                                                        <span>Foto</span>
                                                    </button>
                                                    <button class="action-btn btn-delete" onclick="eliminarProducto(<?= $product->id ?>, '<?= htmlspecialchars($product->nombre) ?>')" title="Eliminar producto">
                                                        <i class="fas fa-trash"></i>
                                                        <span>Eliminar</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay productos</h5>
                            <p class="text-muted">Comienza creando tu primer producto.</p>
                            <a href="/prueba-php/public/admin/nuevo-producto" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Producto
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filtrar productos por categoría
function filterProducts(category) {
    const productRows = document.querySelectorAll('.product-row');
    const buttons = document.querySelectorAll('.btn-outline-primary');
    
    // Actualizar botones activos
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filtrar productos
    productRows.forEach(row => {
        const productCategory = row.dataset.category.trim();
        const filterCategory = category.trim();
        
        if (category === 'all' || productCategory === filterCategory) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Mostrar mensaje si no hay productos en la categoría
    const visibleRows = document.querySelectorAll('.product-row:not([style*="none"])');
    const tableBody = document.getElementById('products-table-body');
    
    // Remover mensaje anterior si existe
    const existingMessage = document.getElementById('no-products-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    if (visibleRows.length === 0 && category !== 'all') {
        const message = document.createElement('tr');
        message.id = 'no-products-message';
        message.innerHTML = `
            <td colspan="8" class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-3">No hay productos en esta categoría</h5>
                <p class="text-muted mb-4">No se encontraron productos de "${category}".</p>
                <button class="btn btn-primary" onclick="filterProducts('all')">
                    <i class="fas fa-th me-2"></i>Ver todos los productos
                </button>
            </td>
        `;
        tableBody.appendChild(message);
    }
}

// Función para subir foto del producto (definida globalmente)
function subirFoto(productId, productName) {
    console.log('subirFoto llamada con:', productId, productName);
    alert('Función subirFoto ejecutada para producto: ' + productName + ' (ID: ' + productId + ')');
    
    // Crear modal dinámicamente
    const modalHtml = `
        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel">Subir Foto - ${productName}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="photoForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="productPhoto" class="form-label">Seleccionar Imagen</label>
                                <input type="file" class="form-control" id="productPhoto" name="photo" accept="image/*" required>
                                <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB</div>
                            </div>
                            <div id="photoPreview" class="mb-3" style="display: none;">
                                <label class="form-label">Vista Previa:</label>
                                <div class="text-center">
                                    <img id="previewImg" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="uploadBtn" data-product-id="${productId}">
                            <i class="fas fa-upload me-2"></i>Subir Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remover modal existente si existe
    const existingModal = document.getElementById('photoModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Añadir modal al body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Mostrar modal
    const modalElement = document.getElementById('photoModal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    
    // Vista previa de la imagen
    const photoInput = document.getElementById('productPhoto');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('previewImg');
                    const photoPreview = document.getElementById('photoPreview');
                    if (previewImg && photoPreview) {
                        previewImg.src = e.target.result;
                        photoPreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Botón de subir
    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function() {
            guardarFoto(productId);
        });
    }
    
    // Limpiar modal cuando se cierre
    modalElement.addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Función para guardar la foto
function guardarFoto(productId) {
    const form = document.getElementById('photoForm');
    const formData = new FormData(form);
    formData.append('product_id', productId);
    
    const submitBtn = document.querySelector('#photoModal .btn-primary');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Subiendo...';
    submitBtn.disabled = true;
    
    fetch('/prueba-php/public/admin/upload-product-photo', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Foto subida correctamente');
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('photoModal'));
            modal.hide();
            // Recargar página para ver la foto
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al subir la foto');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function eliminarProducto(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres eliminar el producto "${nombre}"?`)) {
        // Mostrar indicador de carga
        const boton = event.target.closest('button');
        const textoOriginal = boton.innerHTML;
        boton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        boton.disabled = true;
        
        // Enviar petición de eliminación
        fetch(`/prueba-php/public/admin/eliminar-producto/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                // Recargar la página para mostrar la lista actualizada
                window.location.reload();
            } else {
                alert('Error al eliminar el producto');
                boton.innerHTML = textoOriginal;
                boton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el producto');
            boton.innerHTML = textoOriginal;
            boton.disabled = false;
        });
    }
}
</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
