<x-dashboard.layout title="{{ __('dashboard.edit_seo_assistant') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('dashboard.edit_seo_assistant') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.seo-assistants.index') }}">{{ __('dashboard.seo_assistant') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.edit') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <form action="{{ route('dashboard.seo-assistants.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row">
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
                                @foreach ($pages as $key => $label)
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title text-primary mb-0">{{ $label }}</h5>
                                                    <button type="button" class="btn btn-sm btn-info generate-seo-btn"
                                                        data-page="{{ $key }}" data-bs-toggle="tooltip"
                                                        title="{{ __('dashboard.generate_seo_content') }}">
                                                        <i class="fas fa-magic"></i> {{ __('dashboard.generate') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($langs as $langKey => $langLabel)
                                                    <div class="mb-3">
                                                        <label
                                                            for="{{ $key }}_meta_title_{{ $langKey }}"
                                                            class="form-label">
                                                            {{ __('dashboard.meta_title') }} ({{ $langLabel }}) *
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control @error($key . '_meta_title_' . $langKey) is-invalid @enderror"
                                                                id="{{ $key }}_meta_title_{{ $langKey }}"
                                                                name="{{ $key }}_meta_title_{{ $langKey }}"
                                                                value="{{ old($key . '_meta_title_' . $langKey, $seo->{$key . '_meta_title_' . $langKey} ?? '') }}"
                                                                placeholder="{{ __('dashboard.enter_meta_title') }}">
                                                            <button type="button"
                                                                class="btn btn-outline-info generate-field-btn"
                                                                data-page="{{ $key }}"
                                                                data-lang="{{ $langKey }}" data-field="title">
                                                                <i class="fas fa-wand-magic-sparkles"></i>
                                                            </button>
                                                        </div>
                                                        @error($key . '_meta_title_' . $langKey)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="{{ $key }}_meta_desc_{{ $langKey }}"
                                                            class="form-label">
                                                            {{ __('dashboard.meta_description') }}
                                                            ({{ $langLabel }}) *
                                                        </label>
                                                        <div class="input-group">
                                                            <textarea class="form-control @error($key . '_meta_desc_' . $langKey) is-invalid @enderror"
                                                                id="{{ $key }}_meta_desc_{{ $langKey }}" name="{{ $key }}_meta_desc_{{ $langKey }}"
                                                                rows="3" placeholder="{{ __('dashboard.enter_meta_description') }}">{{ old($key . '_meta_desc_' . $langKey, $seo->{$key . '_meta_desc_' . $langKey} ?? '') }}</textarea>
                                                            <button type="button"
                                                                class="btn btn-outline-info generate-field-btn"
                                                                data-page="{{ $key }}"
                                                                data-lang="{{ $langKey }}"
                                                                data-field="description">
                                                                <i class="fas fa-wand-magic-sparkles"></i>
                                                            </button>
                                                        </div>
                                                        @error($key . '_meta_desc_' . $langKey)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-end mt-3">
                                <a href="{{ route('dashboard.seo-assistants.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('dashboard.back') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('dashboard.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Generate SEO content for entire page
                document.querySelectorAll('.generate-seo-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const page = this.dataset.page;
                        generateSEOContent(page);
                    });
                });

                // Generate individual field content
                document.querySelectorAll('.generate-field-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const page = this.dataset.page;
                        const lang = this.dataset.lang;
                        const field = this.dataset.field;
                        generateFieldContent(page, lang, field);
                    });
                });

                function generateSEOContent(page) {
                    // Show loading state
                    Swal.fire({
                        title: '{{ __('dashboard.generating_content') }}',
                        html: '{{ __('dashboard.please_wait') }}',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make API call
                    fetch('{{ route('dashboard.seo.generate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                page: page
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update form fields
                                Object.keys(data.content).forEach(lang => {
                                    document.getElementById(`${page}_meta_title_${lang}`).value = data
                                        .content[lang].title;
                                    document.getElementById(`${page}_meta_desc_${lang}`).value = data
                                        .content[lang].description;
                                });

                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('dashboard.success') }}',
                                    text: '{{ __('dashboard.content_generated_successfully') }}',
                                    timer: 1500
                                });
                            } else {
                                throw new Error(data.message || '{{ __('dashboard.generation_failed') }}');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('dashboard.error') }}',
                                text: error.message
                            });
                        });
                }

                function generateFieldContent(page, lang, field) {
                    // Show loading state
                    const button = event.target.closest('button');
                    const originalHtml = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;

                    // Make API call
                    fetch('{{ route('dashboard.seo.generate-field') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                page,
                                lang,
                                field
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update specific field
                                const fieldId = `${page}_meta_${field}_${lang}`;
                                document.getElementById(fieldId).value = data.content;

                                // Show success indicator
                                button.innerHTML = '<i class="fas fa-check text-success"></i>';
                                setTimeout(() => {
                                    button.innerHTML = originalHtml;
                                    button.disabled = false;
                                }, 1000);
                            } else {
                                throw new Error(data.message || '{{ __('dashboard.generation_failed') }}');
                            }
                        })
                        .catch(error => {
                            // Show error indicator
                            button.innerHTML = '<i class="fas fa-times text-danger"></i>';
                            setTimeout(() => {
                                button.innerHTML = originalHtml;
                                button.disabled = false;
                            }, 1000);

                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('dashboard.error') }}',
                                text: error.message
                            });
                        });
                }
            });
        </script>
    @endpush
</x-dashboard.layout>
