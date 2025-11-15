<x-dashboard.layout title="{{ __('dashboard.seo_assistant') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('dashboard.seo_assistant') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.seo_assistant') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">{{ __('dashboard.seo_settings') }}</h5>
                            <a href="{{ route('dashboard.seo-assistants.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> {{ __('dashboard.edit') }}
                            </a>
                        </div>

                        @if ($seo)
                            @php
                                $pages = [
                                    'home' => __('dashboard.home_page'),
                                    'about' => __('dashboard.about_page'),
                                    'contact' => __('dashboard.contact_page'),
                                    'blog' => __('dashboard.blog_page'),
                                    'service' => __('dashboard.service_page'),
                                    'products' => __('dashboard.products'),
                                ];
                                $langs = ['en' => __('dashboard.english'), 'ar' => __('dashboard.arabic')];
                            @endphp
                            <div class="row">
                                @foreach ($pages as $key => $label)
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h6 class="card-title text-primary">{{ $label }}</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($langs as $langKey => $langLabel)
                                                    <div class="mb-2">
                                                        <strong>{{ __('dashboard.meta_title') }}
                                                            ({{ $langLabel }}):</strong>
                                                        <p class="text-muted">
                                                            {{ $seo->{$key . '_meta_title_' . $langKey} ?? '-' }}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>{{ __('dashboard.meta_description') }}
                                                            ({{ $langLabel }}):</strong>
                                                        <p class="text-muted">
                                                            {{ $seo->{$key . '_meta_desc_' . $langKey} ?? '-' }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">{{ __('dashboard.no_seo_settings_found') }}</p>
                                <a href="{{ route('dashboard.seo-assistants.edit') }}" class="btn btn-primary">
                                    {{ __('dashboard.create_seo_settings') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layout>
