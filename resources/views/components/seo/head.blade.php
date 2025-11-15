@if (!empty($metatags))
    {{-- Basic Meta Tags --}}
    <meta charset="{{ $metatags['charset'] ?? 'utf-8' }}">
    <meta name="viewport" content="{{ $metatags['viewport'] ?? 'width=device-width, initial-scale=1.0' }}">
    <meta http-equiv="Content-Language" content="{{ $metatags['language'] ?? 'en' }}">
    <meta name="robots" content="{{ $metatags['robots'] ?? 'index, follow' }}">
    <meta name="description" content="{{ $metatags['description'] ?? '' }}">
    @if (!empty($metatags['keywords']))
        <meta name="keywords" content="{{ $metatags['keywords'] }}">
    @endif
    <meta name="author" content="{{ $metatags['author'] ?? '' }}">
    <meta name="title" content="{{ $metatags['title'] ?? config('configrations.site_name') }}">
    <title>{{ $metatags['title'] ?? config('configrations.site_name') }}</title>

    @if (!empty($metatags['time']))
        <meta name="time" content="{{ $metatags['time'] }}">
    @endif

    {{-- Security Headers --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains; preload">

    {{-- Canonical --}}
    @if (!empty($metatags['canonical']))
        <link rel="canonical" href="{{ $metatags['canonical'] }}">
    @else
        @php
            $currentUrl = url()->current();
            $currentPath = request()->path();

            // No need to modify - the URL should already be correct from the route

        @endphp
        <link rel="canonical" href="{{ $currentUrl }}">
    @endif


    {{-- Favicon --}}
    <link rel="icon" href="{{ \App\Helper\Path::FavIcon() }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">{{-- Apple Touch Icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon.png') }}">{{-- Microsoft Tiles - Dynamic from Database --}}
    {{-- Microsoft Tiles --}}
    <meta name="msapplication-TileImage" content="{{ asset('favicon.png') }}">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $metatags['og_title'] ?? ($metatags['title'] ?? '') }}">
    <meta property="og:description" content="{{ $metatags['og_description'] ?? ($metatags['description'] ?? '') }}">
    @php
        $ogUrl = url()->current();
        $currentPath = request()->path();

        // No need to modify - the URL should already be correct from the route

    @endphp
    <meta property="og:url" content="{{ $metatags['og_url'] ?? $ogUrl }}">
    <meta property="og:image" content="{{ $metatags['og_image'] ?? asset('images/default-og.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $metatags['og_title'] ?? ($metatags['title'] ?? '') }}">
    <meta property="og:type" content="{{ $metatags['og_type'] ?? 'website' }}">
    <meta property="og:site_name" content="{{ $metatags['og_site_name'] ?? config('configrations.site_name') }}">
    <meta property="og:locale" content="{{ $metatags['og_locale'] ?? app()->getLocale() }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metatags['twitter_title'] ?? ($metatags['title'] ?? '') }}">
    <meta name="twitter:description"
        content="{{ $metatags['twitter_description'] ?? ($metatags['description'] ?? '') }}">
    <meta name="twitter:image" content="{{ $metatags['twitter_image'] ?? asset('images/default-og.jpg') }}">
    <meta name="twitter:url" content="{{ $metatags['twitter_url'] ?? $ogUrl }}">
    @if (!empty($metatags['twitter_site']))
        <meta name="twitter:site" content="{{ $metatags['twitter_site'] }}">
    @endif
    @if (!empty($metatags['twitter_creator']))
        <meta name="twitter:creator" content="{{ $metatags['twitter_creator'] }}">
    @endif

    {{-- Performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">

    {{-- Hreflang Tags --}}
    @php
        $locales = ['ar', 'en'];
        $currentPath = request()->path();
        $pathWithoutLocale = preg_replace('/^(ar|en)\/?/', '', $currentPath);

        // Check if this is a blog page
        if (preg_match('/^blogs?\/(.+)$/', $pathWithoutLocale, $matches)) {
            $currentSlug = urldecode($matches[1]);
            $currentLocale = app()->getLocale();

            // Try to find the blog using current locale first
            $blog = \App\Models\Blog::whereRaw("JSON_EXTRACT(slug, '$.{$currentLocale}') = ?", [$currentSlug])->first();

            // If not found, try all locales
            if (!$blog) {
                foreach (['ar', 'en'] as $lang) {
                    $blog = \App\Models\Blog::whereRaw("JSON_EXTRACT(slug, '$.{$lang}') = ?", [$currentSlug])->first();
                    if ($blog) {
                        break;
                    }
                }
            }

            // If not found with JSON_EXTRACT, try manual search
            if (!$blog) {
                $blogs = \App\Models\Blog::all();
                foreach ($blogs as $b) {
                    foreach (['ar', 'en'] as $lang) {
                        $blogSlug = $b->getTranslation('slug', $lang);
                        if ($blogSlug === $currentSlug) {
                            $blog = $b;
                            break 2;
                        }
                    }
                }
            }

            if ($blog) {
                $generatedUrls = [];

                // Generate URLs for each locale
                foreach ($locales as $locale) {
                    $localizedUrl = $blog->getLocalizedUrl($locale);
                    if ($localizedUrl) {
                        $generatedUrls[$locale] = $localizedUrl;
                        echo '<link rel="alternate" hreflang="' . $locale . '" href="' . $localizedUrl . '" />' . "\n";
                    }
                }

                // Add x-default only if we have Arabic URL (default language)
                if (isset($generatedUrls['ar'])) {
                    echo '<link rel="alternate" hreflang="x-default" href="' . $generatedUrls['ar'] . '" />' . "\n";
                }
            } else {
                // Fallback to simple method if blog not found
                $path = $pathWithoutLocale ? '/' . $pathWithoutLocale : '';
                foreach ($locales as $locale) {
                    echo '<link rel="alternate" hreflang="' .
                        $locale .
                        '" href="' .
                        url('/' . $locale . $path) .
                        '" />' .
                        "\n";
                }
                // Add x-default pointing to Arabic
                echo '<link rel="alternate" hreflang="x-default" href="' . url('/ar' . $path) . '" />' . "\n";
            }
        } elseif (preg_match('/^services\/(.+)$/', $pathWithoutLocale, $matches)) {
            // Handle services pages
            $currentSlug = urldecode($matches[1]);
            $currentLocale = app()->getLocale();

            // Try to find the service using current locale first
            $service = \App\Models\Service::whereRaw("JSON_EXTRACT(slug, '$.{$currentLocale}') = ?", [
                $currentSlug,
            ])->first();

            // If not found, try all locales
            if (!$service) {
                foreach (['ar', 'en'] as $lang) {
                    $service = \App\Models\Service::whereRaw("JSON_EXTRACT(slug, '$.{$lang}') = ?", [
                        $currentSlug,
                    ])->first();
                    if ($service) {
                        break;
                    }
                }
            }

            // If not found with JSON_EXTRACT, try manual search
            if (!$service) {
                $services = \App\Models\Service::all();
                foreach ($services as $s) {
                    foreach (['ar', 'en'] as $lang) {
                        $serviceSlug = $s->getTranslation('slug', $lang);
                        if ($serviceSlug === $currentSlug) {
                            $service = $s;
                            break 2;
                        }
                    }
                }
            }

            if ($service) {
                $generatedUrls = [];

                // Generate URLs for each locale
                foreach ($locales as $locale) {
                    $localizedUrl = $service->getLocalizedUrl($locale);
                    if ($localizedUrl) {
                        $generatedUrls[$locale] = $localizedUrl;
                        echo '<link rel="alternate" hreflang="' . $locale . '" href="' . $localizedUrl . '" />' . "\n";
                    }
                }

                // Add x-default only if we have Arabic URL (default language)
                if (isset($generatedUrls['ar'])) {
                    echo '<link rel="alternate" hreflang="x-default" href="' . $generatedUrls['ar'] . '" />' . "\n";
                }
            } else {
                // Fallback to simple method if service not found
                $path = $pathWithoutLocale ? '/' . $pathWithoutLocale : '';
                foreach ($locales as $locale) {
                    echo '<link rel="alternate" hreflang="' .
                        $locale .
                        '" href="' .
                        url('/' . $locale . $path) .
                        '" />' .
                        "\n";
                }
                // Add x-default pointing to Arabic
                echo '<link rel="alternate" hreflang="x-default" href="' . url('/ar' . $path) . '" />' . "\n";
            }
        } elseif (preg_match('/^products\/(.+)$/', $pathWithoutLocale, $matches)) {
            // Handle products pages
            $currentSlug = urldecode($matches[1]);
            $currentLocale = app()->getLocale();

            // Try to find the product using current locale first
            $product = \App\Models\Product::whereRaw("JSON_EXTRACT(slug, '$.{$currentLocale}') = ?", [
                $currentSlug,
            ])->first();

            // If not found, try all locales
            if (!$product) {
                foreach (['ar', 'en'] as $lang) {
                    $product = \App\Models\Product::whereRaw("JSON_EXTRACT(slug, '$.{$lang}') = ?", [
                        $currentSlug,
                    ])->first();
                    if ($product) {
                        break;
                    }
                }
            }

            // If not found with JSON_EXTRACT, try manual search
            if (!$product) {
                $products = \App\Models\Product::all();
                foreach ($products as $p) {
                    foreach (['ar', 'en'] as $lang) {
                        $productSlug = $p->getTranslation('slug', $lang);
                        if ($productSlug === $currentSlug) {
                            $product = $p;
                            break 2;
                        }
                    }
                }
            }

            if ($product) {
                $generatedUrls = [];

                // Generate URLs for each locale
                foreach ($locales as $locale) {
                    $localizedUrl = $product->getLocalizedUrl($locale);
                    if ($localizedUrl) {
                        $generatedUrls[$locale] = $localizedUrl;
                        echo '<link rel="alternate" hreflang="' . $locale . '" href="' . $localizedUrl . '" />' . "\n";
                    }
                }

                // Add x-default only if we have Arabic URL (default language)
                if (isset($generatedUrls['ar'])) {
                    echo '<link rel="alternate" hreflang="x-default" href="' . $generatedUrls['ar'] . '" />' . "\n";
                }
            } else {
                // Fallback to simple method if product not found
                $path = $pathWithoutLocale ? '/' . $pathWithoutLocale : '';
                foreach ($locales as $locale) {
                    echo '<link rel="alternate" hreflang="' .
                        $locale .
                        '" href="' .
                        url('/' . $locale . $path) .
                        '" />' .
                        "\n";
                }
                // Add x-default pointing to Arabic
                echo '<link rel="alternate" hreflang="x-default" href="' . url('/ar' . $path) . '" />' . "\n";
            }
        } else {
            // For non-blog pages, use the simple method
            $path = $pathWithoutLocale ? '/' . $pathWithoutLocale : '';
            foreach ($locales as $locale) {
                echo '<link rel="alternate" hreflang="' .
                    $locale .
                    '" href="' .
                    url('/' . $locale . $path) .
                    '" />' .
                    "\n";
            }
            // Add x-default pointing to Arabic
            echo '<link rel="alternate" hreflang="x-default" href="' . url('/ar' . $path) . '" />' . "\n";
        }
    @endphp

    {{-- Google Tag Manager --}}
    @if (config('settings.google_tag_manager_id'))
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer',
                '{{ config('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    settings.google_tag_manager_id ') }}'
            );
        </script>
    @endif

    {{-- Google Analytics --}}
    @if (config('settings.google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('settings.google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config',
                '{{ config('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            settings.google_analytics_id ') }}'
            );
        </script>
    @endif
@endif

{{-- Schema JSON-LD --}}
@if (!empty($schema))
    <script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@else
    {{-- Default WebPage Schema (safe encoding) --}}
    @php
        $schemaUrl = url()->current();
        $currentPath = request()->path();

        // No need to modify - the URL should already be correct from the route

    @endphp
    <script type="application/ld+json">
{!! json_encode([
'@context' => 'https://schema.org',
'@type' => 'WebPage',
'name' => $metatags['title'] ?? config('configrations.site_name'),
'url' => $metatags['canonical'] ?? $schemaUrl,
'description' => $metatags['description'] ?? ''
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

{{-- Always include Organization/LocalBusiness Schema on all pages --}}

{{-- FAQ Schema --}}
@if (!empty($faq_schema))
    <script type="application/ld+json">
{!! json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

{{-- Breadcrumb Schema --}}
@if (!empty($breadcrumb_schema))
    <script type="application/ld+json">
{!! json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

{{-- Google Tag Manager --}}
@if (config('settings.google_tag_manager_id'))
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer',
            '{{ config('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        settings.google_tag_manager_id ') }}'
        );
    </script>
@endif

{{-- Google Analytics --}}
@if (config('settings.google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('settings.google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config',
            '{{ config('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        settings.google_analytics_id ') }}'
        );
    </script>
@endif

{{-- Organization/LocalBusiness Schema - Only show if no page-specific schema --}}
@if (empty($schema))
    @php
        // Build Organization/LocalBusiness Schema
        $defaultOrgSchema = [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'LocalBusiness', 'MedicalBusiness'],
            'name' => config('configrations.site_name') ?? 'DHI Egypt',
            'description' =>
                config('configrations.site_description') ??
                'تقدم DHI خدمات متكاملة لزراعة الشعر واللحية باستخدام احدث التقنيات علي مستوي العالم',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(\App\Helper\Path::AppLogo()),
            ],
            'image' => asset(\App\Helper\Path::AppLogo()),
            'priceRange' => '$$-$$$',
        ];

        // Add sameAs only if social media URLs exist
        $sameAs = array_values(
            array_filter(
                [
                    config('settings.site_facebook'),
                    config('settings.site_twitter'),
                    config('settings.site_linkedin'),
                    config('settings.site_instagram'),
                    config('settings.site_youtube'),
                    config('settings.site_tiktok'),
                ],
                function ($url) {
                    return !empty($url) && $url !== '#' && filter_var($url, FILTER_VALIDATE_URL);
                },
            ),
        );

        if (!empty($sameAs)) {
            $defaultOrgSchema['sameAs'] = $sameAs;
        }

        // Add contactPoint only if phone exists
        $phone = config('settings.site_phone') ?? config('settings.site_whatsapp');
        if (!empty($phone)) {
            $defaultOrgSchema['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => 'customer service',
                'availableLanguage' => ['Arabic', 'English'],
            ];
        }

        // Add all active addresses from SiteAddress model
        $siteAddresses = \App\Models\SiteAddress::where('status', true)->orderBy('order')->get();

        if ($siteAddresses->isNotEmpty()) {
            $locations = [];
            $allPhones = [];

            foreach ($siteAddresses as $siteAddress) {
                if (!empty($siteAddress->address)) {
                    // Create location with Place object (proper schema.org way)
                    $locationSchema = [
                        '@type' => 'Place',
                        'name' => $siteAddress->title ?? null,
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => $siteAddress->address,
                        ],
                    ];

                    // Add map link if exists (use map_link instead of map_url for direct Google Maps link)
                    if (!empty($siteAddress->map_link)) {
                        $locationSchema['hasMap'] = $siteAddress->map_link;
                    }

                    $locations[] = $locationSchema;

                    // Collect phone numbers from all addresses
                    if (!empty($siteAddress->phone) && strlen($siteAddress->phone) > 3) {
                        $allPhones[] = $siteAddress->phone;
                    }
                    if (!empty($siteAddress->phone2) && strlen($siteAddress->phone2) > 3) {
                        $allPhones[] = $siteAddress->phone2;
                    }
                }
            }

            // Add locations to schema - if single location, add as object; if multiple, add as array
            if (count($locations) === 1) {
                $defaultOrgSchema['location'] = $locations[0];
            } elseif (count($locations) > 1) {
                $defaultOrgSchema['location'] = $locations;
            }

            // Add all phone numbers if exist
            if (!empty($allPhones)) {
                $defaultOrgSchema['telephone'] = array_unique($allPhones);
            }
        }

        // Add areaServed only if exists
        $areaServed = config('settings.site_area_served');
        if (!empty($areaServed)) {
            $defaultOrgSchema['areaServed'] = is_array($areaServed) ? $areaServed : explode(',', $areaServed);
        }

        // Add foundingDate only if exists
        $foundingDate = config('settings.site_founding_date');
        if (!empty($foundingDate)) {
            $defaultOrgSchema['foundingDate'] = $foundingDate;
        }

        // Add founder only if exists
        $founder = config('settings.site_founder');
        if (!empty($founder)) {
            $defaultOrgSchema['founder'] = [
                '@type' => 'Person',
                'name' => $founder,
            ];
        }

        $defaultWebsiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('configrations.site_name') ?? 'ميبيكوم',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    @endphp

    {{-- Organization/LocalBusiness Schema --}}
    <script type="application/ld+json">
{!! json_encode($defaultOrgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

    {{-- WebSite Schema --}}
    <script type="application/ld+json">
{!! json_encode($defaultWebsiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif



{{-- Lazy Loading Images --}}
<script>
    // Lazy loading for images
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('img').forEach(function(img) {
            img.setAttribute('loading', 'lazy');
        });
    });
</script>

{{-- Web Vitals --}}
<script src="https://unpkg.com/web-vitals@3/dist/web-vitals.iife.js" crossorigin type="text/javascript"></script>
<script>
    window.addEventListener('load', function() {
        if (typeof webVitals !== 'undefined') {
            try {
                // CLS - Cumulative Layout Shift
                webVitals.getCLS(function(metric) {
                    console.log('CLS:', metric);
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Performance',
                            'event_label': 'CLS',
                            'value': Math.round(metric.value * 1000),
                            'custom_parameter_1': metric.rating,
                            'custom_parameter_2': window.location.pathname
                        });
                    }

                    fetch('/dashboard/performance/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            metric: 'CLS',
                            value: metric.value,
                            rating: metric.rating,
                            page: window.location.pathname
                        })
                    }).catch(error => console.log('Performance data not sent:', error));
                });

                // FID - First Input Delay
                webVitals.getFID(function(metric) {
                    console.log('FID:', metric);
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Performance',
                            'event_label': 'FID',
                            'value': Math.round(metric.value)
                        });
                    }
                });

                // LCP - Largest Contentful Paint
                webVitals.getLCP(function(metric) {
                    console.log('LCP:', metric);
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Performance',
                            'event_label': 'LCP',
                            'value': Math.round(metric.value)
                        });
                    }
                });

                // FCP - First Contentful Paint
                webVitals.getFCP(function(metric) {
                    console.log('FCP:', metric);
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Performance',
                            'event_label': 'FCP',
                            'value': Math.round(metric.value)
                        });
                    }
                });

                // TTFB - Time to First Byte
                webVitals.getTTFB(function(metric) {
                    console.log('TTFB:', metric);
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Performance',
                            'event_label': 'TTFB',
                            'value': Math.round(metric.value)
                        });
                    }
                });
            } catch (error) {
                console.warn('Web Vitals error:', error);
            }
        } else {
            console.warn('Web Vitals library not loaded');
        }
    });
</script>
