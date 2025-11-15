<x-dashboard.layout :title="__('dashboard.seo_testing')">

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">
                        <i class="fas fa-search-plus me-2"></i>{{ __('dashboard.seo_testing') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.seo_testing') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary w-100" id="runComprehensiveTest">
                                    <i class="fas fa-rocket me-2"></i>
                                    {{ __('dashboard.comprehensive_seo_test') }}
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-info w-100" id="runQuickTest">
                                    <i class="fas fa-bolt me-2"></i>
                                    {{ __('dashboard.quick_seo_test') }}
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success w-100" id="testSitemap">
                                    <i class="fas fa-sitemap me-2"></i>
                                    {{ __('dashboard.test_sitemap') }}
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-warning w-100" id="getRecommendations">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    {{ __('dashboard.seo_recommendations') }}
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-secondary w-100" id="testDynamicPage">
                                    <i class="fas fa-cogs me-2"></i>
                                    اختبار صفحة ديناميكية
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-dark w-100" id="checkDynamicPagesStatus">
                                    <i class="fas fa-info-circle me-2"></i>
                                    فحص حالة الصفحات
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Score Overview -->
        @if ($recentResults)
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">{{ __('dashboard.overall_seo_score') }}</p>
                                    <h4 class="mb-0">{{ $recentResults['overall_score'] }}%</h4>
                                    <small
                                        class="text-muted">{{ $recentResults['total_score'] }}/{{ $recentResults['max_score'] }}
                                        {{ __('dashboard.tests_passed') }}</small>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div
                                        class="mini-stat-icon avatar-sm rounded-circle 
                                @if ($recentResults['overall_score'] >= 80) bg-success
                                @elseif($recentResults['overall_score'] >= 60) bg-warning  
                                @else bg-danger @endif
                                align-self-center overflow-hidden">
                                        <span class="avatar-title">
                                            <i class="fas fa-chart-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">{{ __('dashboard.pages_tested') }}</p>
                                    <h4 class="mb-0">{{ count($recentResults['pages']) }}</h4>
                                    <small class="text-muted">{{ __('dashboard.last_test') }}:
                                        {{ $recentResults['timestamp']->diffForHumans() }}</small>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div
                                        class="mini-stat-icon avatar-sm rounded-circle bg-info align-self-center overflow-hidden">
                                        <span class="avatar-title">
                                            <i class="fas fa-file-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">{{ __('dashboard.high_priority_issues') }}</p>
                                    <h4 class="mb-0 text-danger">
                                        {{ count($recentResults['recommendations']['high_priority']) }}</h4>
                                    <small class="text-muted">{{ __('dashboard.need_immediate_attention') }}</small>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div
                                        class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center overflow-hidden">
                                        <span class="avatar-title">
                                            <i class="fas fa-exclamation-triangle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">{{ __('dashboard.total_recommendations') }}</p>
                                    <h4 class="mb-0">
                                        {{ array_sum(array_map('count', $recentResults['recommendations'])) }}</h4>
                                    <small class="text-muted">{{ __('dashboard.optimization_opportunities') }}</small>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div
                                        class="mini-stat-icon avatar-sm rounded-circle bg-secondary align-self-center overflow-hidden">
                                        <span class="avatar-title">
                                            <i class="fas fa-tasks font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Test Results Section -->
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>{{ __('dashboard.seo_test_results') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Loading State -->
                        <div id="loadingState" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">{{ __('dashboard.loading') }}</span>
                            </div>
                            <p class="mt-2">{{ __('dashboard.running_seo_tests') }}</p>
                        </div>

                        <!-- Results Container -->
                        <div id="testResults">
                            @if ($recentResults)
                                @include('Dashboard.seo-testing.partials.results', [
                                    'results' => $recentResults,
                                ])
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('dashboard.no_recent_tests') }}</h5>
                                    <p class="text-muted">{{ __('dashboard.run_first_seo_test') }}</p>
                                    <button type="button" class="btn btn-primary" id="startSeoAnalysis">
                                        <i class="fas fa-play me-2"></i>{{ __('dashboard.start_seo_analysis') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Test Modal -->
        <div class="modal fade" id="quickTestModal" tabindex="-1" aria-labelledby="quickTestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quickTestModalLabel">
                            <i class="fas fa-bolt me-2"></i>{{ __('dashboard.quick_seo_test') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="quickTestForm">
                            <div class="mb-3">
                                <label for="testUrl" class="form-label">{{ __('dashboard.url_to_test') }}</label>
                                <input type="url" class="form-control" id="testUrl"
                                    value="{{ config('app.url') }}" required>
                                <div class="form-text">{{ __('dashboard.enter_full_url_to_test') }}</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="runQuickTestSubmitBtn">
                            <i class="fas fa-play me-2"></i>{{ __('dashboard.run_test') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .seo-score-excellent {
                color: #28a745 !important;
            }

            .seo-score-good {
                color: #ffc107 !important;
            }

            .seo-score-poor {
                color: #dc3545 !important;
            }

            .test-result-card {
                transition: all 0.3s ease;
            }

            .test-result-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .progress-circle {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 60px;
            }

            .progress-circle svg {
                transform: rotate(-90deg);
            }

            .progress-circle .progress-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 12px;
                font-weight: bold;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Immediate test - outside DOMContentLoaded
            console.log('🔥 Script tag loaded - testing if JS runs at all');
            console.log('🔥 Bootstrap available?', typeof bootstrap !== 'undefined');
            console.log('🔥 jQuery available?', typeof $ !== 'undefined');

            // Wait for DOM to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 SEO Testing page loaded - DOMContentLoaded fired');

                // Test button existence
                const testBtn = document.getElementById('runComprehensiveTest');
                console.log('🔍 Button exists?', testBtn !== null, testBtn);

                // CSRF Token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('🔑 CSRF Token:', csrfToken ? '✅ Found' : '❌ Not found');

                if (!csrfToken) {
                    console.error('❌ CSRF token not found!');
                    alert('⚠️ CSRF token not found! Check console.');
                    return;
                }

                // API Routes
                const routes = {
                    comprehensive: "{{ route('dashboard.seo.testing.comprehensive') }}",
                    quick: "{{ route('dashboard.seo.testing.quick') }}",
                    sitemap: "{{ route('dashboard.seo.testing.sitemap') }}",
                    recommendations: "{{ route('dashboard.seo.testing.recommendations') }}",
                    dynamicPage: "{{ route('dashboard.seo.testing.dynamic-page') }}",
                    dynamicPagesStatus: "{{ route('dashboard.seo.testing.dynamic-pages-status') }}"
                };

                console.log('📍 Routes configured:', routes);

                // Event Listeners
                const runComprehensiveBtn = document.getElementById('runComprehensiveTest');
                if (runComprehensiveBtn) {
                    runComprehensiveBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Comprehensive test button clicked');
                        runComprehensiveTest();
                    });
                } else {
                    console.error('❌ runComprehensiveTest button not found');
                }

                const runQuickTestBtn = document.getElementById('runQuickTest');
                if (runQuickTestBtn) {
                    runQuickTestBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Quick test button clicked');
                        const modal = new bootstrap.Modal(document.getElementById('quickTestModal'));
                        modal.show();

                        // Add event listener to submit button after modal is shown
                        setTimeout(() => {
                            const submitBtn = document.getElementById('runQuickTestSubmitBtn');
                            if (submitBtn && !submitBtn.hasAttribute('data-listener-added')) {
                                submitBtn.setAttribute('data-listener-added', 'true');
                                submitBtn.addEventListener('click', runQuickTestSubmit);
                            }
                        }, 100);
                    });
                }

                const testSitemapBtn = document.getElementById('testSitemap');
                if (testSitemapBtn) {
                    testSitemapBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Test sitemap button clicked');
                        testSitemap();
                    });
                }

                const getRecommendationsBtn = document.getElementById('getRecommendations');
                if (getRecommendationsBtn) {
                    getRecommendationsBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Get recommendations button clicked');
                        getRecommendations();
                    });
                }

                const testDynamicPageBtn = document.getElementById('testDynamicPage');
                if (testDynamicPageBtn) {
                    testDynamicPageBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Test dynamic page button clicked');
                        showDynamicPageModal();
                    });
                }

                const checkDynamicPagesStatusBtn = document.getElementById('checkDynamicPagesStatus');
                if (checkDynamicPagesStatusBtn) {
                    checkDynamicPagesStatusBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Check dynamic pages status button clicked');
                        checkDynamicPagesStatus();
                    });
                }

                // Add event listener for the start SEO analysis button (if it exists)
                const startSeoAnalysisBtn = document.getElementById('startSeoAnalysis');
                if (startSeoAnalysisBtn) {
                    startSeoAnalysisBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('✅ Start SEO analysis button clicked');
                        runComprehensiveTest();
                    });
                }

                // Comprehensive Test
                async function runComprehensiveTest() {
                    console.log('🚀 Running comprehensive test...');
                    showLoading();

                    try {
                        console.log('📡 Sending request to:', routes.comprehensive);
                        const response = await fetch(routes.comprehensive, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        console.log('📥 Response received:', response.status);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();
                        console.log('✅ Data received:', data);

                        if (data.success) {
                            displayResults(data.results);
                        } else {
                            showError(data.error || 'Failed to run comprehensive test');
                        }
                    } catch (error) {
                        console.error('❌ Error:', error);
                        showError(`An error occurred while running the test: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                // Quick Test
                async function runQuickTestSubmit() {
                    const url = document.getElementById('testUrl').value;
                    const modal = bootstrap.Modal.getInstance(document.getElementById('quickTestModal'));
                    modal.hide();

                    showLoading();

                    try {
                        const response = await fetch(routes.quick, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                url: url
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            displayQuickResult(data.result);
                        } else {
                            showError(data.error || 'Failed to run quick test');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError(`An error occurred while running the test: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                // Test Sitemap
                async function testSitemap() {
                    showLoading();

                    try {
                        const response = await fetch(routes.sitemap, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            displaySitemapResult(data.sitemap);
                        } else {
                            showError(data.error || 'Failed to test sitemap');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError(`An error occurred while testing sitemap: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                // Get Recommendations
                async function getRecommendations() {
                    showLoading();

                    try {
                        const response = await fetch(routes.recommendations, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            displayRecommendations(data.recommendations);
                        } else {
                            showError(data.error || 'Failed to get recommendations');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError(`An error occurred while getting recommendations: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                // Display Functions
                function displayResults(results) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateResultsHTML(results);
                }

                function displayQuickResult(result) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateQuickResultHTML(result);
                }

                function displaySitemapResult(sitemap) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateSitemapHTML(sitemap);
                }

                function generateQuickResultHTML(result) {
                    const percentage = result.percentage || 0;
                    const scoreClass = getScoreClass(percentage);

                    return `
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick SEO Test Results
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Page: ${result.name}</h6>
                            <p class="mb-0">Score: <strong class="${scoreClass}">${percentage}%</strong> (${result.score}/${result.max_score} tests passed)</p>
                            <small class="text-muted">URL: ${result.url}</small>
                        </div>
                        
                        <div class="test-details">
                            ${result.tests.map(test => `
                                                                                                                                                                                                                                                                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                        <strong>${test.name}</strong>
                                                                                                                                                                                                                                                                                                        ${test.details ? `<br><small class="text-muted">${test.details}</small>` : ''}
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <span class="badge ${test.passed ? 'bg-success' : 'bg-danger'}">
                                                                                                                                                                                                                                                                                                        ${test.passed ? '✓' : '✗'}
                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                function generateSitemapHTML(sitemap) {
                    return `
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sitemap me-2"></i>Sitemap Test Results
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert ${sitemap.found ? 'alert-success' : 'alert-danger'}">
                            <h6 class="alert-heading">
                                <i class="fas ${sitemap.found ? 'fa-check-circle' : 'fa-times-circle'} me-2"></i>
                                Sitemap ${sitemap.found ? 'Found' : 'Not Found'}
                            </h6>
                            ${sitemap.found ? `
                                                                                                                                                                                                                                                                                                <p class="mb-1"><strong>URL:</strong> ${sitemap.url}</p>
                                                                                                                                                                                                                                                                                                <p class="mb-1"><strong>URLs:</strong> ${sitemap.url_count} pages</p>
                                                                                                                                                                                                                                                                                                <p class="mb-1"><strong>Sitemaps:</strong> ${sitemap.sitemap_count} sitemap files</p>
                                                                                                                                                                                                                                                                                                ${sitemap.last_modified ? `<p class="mb-0"><strong>Last Modified:</strong> ${sitemap.last_modified}</p>` : ''}
                                                                                                                                                                                                                                                                                            ` : `
                                                                                                                                                                                                                                                                                                <p class="mb-0">No sitemap.xml file was found at the standard locations.</p>
                                                                                                                                                                                                                                                                                            `}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                function displayRecommendations(recommendations) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateRecommendationsHTML(recommendations);
                }

                function generateRecommendationsHTML(recommendations) {
                    // Safety check for recommendations
                    if (!recommendations || typeof recommendations !== 'object') {
                        return `
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    No recommendations available. Please run a comprehensive SEO test first.
                </div>
            </div>
        </div>
    `;
                    }

                    // Ensure all recommendation arrays exist and are arrays
                    const highPriority = Array.isArray(recommendations.high_priority) ? recommendations.high_priority :
                        [];
                    const mediumPriority = Array.isArray(recommendations.medium_priority) ? recommendations
                        .medium_priority : [];
                    const lowPriority = Array.isArray(recommendations.low_priority) ? recommendations.low_priority : [];

                    return `
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>SEO Recommendations
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-danger mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>High Priority
                                </h6>
                                <ul class="list-unstyled">
                                    ${highPriority.length > 0 ? 
                                        highPriority.map(item => `
                                                                                                                                                                            <li class="mb-2">
                                                                                                                                                                                <div class="d-flex align-items-start">
                                                                                                                                                                                    <i class="fas fa-circle text-danger me-2 mt-1" style="font-size: 6px;"></i>
                                                                                                                                                                                    <span class="text-sm">${item}</span>
                                                                                                                                                                                </div>
                                                                                                                                                                            </li>
                                                                                                                                                                        `).join('') :
                                        '<li class="text-muted text-sm">No high priority issues found</li>'
                                    }
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-warning mb-3">
                                    <i class="fas fa-exclamation-circle me-2"></i>Medium Priority
                                </h6>
                                <ul class="list-unstyled">
                                    ${mediumPriority.length > 0 ? 
                                        mediumPriority.map(item => `
                                                                                                                                                                            <li class="mb-2">
                                                                                                                                                                                <div class="d-flex align-items-start">
                                                                                                                                                                                    <i class="fas fa-circle text-warning me-2 mt-1" style="font-size: 6px;"></i>
                                                                                                                                                                                    <span class="text-sm">${item}</span>
                                                                                                                                                                                </div>
                                                                                                                                                                            </li>
                                                                                                                                                                        `).join('') :
                                        '<li class="text-muted text-sm">No medium priority issues found</li>'
                                    }
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Low Priority
                                </h6>
                                <ul class="list-unstyled">
                                    ${lowPriority.length > 0 ? 
                                        lowPriority.map(item => `
                                                                                                                                                                            <li class="mb-2">
                                                                                                                                                                                <div class="d-flex align-items-start">
                                                                                                                                                                                    <i class="fas fa-circle text-info me-2 mt-1" style="font-size: 6px;"></i>
                                                                                                                                                                                    <span class="text-sm">${item}</span>
                                                                                                                                                                                </div>
                                                                                                                                                                            </li>
                                                                                                                                                                        `).join('') :
                                        '<li class="text-muted text-sm">No low priority issues found</li>'
                                    }
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                // Dynamic Page Testing
                function showDynamicPageModal() {
                    const modal = `
        <div class="modal fade" id="dynamicPageModal" tabindex="-1" aria-labelledby="dynamicPageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dynamicPageModalLabel">
                            <i class="fas fa-cogs me-2"></i>Test Dynamic Page
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="dynamicPageForm">
                            <div class="mb-3">
                                <label for="pageType" class="form-label">Page Type</label>
                                <select class="form-select" id="pageType" required>
                                    <option value="">Choose page type</option>
                                    <option value="blog">Blog</option>
                                    <option value="service">Service</option>
                                    <option value="project">Project</option>
                                    <option value="product">Product</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pageId" class="form-label">Page ID</label>
                                <input type="number" class="form-control" id="pageId" placeholder="Enter page ID" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="testDynamicPageBtn">Test</button>
                    </div>
                </div>
            </div>
        </div>
    `;

                    // Remove existing modal if any
                    const existingModal = document.getElementById('dynamicPageModal');
                    if (existingModal) {
                        existingModal.remove();
                    }

                    // Add modal to body
                    document.body.insertAdjacentHTML('beforeend', modal);

                    // Add event listener to test button
                    const testBtn = document.getElementById('testDynamicPageBtn');
                    if (testBtn) {
                        testBtn.addEventListener('click', testDynamicPage);
                    }

                    // Show modal
                    new bootstrap.Modal(document.getElementById('dynamicPageModal')).show();
                }

                async function testDynamicPage() {
                    const pageType = document.getElementById('pageType').value;
                    const pageId = document.getElementById('pageId').value;

                    if (!pageType || !pageId) {
                        alert('Please fill all fields');
                        return;
                    }

                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('dynamicPageModal'));
                    modal.hide();

                    showLoading();

                    try {
                        const response = await fetch(routes.dynamicPage, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                type: pageType,
                                id: pageId
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            displayDynamicPageResult(data.result);
                        } else {
                            showError(data.error || 'Failed to test dynamic page');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError(`An error occurred during testing: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                async function checkDynamicPagesStatus() {
                    showLoading();
                    try {
                        const response = await fetch(routes.dynamicPagesStatus, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            displayDynamicPagesStatus(data.status);
                        } else {
                            showError(data.error || 'Failed to check dynamic pages status');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showError(`An error occurred while checking dynamic pages status: ${error.message}`);
                    } finally {
                        hideLoading();
                    }
                }

                function displayDynamicPageResult(result) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateDynamicPageResultHTML(result);
                }

                function displayDynamicPagesStatus(status) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = generateDynamicPagesStatusHTML(status);
                }

                function generateDynamicPageResultHTML(result) {
                    const percentage = result.percentage || 0;
                    const scoreClass = getScoreClass(percentage);

                    return `
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>نتائج اختبار الصفحة الديناميكية
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">الصفحة: ${result.name}</h6>
                            <p class="mb-0">النتيجة: <strong class="${scoreClass}">${percentage}%</strong> (${result.score}/${result.max_score} اختبارات نجحت)</p>
                            <small class="text-muted">الرابط: ${result.url}</small>
                        </div>
                        
                        <div class="test-details">
                            ${result.tests.map(test => `
                                                                                                                                                                                                                                                                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                        <strong>${test.name}</strong>
                                                                                                                                                                                                                                                                                                        ${test.details ? `<br><small class="text-muted">${test.details}</small>` : ''}
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <span class="badge ${test.passed ? 'bg-success' : 'bg-danger'}">
                                                                                                                                                                                                                                                                                                        ${test.passed ? '✓' : '✗'}
                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                function generateDynamicPagesStatusHTML(status) {
                    let html = `
        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>حالة الصفحات الديناميكية
                        </h5>
                    </div>
                    <div class="card-body">
    `;

                    // Blogs
                    if (status.blogs) {
                        html += `
                        <div class="mb-4">
                            <h6 class="text-primary">
                                <i class="fas fa-newspaper me-2"></i>المقالات (${status.blogs.count})
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>العنوان</th>
                                            <th>Slug</th>
                                            <th>الرابط</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                        status.blogs.items.forEach(blog => {
                            html += `
                            <tr>
                                <td>${blog.id}</td>
                                <td>${blog.title}</td>
                                <td>${blog.slug || 'غير محدد'}</td>
                                <td>${blog.url}</td>
                                <td>
                                    <span class="badge ${blog.has_slug ? 'bg-success' : 'bg-danger'}">
                                        ${blog.has_slug ? 'متاح' : 'غير متاح'}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });

                        html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    }

                    // Services
                    if (status.services) {
                        html += `
                        <div class="mb-4">
                            <h6 class="text-success">
                                <i class="fas fa-cogs me-2"></i>الخدمات (${status.services.count})
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>العنوان</th>
                                            <th>Slug</th>
                                            <th>الرابط</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                        status.services.items.forEach(service => {
                            html += `
                            <tr>
                                <td>${service.id}</td>
                                <td>${service.title}</td>
                                <td>${service.slug || 'غير محدد'}</td>
                                <td>${service.url}</td>
                                <td>
                                    <span class="badge ${service.has_slug ? 'bg-success' : 'bg-danger'}">
                                        ${service.has_slug ? 'متاح' : 'غير متاح'}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });

                        html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    }

                    // Projects
                    if (status.projects) {
                        html += `
                        <div class="mb-4">
                            <h6 class="text-warning">
                                <i class="fas fa-project-diagram me-2"></i>المشاريع (${status.projects.count})
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>العنوان</th>
                                            <th>Slug</th>
                                            <th>الرابط</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                        status.projects.items.forEach(project => {
                            html += `
                            <tr>
                                <td>${project.id}</td>
                                <td>${project.title}</td>
                                <td>${project.slug || 'غير محدد'}</td>
                                <td>${project.url}</td>
                                <td>
                                    <span class="badge ${project.has_slug ? 'bg-success' : 'bg-danger'}">
                                        ${project.has_slug ? 'متاح' : 'غير متاح'}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });

                        html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    }

                    // Products
                    if (status.products) {
                        html += `
                        <div class="mb-4">
                            <h6 class="text-info">
                                <i class="fas fa-box me-2"></i>المنتجات (${status.products.count})
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>العنوان</th>
                                            <th>Slug</th>
                                            <th>الرابط</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                        status.products.items.forEach(product => {
                            html += `
                            <tr>
                                <td>${product.id}</td>
                                <td>${product.title}</td>
                                <td>${product.slug || 'غير محدد'}</td>
                                <td>${product.url}</td>
                                <td>
                                    <span class="badge ${product.has_slug ? 'bg-success' : 'bg-danger'}">
                                        ${product.has_slug ? 'متاح' : 'غير متاح'}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });

                        html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    }

                    html += `
                    </div>
                </div>
            </div>
        </div>
    `;

                    return html;
                }

                // HTML Generators
                function generateResultsHTML(results) {
                    let html = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>SEO Test Complete
                    </h5>
                    <p class="mb-0">
                        Overall Score: <strong class="${getScoreClass(results.overall_score)}">${results.overall_score}%</strong> 
                        (${results.total_score}/${results.max_score} tests passed)
                    </p>
                </div>
            </div>
        </div>
        
        <div class="row">
    `;

                    Object.entries(results.pages).forEach(([pageName, pageData]) => {
                        if (pageData.tests) {
                            html += generatePageCard(pageName, pageData);
                        }
                    });

                    html += '</div>';

                    if (results.recommendations && typeof results.recommendations === 'object') {
                        html += generateRecommendationsSection(results.recommendations);
                    }

                    return html;
                }

                function generatePageCard(pageName, pageData) {
                    const percentage = pageData.percentage || 0;
                    const scoreClass = getScoreClass(percentage);

                    return `
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card test-result-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-capitalize">${pageName}</h6>
                    <span class="badge ${getBadgeClass(percentage)}">${percentage}%</span>
                </div>
                <div class="card-body">
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar ${getProgressClass(percentage)}" 
                             style="width: ${percentage}%"></div>
                    </div>
                    
                    <div class="test-details">
                        ${pageData.tests.map(test => `
                                                                                                                                                                                                                                                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                                                                                                                                                                                                                                <small class="text-muted">${test.name}</small>
                                                                                                                                                                                                                                                                                                <span class="badge badge-soft-${test.passed ? 'success' : 'danger'} badge-pill">
                                                                                                                                                                                                                                                                                                    ${test.passed ? '✓' : '✗'}
                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                function generateRecommendationsSection(recommendations) {
                    // Safety check
                    if (!recommendations || typeof recommendations !== 'object') {
                        return `
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    No recommendations available
                </div>
            </div>
        </div>
    `;
                    }

                    // Ensure all recommendation arrays exist
                    const highPriority = Array.isArray(recommendations.high_priority) ? recommendations.high_priority :
                        [];
                    const mediumPriority = Array.isArray(recommendations.medium_priority) ? recommendations
                        .medium_priority : [];
                    const lowPriority = Array.isArray(recommendations.low_priority) ? recommendations.low_priority : [];

                    return `
        <div class="row mt-4">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>SEO Recommendations
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-danger">High Priority</h6>
                                <ul class="list-unstyled">
                                    ${highPriority.length > 0 ? 
                                        highPriority.map(item => `<li><i class="fas fa-exclamation-triangle text-danger me-2"></i>${item}</li>`).join('') :
                                        '<li class="text-muted">No high priority issues</li>'
                                    }
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-warning">Medium Priority</h6>
                                <ul class="list-unstyled">
                                    ${mediumPriority.length > 0 ? 
                                        mediumPriority.map(item => `<li><i class="fas fa-exclamation-circle text-warning me-2"></i>${item}</li>`).join('') :
                                        '<li class="text-muted">No medium priority issues</li>'
                                    }
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-info">Low Priority</h6>
                                <ul class="list-unstyled">
                                    ${lowPriority.length > 0 ? 
                                        lowPriority.map(item => `<li><i class="fas fa-info-circle text-info me-2"></i>${item}</li>`).join('') :
                                        '<li class="text-muted">No low priority issues</li>'
                                    }
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                // Utility Functions
                function getScoreClass(score) {
                    if (score >= 80) return 'seo-score-excellent';
                    if (score >= 60) return 'seo-score-good';
                    return 'seo-score-poor';
                }

                function getBadgeClass(score) {
                    if (score >= 80) return 'bg-success';
                    if (score >= 60) return 'bg-warning';
                    return 'bg-danger';
                }

                function getProgressClass(score) {
                    if (score >= 80) return 'bg-success';
                    if (score >= 60) return 'bg-warning';
                    return 'bg-danger';
                }

                function showLoading() {
                    document.getElementById('loadingState').style.display = 'block';
                    document.getElementById('testResults').style.display = 'none';
                }

                function hideLoading() {
                    document.getElementById('loadingState').style.display = 'none';
                    document.getElementById('testResults').style.display = 'block';
                }

                function showError(message) {
                    const container = document.getElementById('testResults');
                    container.innerHTML = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            ${message}
        </div>
    `;
                }

                console.log('✅ All event listeners registered successfully');
            }); // End of DOMContentLoaded
        </script>
    @endpush

</x-dashboard.layout>
