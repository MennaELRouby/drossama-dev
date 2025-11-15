<!-- SEO Component - This includes all meta tags, title, hreflang, and schema -->
@if (isset($metatags) && isset($schema))
    <x-seo.head :metatags="$metatags" :schema="$schema" />
@else
    {{-- Basic SEO for pages without metatags - Using SEO component with default values --}}
    @php
        $defaultMetatags = [
            'charset' => 'utf-8',
            'viewport' => 'width=device-width, initial-scale=1.0',
            'language' => app()->getLocale(),
            'robots' => 'index, follow',
            'description' => config('configrations.site_description') ?? 'About My Company',
            'author' => config('configrations.site_name') ?? 'My Company',
            'title' => config('configrations.site_name') ?? 'My Company',
        ];

        $defaultSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => config('configrations.site_name') ?? 'My Company',
            'url' => url()->current(),
        ];
    @endphp
    <x-seo.head :metatags="$defaultMetatags" :schema="$defaultSchema" />
@endif



<!-- ======== CSS & Libraries ============ -->
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@php
    $currentLocale = app()->getLocale();
    $isRTL = in_array($currentLocale, ['ar', 'he', 'fa', 'ur']); // RTL languages
    $textDirection = $isRTL ? 'rtl' : 'ltr';
@endphp

{{-- Set HTML lang and dir attributes --}}
<script>
    document.documentElement.setAttribute('lang', '{{ $currentLocale }}');
    document.documentElement.setAttribute('dir', '{{ $textDirection }}');
</script>

{{-- PWA Meta Tags --}}
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#007bff">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="{{ config('configrations.site_name') ?? 'DHI Egypt' }}">
<link rel="apple-touch-icon" href="/favicon.png">

{{-- Service Worker Registration --}}
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('Service Worker registered successfully:', registration.scope);
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        });
    }
</script>



{{-- @if ($isRTL)
   <!-- RTL CSS for Arabic and other RTL languages -->
    <link href="{{ Path::css('rtl.css') }}" rel="stylesheet">
@else
   <!-- LTR CSS for English and other LTR languages -->
    <link href="{{ Path::css('style.css') }}" rel="stylesheet">
@endif --}}



<!-- ======== End CSS & Libraries ============ -->
    <link href="{{ Path::css('gallery.css') }}" rel="stylesheet">
    <link href="{{ Path::css('style.css') }}" rel="stylesheet">
    <link href="{{ Path::css('custom-styles.css') }}" rel="stylesheet">
    <link href="{{ Path::css('slider-styles.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="{{ Path::imagesPath('favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ Path::imagesPath('favicon.png') }}" type="image/x-icon">
    <!-- إضافة Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://www.google.com/recaptcha/api.js?render=6LdeLzorAAAAAMvTCrzG6elKzSZDEBD-pW_nhnj_"></script>
    
    @if ($isRTL)
        <link href="{{ Path::css('style-rtl.css') }}" rel="stylesheet">
    @else
        <link href="{{ Path::css('style-dark.css') }}" rel="stylesheet">
    @endif



        <script>
        var swiper = new Swiper('.main-swiper', {
            effect: 'fade',
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            fadeEffect: { crossFade: true },
            speed: 900
        });
    </script>