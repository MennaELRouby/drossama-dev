<!-- Mobile Menu  -->
<div class="mobile-menu">
    <div class="menu-backdrop"></div>
    <div class="close-btn"><i class="fas fa-times"></i></div>

    <nav class="menu-box">
        <div class="nav-logo">
            <a href="{{ Path::AppUrl('/') }}">
                <img src="{{ Path::AppLogo('site_logo') }}" class="logo_main" alt="logo" width="25" height="25"
                    loading="lazy">
            </a>
        </div>
        <div class="menu-outer">
        </div>

        <!-- Language Switcher for Mobile -->
        @php
            use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
            $currentLocale = LaravelLocalization::getCurrentLocale();
            $supportedLocales = LaravelLocalization::getSupportedLocales();
            $flags = [
                'ar' => '🇸🇦',
                'en' => '🇺🇸',
                'fr' => '🇫🇷',
                'de' => '🇩🇪',
                'es' => '🇪🇸',
            ];
        @endphp

        @if (count($supportedLocales) > 1)
            <div class="mobile-language-switcher">
                <h4>{{ __('website.language') ?? 'Language' }}</h4>
                <ul class="language-list">
                    @foreach ($supportedLocales as $code => $language)
                        <li class="{{ $code === $currentLocale ? 'active' : '' }}">
                            <a hreflang="{{ $code }}"
                                href="{{ \App\Helpers\LocalizationHelper::getCurrentPageLocalizedUrl($code) }}"
                                dir="{{ $language['script'] === 'Arab' ? 'rtl' : 'ltr' }}">
                                <span class="flag">{{ $flags[$code] ?? '🌐' }}</span>
                                <span class="lang-name">{{ $language['native'] }}</span>
                                @if ($code === $currentLocale)
                                    <i class="fas fa-check"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contact-info">
            <h4>{{ __('website.contact_us') }}</h4>
            <ul>
                @if (isset($site_addresses) && is_iterable($site_addresses))
                    @foreach ($site_addresses as $address)
                        <li><a href="{{ $address->map_link ?? '#' }}"
                                target="_blank">{{ $address->address ?? '' }}</a>
                        </li>
                    @endforeach
                @endif
                @if (isset($phones) && is_iterable($phones))
                    @foreach ($phones as $phone)
                        <li><a href="tel:{{ $phone->code ?? '' }}{{ $phone->phone ?? '' }}"
                                aria-label="Mobile Number">{{ $phone->phone ?? '' }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="social-links">
            <ul class="clearfix">
                @foreach ($socialMediaLinks as $platform => $link)
                    @if ($link && $link != '#')
                        <li><a href="{{ $link }}" target="_blank"><i
                                    class="fab fa-{{ $platform }}"></i></a></li>
                    @endif
                @endforeach

            </ul>
        </div>
    </nav>

</div>
<!-- End Mobile Menu -->
