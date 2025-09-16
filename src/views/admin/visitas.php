<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Filá Mariscales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }
        .stats-card p {
            margin: 0;
            opacity: 0.9;
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            min-height: 400px;
        }
        .chart-container canvas {
            max-height: 300px !important;
            height: 300px !important;
            width: 100% !important;
        }
        .chart-wrapper {
            height: 300px;
            width: 100%;
            position: relative;
        }
        .metric-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .metric-card h4 {
            color: #667eea;
            font-weight: bold;
            margin: 0;
        }
        .metric-card p {
            color: #666;
            margin: 5px 0 0 0;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/prueba-php/public/admin/dashboard">
                <i class="fas fa-shield-alt me-2"></i>Panel de Administración
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/prueba-php/public/admin/dashboard">Dashboard</a>
                <a class="nav-link" href="/prueba-php/public/admin/usuarios">Usuarios</a>
                <a class="nav-link" href="/prueba-php/public/admin/eventos">Eventos</a>
                <a class="nav-link active" href="/prueba-php/public/admin/visitas">Analíticas</a>
                <a class="nav-link" href="/prueba-php/public/admin/logout">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-chart-line me-2"></i>Analíticas de Visitas</h1>
            <div class="btn-group">
                <button class="btn btn-outline-primary" onclick="refreshData()">
                    <i class="fas fa-sync-alt me-2"></i>Actualizar
                </button>
                <button class="btn btn-outline-success" onclick="exportData()">
                    <i class="fas fa-download me-2"></i>Exportar
                </button>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <h3><?= number_format($visitStats['total_visitas'] ?? 0) ?></h3>
                    <p><i class="fas fa-eye me-2"></i>Visitas Totales (30 días)</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h3><?= number_format($visitStats['visitas_unicas'] ?? 0) ?></h3>
                    <p><i class="fas fa-user-friends me-2"></i>Visitas Únicas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h3><?= number_format($visitStats['visitas_hoy'] ?? 0) ?></h3>
                    <p><i class="fas fa-calendar-day me-2"></i>Visitas Hoy</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <h3><?= number_format($realTimeStats['usuarios_online'] ?? 0) ?></h3>
                    <p><i class="fas fa-wifi me-2"></i>Usuarios Online</p>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-8">
                <div class="chart-container">
                    <h5><i class="fas fa-chart-area me-2"></i>Visitas por Día (Últimos 30 días)</h5>
                    <div class="chart-wrapper">
                        <canvas id="dailyVisitsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h5><i class="fas fa-chart-pie me-2"></i>Dispositivos</h5>
                    <div class="chart-wrapper">
                        <canvas id="deviceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-clock me-2"></i>Visitas por Hora del Día</h5>
                    <div style="height: 350px; width: 100%;">
                        <canvas id="hourlyVisitsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-globe me-2"></i>Páginas Más Visitadas</h5>
                    <div class="list-group">
                        <?php foreach (array_slice($visitStats['paginas_populares'] ?? [], 0, 8) as $page): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-truncate" style="max-width: 300px;"><?= htmlspecialchars($page['page_url']) ?></span>
                            <span class="badge bg-primary rounded-pill"><?= $page['visitas'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas Detalladas -->
        <div class="row">
            <div class="col-md-3">
                <div class="metric-card">
                    <h4><?= number_format($visitStats['visitas_unicas_hoy'] ?? 0) ?></h4>
                    <p>Visitas Únicas Hoy</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h4><?= number_format($realTimeStats['visitas_ultima_hora'] ?? 0) ?></h4>
                    <p>Última Hora</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h4><?= count($visitStats['navegadores'] ?? []) ?></h4>
                    <p>Navegadores Diferentes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h4><?= count($visitStats['dispositivos'] ?? []) ?></h4>
                    <p>Tipos de Dispositivos</p>
                </div>
            </div>
        </div>

        <!-- Tabla de Navegadores -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-browser me-2"></i>Navegadores Más Usados</h5>
                    <div class="list-group">
                        <?php foreach ($visitStats['navegadores'] ?? [] as $browser): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= htmlspecialchars($browser['browser']) ?></span>
                            <span class="badge bg-info rounded-pill"><?= $browser['cantidad'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-mobile-alt me-2"></i>Distribución de Dispositivos</h5>
                    <div class="list-group">
                        <?php foreach ($visitStats['dispositivos'] ?? [] as $device): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= htmlspecialchars($device['device_type']) ?></span>
                            <span class="badge bg-success rounded-pill"><?= $device['cantidad'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Datos para los gráficos
        const dailyVisitsData = <?= json_encode($chartData['dailyVisits'] ?? []) ?>;
        const hourlyVisitsData = <?= json_encode($chartData['hourlyVisits'] ?? []) ?>;
        const deviceData = <?= json_encode($chartData['deviceStats'] ?? []) ?>;

        // Gráfico de visitas por día
        const dailyCtx = document.getElementById('dailyVisitsChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyVisitsData.map(item => item.fecha),
                datasets: [{
                    label: 'Visitas Totales',
                    data: dailyVisitsData.map(item => item.visitas),
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Visitas Únicas',
                    data: dailyVisitsData.map(item => item.visitas_unicas),
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de dispositivos
        const deviceCtx = document.getElementById('deviceChart').getContext('2d');
        new Chart(deviceCtx, {
            type: 'doughnut',
            data: {
                labels: deviceData.map(item => item.device_type),
                datasets: [{
                    data: deviceData.map(item => item.cantidad),
                    backgroundColor: [
                        '#667eea',
                        '#f093fb',
                        '#4facfe',
                        '#43e97b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Gráfico de visitas por hora
        const hourlyCtx = document.getElementById('hourlyVisitsChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hourlyVisitsData.map(item => item.hora + ':00'),
                datasets: [{
                    label: 'Visitas',
                    data: hourlyVisitsData.map(item => item.visitas),
                    backgroundColor: '#4facfe'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Funciones
        function refreshData() {
            location.reload();
        }

        function exportData() {
            alert('Función de exportación en desarrollo. Próximamente podrás exportar los datos en CSV o PDF.');
        }
    </script>
</body>
</html>
