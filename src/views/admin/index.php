<?php
// Vista del panel de administración - Filá Mariscales
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" style="min-height: 100vh;">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <h4 class="text-white">
                        <i class="bi bi-shield-fill me-2"></i>Admin Panel
                    </h4>
                    <p class="text-muted small">Filá Mariscales</p>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#dashboard">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#usuarios">
                            <i class="bi bi-people me-2"></i>Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#eventos">
                            <i class="bi bi-calendar-event me-2"></i>Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#galeria">
                            <i class="bi bi-images me-2"></i>Galería
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#configuracion">
                            <i class="bi bi-gear me-2"></i>Configuración
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-danger" href="<?php echo URL_ROOT; ?>/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Panel de Administración</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Imprimir</button>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Usuarios Totales
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">150</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Eventos Activos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-calendar-event fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Fotos en Galería
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">250</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-images fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Mensajes Nuevos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-envelope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Actividad Reciente</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Nuevo usuario registrado</strong>
                                        <br>
                                        <small class="text-muted">Juan Pérez se registró hace 2 horas</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">Nuevo</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Evento actualizado</strong>
                                        <br>
                                        <small class="text-muted">Desfile de Moros y Cristianos - 15 Oct</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">Actualizado</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Nueva foto subida</strong>
                                        <br>
                                        <small class="text-muted">Foto de la cena de hermandad</small>
                                    </div>
                                    <span class="badge bg-info rounded-pill">Galería</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-plus-circle me-2"></i>Crear Evento
                                </button>
                                <button class="btn btn-success" type="button">
                                    <i class="bi bi-person-plus me-2"></i>Agregar Usuario
                                </button>
                                <button class="btn btn-info" type="button">
                                    <i class="bi bi-upload me-2"></i>Subir Fotos
                                </button>
                                <button class="btn btn-warning" type="button">
                                    <i class="bi bi-gear me-2"></i>Configuración
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div> 