<x-dashboard.layout title="Performance Monitoring">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Performance Monitoring</li>
                        </ol>
                    </div>
                    <h4 class="page-title">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                        Performance Monitoring
                        <small class="text-muted">Core Web Vitals</small>
                    </h4>
                </div>
            </div>
        </div>

        @if (isset($message))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Performance Overview Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="fas fa-chart-line font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">CLS</h5>
                        <p class="text-muted mb-2">Layout Shift</p>
                        <h4 class="mb-0 text-success">{{ $performanceData['cls']['good'] }}%</h4>
                        <small class="text-success">Good</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                <i class="fas fa-mouse font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">FID</h5>
                        <p class="text-muted mb-2">Input Delay</p>
                        <h4 class="mb-0 text-warning">{{ $performanceData['fid']['good'] }}%</h4>
                        <small class="text-warning">Good</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-info-subtle text-info rounded-circle">
                                <i class="fas fa-image font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">LCP</h5>
                        <p class="text-muted mb-2">Content Paint</p>
                        <h4 class="mb-0 text-info">{{ $performanceData['lcp']['good'] }}%</h4>
                        <small class="text-info">Good</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                <i class="fas fa-bolt font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">FCP</h5>
                        <p class="text-muted mb-2">First Paint</p>
                        <h4 class="mb-0 text-primary">{{ $performanceData['fcp']['good'] }}%</h4>
                        <small class="text-primary">Good</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-secondary-subtle text-secondary rounded-circle">
                                <i class="fas fa-server font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">TTFB</h5>
                        <p class="text-muted mb-2">Time to Byte</p>
                        <h4 class="mb-0 text-secondary">{{ $performanceData['ttfb']['good'] }}%</h4>
                        <small class="text-secondary">Good</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100 performance-card">
                    <div class="card-body text-center">
                        <div class="avatar-sm mx-auto mb-3">
                            <span class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                <i class="fas fa-chart-pie font-size-18"></i>
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1">Overall</h5>
                        <p class="text-muted mb-2">Performance</p>
                        <h4 class="mb-0 text-danger">0%</h4>
                        <small class="text-danger">No Data</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>
                            CLS Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="clsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2 text-info"></i>
                            LCP Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="lcpChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Metrics Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-table me-2 text-success"></i>
                                Recent Performance Metrics
                            </h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt me-1"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($recentMetrics) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Page</th>
                                            <th>CLS</th>
                                            <th>FID (ms)</th>
                                            <th>LCP (ms)</th>
                                            <th>FCP (ms)</th>
                                            <th>TTFB (ms)</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentMetrics as $metric)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-file-alt me-2 text-muted"></i>
                                                    {{ $metric['page'] }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $metric['cls'] <= 0.1 ? 'success' : ($metric['cls'] <= 0.25 ? 'warning' : 'danger') }}">
                                                        {{ number_format($metric['cls'], 3) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $metric['fid'] <= 100 ? 'success' : ($metric['fid'] <= 300 ? 'warning' : 'danger') }}">
                                                        {{ $metric['fid'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $metric['lcp'] <= 2500 ? 'success' : ($metric['lcp'] <= 4000 ? 'warning' : 'danger') }}">
                                                        {{ $metric['lcp'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $metric['fcp'] <= 1800 ? 'success' : ($metric['fcp'] <= 3000 ? 'warning' : 'danger') }}">
                                                        {{ $metric['fcp'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $metric['ttfb'] <= 800 ? 'success' : ($metric['ttfb'] <= 1800 ? 'warning' : 'danger') }}">
                                                        {{ $metric['ttfb'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($metric['timestamp'])->diffForHumans() }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-chart-line text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No Performance Data Available</h5>
                                <p class="text-muted">Performance metrics will appear here once users start visiting
                                    your
                                    pages.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Guidelines -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Performance Guidelines
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-chart-line me-2"></i>
                                        CLS (Cumulative Layout Shift)
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-success">Good</span>
                                        <span>≤ 0.1</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-warning">Needs Improvement</span>
                                        <span>0.1 - 0.25</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge badge-danger">Poor</span>
                                        <span>> 0.25</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-warning mb-3">
                                        <i class="fas fa-mouse me-2"></i>
                                        FID (First Input Delay)
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-success">Good</span>
                                        <span>≤ 100ms</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-warning">Needs Improvement</span>
                                        <span>100ms - 300ms</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge badge-danger">Poor</span>
                                        <span>> 300ms</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-info mb-3">
                                        <i class="fas fa-image me-2"></i>
                                        LCP (Largest Contentful Paint)
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-success">Good</span>
                                        <span>≤ 2.5s</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-warning">Needs Improvement</span>
                                        <span>2.5s - 4s</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge badge-danger">Poor</span>
                                        <span>> 4s</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-bolt me-2"></i>
                                        FCP (First Contentful Paint)
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-success">Good</span>
                                        <span>≤ 1.8s</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge badge-warning">Needs Improvement</span>
                                        <span>1.8s - 3s</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge badge-danger">Poor</span>
                                        <span>> 3s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // CLS Chart
        const clsCtx = document.getElementById('clsChart').getContext('2d');
        new Chart(clsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Good', 'Needs Improvement', 'Poor'],
                datasets: [{
                    data: [{{ $performanceData['cls']['good'] }},
                        {{ $performanceData['cls']['needs_improvement'] }},
                        {{ $performanceData['cls']['poor'] }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // LCP Chart
        const lcpCtx = document.getElementById('lcpChart').getContext('2d');
        new Chart(lcpCtx, {
            type: 'doughnut',
            data: {
                labels: ['Good', 'Needs Improvement', 'Poor'],
                datasets: [{
                    data: [{{ $performanceData['lcp']['good'] }},
                        {{ $performanceData['lcp']['needs_improvement'] }},
                        {{ $performanceData['lcp']['poor'] }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>

    <style>
        /* Performance Cards Styling */
        .performance-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .performance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            border-color: #007bff;
        }

        .performance-card .avatar-sm {
            width: 4rem;
            height: 4rem;
            transition: all 0.3s ease;
        }

        .performance-card:hover .avatar-sm {
            transform: scale(1.1);
        }

        .performance-card .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-size: 1.5rem;
        }

        /* Page Header */
        .page-title-box {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            color: white;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.5rem 1rem;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Chart Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px 15px 0 0 !important;
            border-bottom: 2px solid #dee2e6;
        }

        /* Table Styling */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            border-color: #f1f3f4;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Badge Styling */
        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
        }

        /* Guidelines Cards */
        .border {
            border-radius: 10px !important;
            transition: all 0.3s ease;
        }

        .border:hover {
            border-color: #007bff !important;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.1);
        }

        /* Empty State */
        .text-center.py-5 {
            padding: 3rem 1rem;
        }

        .text-center.py-5 i {
            opacity: 0.3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .performance-card .avatar-sm {
                width: 3rem;
                height: 3rem;
            }

            .performance-card .avatar-title {
                font-size: 1.2rem;
            }
        }

        /* Animation for loading */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .performance-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .performance-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .performance-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .performance-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .performance-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .performance-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .performance-card:nth-child(6) {
            animation-delay: 0.6s;
        }
    </style>
</x-dashboard.layout>
