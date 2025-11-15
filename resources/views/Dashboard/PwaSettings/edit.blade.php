<x-dashboard.layout title="{{ __('dashboard.pwa_settings') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('dashboard.edit_pwa_setting') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.home') }}">{{ __('dashboard.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard.pwa-settings.index') }}">{{ __('dashboard.pwa_settings') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.edit_pwa_setting') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('dashboard.edit_pwa_setting') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.pwa-settings.update', $pwaSetting) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <!-- Arabic Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name_ar" class="form-label">{{ __('dashboard.pwa_name_ar') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" name="name_ar" value="{{ old('name_ar', $pwaSetting->name_ar) }}"
                                        required>
                                    @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- English Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name_en" class="form-label">{{ __('dashboard.pwa_name_en') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" name="name_en" value="{{ old('name_en', $pwaSetting->name_en) }}"
                                        required>
                                    @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Arabic Short Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="short_name_ar"
                                        class="form-label">{{ __('dashboard.pwa_short_name_ar') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('short_name_ar') is-invalid @enderror"
                                        id="short_name_ar" name="short_name_ar"
                                        value="{{ old('short_name_ar', $pwaSetting->short_name_ar) }}" required>
                                    @error('short_name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- English Short Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="short_name_en"
                                        class="form-label">{{ __('dashboard.pwa_short_name_en') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('short_name_en') is-invalid @enderror"
                                        id="short_name_en" name="short_name_en"
                                        value="{{ old('short_name_en', $pwaSetting->short_name_en) }}" required>
                                    @error('short_name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Arabic Description -->
                                <div class="col-md-6 mb-3">
                                    <label for="description_ar"
                                        class="form-label">{{ __('dashboard.pwa_description_ar') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                        id="description_ar" name="description_ar" rows="3"
                                        required>{{ old('description_ar', $pwaSetting->description_ar) }}</textarea>
                                    @error('description_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- English Description -->
                                <div class="col-md-6 mb-3">
                                    <label for="description_en"
                                        class="form-label">{{ __('dashboard.pwa_description_en') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description_en') is-invalid @enderror"
                                        id="description_en" name="description_en" rows="3"
                                        required>{{ old('description_en', $pwaSetting->description_en) }}</textarea>
                                    @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Theme Color -->
                                <div class="col-md-6 mb-3">
                                    <label for="theme_color" class="form-label">{{ __('dashboard.pwa_theme_color') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="color" class="form-control @error('theme_color') is-invalid @enderror"
                                        id="theme_color" name="theme_color"
                                        value="{{ old('theme_color', $pwaSetting->theme_color) }}" required>
                                    @error('theme_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Background Color -->
                                <div class="col-md-6 mb-3">
                                    <label for="background_color"
                                        class="form-label">{{ __('dashboard.pwa_background_color') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="color"
                                        class="form-control @error('background_color') is-invalid @enderror"
                                        id="background_color" name="background_color"
                                        value="{{ old('background_color', $pwaSetting->background_color) }}" required>
                                    @error('background_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Start URL -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_url" class="form-label">{{ __('dashboard.pwa_start_url') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('start_url') is-invalid @enderror"
                                        id="start_url" name="start_url"
                                        value="{{ old('start_url', $pwaSetting->start_url) }}" required>
                                    @error('start_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Scope -->
                                <div class="col-md-6 mb-3">
                                    <label for="scope" class="form-label">{{ __('dashboard.pwa_scope') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('scope') is-invalid @enderror"
                                        id="scope" name="scope" value="{{ old('scope', $pwaSetting->scope) }}" required>
                                    @error('scope')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Orientation -->
                                <div class="col-md-6 mb-3">
                                    <label for="orientation" class="form-label">{{ __('dashboard.pwa_orientation') }}
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control @error('orientation') is-invalid @enderror"
                                        id="orientation" name="orientation" required>
                                        <option value="portrait-primary"
                                            {{ old('orientation', $pwaSetting->orientation) == 'portrait-primary' ? 'selected' : '' }}>
                                            عمودي أساسي</option>
                                        <option value="portrait-secondary"
                                            {{ old('orientation', $pwaSetting->orientation) == 'portrait-secondary' ? 'selected' : '' }}>
                                            عمودي ثانوي</option>
                                        <option value="landscape-primary"
                                            {{ old('orientation', $pwaSetting->orientation) == 'landscape-primary' ? 'selected' : '' }}>
                                            أفقي أساسي</option>
                                        <option value="landscape-secondary"
                                            {{ old('orientation', $pwaSetting->orientation) == 'landscape-secondary' ? 'selected' : '' }}>
                                            أفقي ثانوي</option>
                                        <option value="any"
                                            {{ old('orientation', $pwaSetting->orientation) == 'any' ? 'selected' : '' }}>
                                            أي اتجاه</option>
                                    </select>
                                    @error('orientation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Display -->
                                <div class="col-md-6 mb-3">
                                    <label for="display" class="form-label">{{ __('dashboard.pwa_display') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('display') is-invalid @enderror" id="display"
                                        name="display" required>
                                        <option value="standalone"
                                            {{ old('display', $pwaSetting->display) == 'standalone' ? 'selected' : '' }}>
                                            تطبيق منفصل</option>
                                        <option value="fullscreen"
                                            {{ old('display', $pwaSetting->display) == 'fullscreen' ? 'selected' : '' }}>
                                            ملء الشاشة</option>
                                        <option value="minimal-ui"
                                            {{ old('display', $pwaSetting->display) == 'minimal-ui' ? 'selected' : '' }}>
                                            واجهة محدودة</option>
                                        <option value="browser"
                                            {{ old('display', $pwaSetting->display) == 'browser' ? 'selected' : '' }}>
                                            متصفح
                                        </option>
                                    </select>
                                    @error('display')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Language -->
                                <div class="col-md-6 mb-3">
                                    <label for="lang" class="form-label">{{ __('dashboard.pwa_lang') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('lang') is-invalid @enderror" id="lang"
                                        name="lang" required>
                                        <option value="ar"
                                            {{ old('lang', $pwaSetting->lang) == 'ar' ? 'selected' : '' }}>العربية
                                        </option>
                                        <option value="en"
                                            {{ old('lang', $pwaSetting->lang) == 'en' ? 'selected' : '' }}>English
                                        </option>
                                    </select>
                                    @error('lang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Direction -->
                                <div class="col-md-6 mb-3">
                                    <label for="dir" class="form-label">{{ __('dashboard.pwa_dir') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('dir') is-invalid @enderror" id="dir" name="dir"
                                        required>
                                        <option value="rtl"
                                            {{ old('dir', $pwaSetting->dir) == 'rtl' ? 'selected' : '' }}>من اليمين
                                            لليسار
                                        </option>
                                        <option value="ltr"
                                            {{ old('dir', $pwaSetting->dir) == 'ltr' ? 'selected' : '' }}>من اليسار
                                            لليمين
                                        </option>
                                        <option value="auto"
                                            {{ old('dir', $pwaSetting->dir) == 'auto' ? 'selected' : '' }}>تلقائي
                                        </option>
                                    </select>
                                    @error('dir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="status" name="status"
                                            value="1" {{ old('status', $pwaSetting->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            {{ __('dashboard.pwa_active') }}
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">{{ __('dashboard.pwa_shortcuts_help') }}</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('dashboard.pwa-settings.index') }}" class="btn btn-secondary me-2">
                                    {{ __('dashboard.cancel') }}
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
</x-dashboard.layout>