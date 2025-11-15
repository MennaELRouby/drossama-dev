<!-- SEO Test Results Display -->
<div class="seo-results">
    <!-- Overall Score Alert -->
    <div class="row mb-4">
        <div class="col-12">
            <div
                class="alert @if ($results['overall_score'] >= 80) alert-success @elseif($results['overall_score'] >= 60) alert-warning @else alert-danger @endif">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">
                            <i
                                class="fas @if ($results['overall_score'] >= 80) fa-check-circle @elseif($results['overall_score'] >= 60) fa-exclamation-triangle @else fa-times-circle @endif me-2"></i>
                            {{ __('dashboard.seo_test_completed') }}
                        </h5>
                        <p class="mb-0">
                            {{ __('dashboard.overall_score') }}: <strong>{{ $results['overall_score'] }}%</strong>
                            ({{ $results['total_score'] }}/{{ $results['max_score'] }}
                            {{ __('dashboard.tests_passed') }})
                        </p>
                        <small class="text-muted">
                            {{ __('dashboard.tested_at') }}: {{ $results['timestamp']->format('Y-m-d H:i:s') }}
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="progress-circle">
                            <svg width="80" height="80" viewBox="0 0 80 80">
                                <circle cx="40" cy="40" r="35" fill="none" stroke="#e9ecef"
                                    stroke-width="6" />
                                <circle cx="40" cy="40" r="35" fill="none"
                                    stroke="@if ($results['overall_score'] >= 80) #28a745 @elseif($results['overall_score'] >= 60) #ffc107 @else #dc3545 @endif"
                                    stroke-width="6" stroke-dasharray="{{ 2 * pi() * 35 }}"
                                    stroke-dashoffset="{{ 2 * pi() * 35 * (1 - $results['overall_score'] / 100) }}"
                                    style="transition: stroke-dashoffset 1s ease-in-out;" />
                            </svg>
                            <div class="progress-text">{{ $results['overall_score'] }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Results -->
    <div class="row">
        @foreach ($results['pages'] as $pageName => $pageData)
            @if (isset($pageData['tests']))
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card test-result-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 text-capitalize">
                                    <i class="fas fa-file-alt me-2"></i>{{ ucfirst($pageName) }}
                                </h6>
                                @if (isset($pageData['accessible']) && !$pageData['accessible'])
                                    <small class="text-danger">{{ __('dashboard.page_not_accessible') }}</small>
                                @endif
                            </div>
                            <span
                                class="badge @if (($pageData['percentage'] ?? 0) >= 80) bg-success @elseif(($pageData['percentage'] ?? 0) >= 60) bg-warning @else bg-danger @endif">
                                {{ $pageData['percentage'] ?? 0 }}%
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- Progress Bar -->
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar @if (($pageData['percentage'] ?? 0) >= 80) bg-success @elseif(($pageData['percentage'] ?? 0) >= 60) bg-warning @else bg-danger @endif"
                                    style="width: {{ $pageData['percentage'] ?? 0 }}%"></div>
                            </div>

                            <!-- Score Summary -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    {{ $pageData['score'] }}/{{ $pageData['max_score'] }}
                                    {{ __('dashboard.tests_passed') }}
                                </small>
                                @if (isset($pageData['url']))
                                    <br><small class="text-muted">{{ $pageData['url'] }}</small>
                                @endif
                            </div>

                            <!-- Test Details -->
                            <div class="test-details">
                                @foreach ($pageData['tests'] as $test)
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="flex-grow-1">
                                            <span class="text-sm">{{ $test['name'] }}</span>
                                            @if (isset($test['details']))
                                                <br><small class="text-muted">{{ $test['details'] }}</small>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            @if ($test['passed'])
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Recommendations Section -->
    @if (isset($results['recommendations']) && array_sum(array_map('count', $results['recommendations'])) > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>{{ __('dashboard.seo_recommendations') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- High Priority -->
                            @if (count($results['recommendations']['high_priority']) > 0)
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-danger mb-3">
                                        <i
                                            class="fas fa-exclamation-triangle me-2"></i>{{ __('dashboard.high_priority') }}
                                    </h6>
                                    <ul class="list-unstyled">
                                        @foreach ($results['recommendations']['high_priority'] as $recommendation)
                                            <li class="mb-2">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-circle text-danger me-2 mt-1"
                                                        style="font-size: 6px;"></i>
                                                    <span class="text-sm">{{ $recommendation }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Medium Priority -->
                            @if (count($results['recommendations']['medium_priority']) > 0)
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-warning mb-3">
                                        <i
                                            class="fas fa-exclamation-circle me-2"></i>{{ __('dashboard.medium_priority') }}
                                    </h6>
                                    <ul class="list-unstyled">
                                        @foreach ($results['recommendations']['medium_priority'] as $recommendation)
                                            <li class="mb-2">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-circle text-warning me-2 mt-1"
                                                        style="font-size: 6px;"></i>
                                                    <span class="text-sm">{{ $recommendation }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Low Priority -->
                            @if (count($results['recommendations']['low_priority']) > 0)
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-info mb-3">
                                        <i class="fas fa-info-circle me-2"></i>{{ __('dashboard.low_priority') }}
                                    </h6>
                                    <ul class="list-unstyled">
                                        @foreach ($results['recommendations']['low_priority'] as $recommendation)
                                            <li class="mb-2">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-circle text-info me-2 mt-1"
                                                        style="font-size: 6px;"></i>
                                                    <span class="text-sm">{{ $recommendation }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Export Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="enhanced-page-header">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ __('dashboard.export_results') }}</h6>
                            <small class="text-muted">{{ __('dashboard.save_or_share_test_results') }}</small>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="printResults()">
                                <i class="fas fa-print me-2"></i>{{ __('dashboard.print') }}
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf me-2"></i>{{ __('dashboard.export_pdf') }}
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-copy me-2"></i>{{ __('dashboard.copy_link') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printResults() {
        window.print();
    }

    function exportToPDF() {
        // This would integrate with a PDF generation service
        alert('PDF export functionality would be implemented here');
    }

    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            // Show success toast
            showSuccessToast('URL copied to clipboard');
        });
    }

    function showSuccessToast(message) {
        // Create and show toast notification
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
        document.body.appendChild(toast);

        const toastInstance = new bootstrap.Toast(toast);
        toastInstance.show();

        // Remove toast element after it's hidden
        toast.addEventListener('hidden.bs.toast', () => {
            document.body.removeChild(toast);
        });
    }
</script>
