<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <x-website.partials._head />

    <!-- Page specific styles -->
    @stack('styles')
</head>

<body>
    <div class="page-wrapper">
        <x-website.partials._header />
        {{-- <x-website.partials.mobilemenu /> --}}
        <!-- start Page Content -->
        {{ $slot }}
        <!-- end Page Content -->
        <x-website.partials._footer />
    </div>
    <!-- social media -->
    {{-- <x-website.partials.social-media /> --}}

    <!-- PWA Install Prompt -->
    {{-- <x-website.pwa-install-prompt /> --}}

    <!-- javascript libraries -->
    <x-website.partials._script />

    <!-- Page specific scripts -->
    @stack('scripts')

    {{-- Google Tag Manager (noscript) --}}
    @if (config('settings.google_tag_manager_id'))
        <noscript><iframe
                src="https://www.googletagmanager.com/ns.html?id={{ config('settings.google_tag_manager_id') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    {{-- End Google Tag Manager (noscript) --}}

</body>

</html>
