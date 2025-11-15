<x-dashboard.layout title="{{ __('dashboard.pwa_settings') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('dashboard.pwa_settings') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.pwa_settings') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('dashboard.pwa_settings') }}</h5>
                            <div>
                                <a href="{{ route('dashboard.pwa-settings.edit', $pwaSetting) }}"
                                    class="btn btn-primary me-2">
                                    <i class="fas fa-edit"></i> {{ __('dashboard.edit') }}
                                </a>
                                <a href="{{ url('/manifest.json') }}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-file-code"></i> {{ __('dashboard.view_manifest') }}
                                </a>
                                <form action="{{ route('dashboard.pwa-settings.regenerate-icons') }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('{{ __('dashboard.confirm_regenerate_icons') }}')">
                                        <i class="fas fa-sync-alt"></i> {{ __('dashboard.regenerate_icons') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Arabic Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_name_ar') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->name_ar }}</p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_short_name_ar') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->short_name_ar }}</p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_description_ar') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->description_ar }}</p>
                            </div>

                            <!-- English Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_name_en') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->name_en }}</p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_short_name_en') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->short_name_en }}</p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_description_en') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->description_en }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- Technical Settings -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_theme_color') }}</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="color-preview me-2"
                                        style="width: 30px; height: 30px; background-color: {{ $pwaSetting->theme_color }}; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                    <span>{{ $pwaSetting->theme_color }}</span>
                                </div>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_background_color') }}</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="color-preview me-2"
                                        style="width: 30px; height: 30px; background-color: {{ $pwaSetting->background_color }}; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                    <span>{{ $pwaSetting->background_color }}</span>
                                </div>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_start_url') }}</h6>
                                <p class="mb-3"><code>{{ $pwaSetting->start_url }}</code></p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_scope') }}</h6>
                                <p class="mb-3"><code>{{ $pwaSetting->scope }}</code></p>
                            </div>

                            <!-- Display Settings -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_orientation') }}</h6>
                                <p class="mb-3">
                                    @php
                                        $orientationLabels = [
                                            'portrait-primary' => 'عمودي أساسي',
                                            'portrait-secondary' => 'عمودي ثانوي',
                                            'landscape-primary' => 'أفقي أساسي',
                                            'landscape-secondary' => 'أفقي ثانوي',
                                            'any' => 'أي اتجاه',
                                        ];
                                    @endphp
                                    {{ $orientationLabels[$pwaSetting->orientation] ?? $pwaSetting->orientation }}
                                </p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_display') }}</h6>
                                <p class="mb-3">
                                    @php
                                        $displayLabels = [
                                            'standalone' => 'تطبيق منفصل',
                                            'fullscreen' => 'ملء الشاشة',
                                            'minimal-ui' => 'واجهة محدودة',
                                            'browser' => 'متصفح',
                                        ];
                                    @endphp
                                    {{ $displayLabels[$pwaSetting->display] ?? $pwaSetting->display }}
                                </p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_lang') }}</h6>
                                <p class="mb-3">{{ $pwaSetting->lang == 'ar' ? 'العربية' : 'English' }}</p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_dir') }}</h6>
                                <p class="mb-3">
                                    @php
                                        $dirLabels = [
                                            'rtl' => 'من اليمين لليسار',
                                            'ltr' => 'من اليسار لليمين',
                                            'auto' => 'تلقائي',
                                        ];
                                    @endphp
                                    {{ $dirLabels[$pwaSetting->dir] ?? $pwaSetting->dir }}
                                </p>

                                <h6 class="text-primary mb-3">{{ __('dashboard.pwa_status') }}</h6>
                                @if ($pwaSetting->status)
                                    <span class="badge bg-success">{{ __('dashboard.pwa_active') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('dashboard.pwa_inactive') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layout>
