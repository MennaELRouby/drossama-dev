@props([
    'name',
    'type' => 'text',
    'required' => false,
    'model' => null,
    'placeholder' => null,
    'class' => 'form-control',
    'rows' => null,
])

@php
    // Get languages that should be shown in forms
    $formLanguages = config('app.form_languages', ['en', 'ar', 'fr']);

    // Get language data for form languages only
    $allLanguages = config('laravellocalization.supportedLocales');
    $supportedLanguages = array_intersect_key($allLanguages, array_flip($formLanguages));

    // Define language display names
    $languageNames = [
        'en' => 'English',
        'ar' => 'العربية',
        'fr' => 'Français',
        'de' => 'Deutsch',
    ];
@endphp

<div class="row">
    @foreach ($supportedLanguages as $langCode => $langData)
        <div class="form-group col-md-{{ count($supportedLanguages) > 2 ? '4' : '6' }}">
            <label class="">
                {{ __('dashboard.' . $name . '_' . $langCode) }}
                @if ($required && $langCode === 'en')
                    <span class="text-danger">*</span>
                @endif
            </label>

            @if ($type === 'textarea')
                <textarea class="{{ $class }}" name="{{ $name }}_{{ $langCode }}"
                    @if ($rows) rows="{{ $rows }}" @endif
                    placeholder="{{ $placeholder ?? __('dashboard.' . $name . '_' . $langCode) }}"
                    @if ($required && $langCode === 'en') required @endif>{{ old($name . '_' . $langCode, $model ? $model->getTranslation($name, $langCode) : '') }}</textarea>
            @elseif($type === 'editor')
                <textarea class="{{ $class }}" name="{{ $name }}_{{ $langCode }}"
                    id="{{ $name }}_{{ $langCode }}_editor" rows="{{ $rows ?? 10 }}"
                    placeholder="{{ $placeholder ?? __('dashboard.' . $name . '_' . $langCode) }}">{{ old($name . '_' . $langCode, $model ? $model->getTranslation($name, $langCode) : '') }}</textarea>
            @else
                <input class="{{ $class }}" name="{{ $name }}_{{ $langCode }}"
                    type="{{ $type }}"
                    value="{{ old($name . '_' . $langCode, $model ? $model->getTranslation($name, $langCode) : '') }}"
                    placeholder="{{ $placeholder ?? __('dashboard.' . $name . '_' . $langCode) }}"
                    @if ($required && $langCode === 'en') required @endif>
            @endif

            <small class="text-muted">{{ $languageNames[$langCode] ?? $langData['native'] }}</small>
        </div>
    @endforeach
</div>
