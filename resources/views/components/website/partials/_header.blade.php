<!--=============== Heder ============= -->
<header class="main-header header-style-six">
    <!-- Main box -->
    <div class="main-box">
        <div class="logo-box">
            <div class="logo"><a href="{{ Path::AppUrl('/') }}"><img src="{{ Path::AppLogo('site_logo') }}" alt="AppLogo"
                        title="AppLogo"></a></div>
        </div>
        <!--Nav Box-->
        <div class="nav-outer">
            <nav class="nav main-menu">
                <ul class="navigation">
                    <x-website.partials.mainmenu :menus="$menus" />
                    @foreach ($languages as $language)
                        @if ($language->code !== app()->getLocale())
                            <li>
                                <a href="{{ $language->url }}">{{ $language->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- Main Menu End-->
                <div class="outer-box">
                    <!-- Info Btn -->
                    @php
                        $whatsappPhone = $phones->where('type', 'whatsapp')->first();
                    @endphp
                    @if ($whatsappPhone)
                        <a href="https://wa.me/{{ $whatsappPhone->code ?? '' }}{{ $whatsappPhone->phone ?? '' }}"
                            class="info-btn">
                            <h3>{{ __('website.contact_us') }}</h3>
                        </a>
                    @endif
                    <!-- Mobile Navigation Toggler -->
                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                </div>
        </div>
    </div>
    <!-- Mobile Menu  -->
    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="upper-box">
                <div class="nav-logo"><a href="{{ Path::AppUrl('/') }}"><img src="{{ Path::AppLogo('site_logo') }}"
                            alt="AppLogo" title="AppLogo"></a>
                </div>
                <div class="close-btn"><i class="icon fa fa-times"></i></div>
            </div>
            <ul class="navigation clearfix">
                <!--Keep This Empty / Menu will come through Javascript-->
            </ul>
            <ul class="contact-list-one">
                @foreach ($phones as $phone)
                    @if ($phone->type == 'phone')
                        <li>
                            <i class="icon lnr-icon-phone-handset"></i>
                            <span class="title">{{ $phone->name }}</span>
                            <div class="text"><a
                                    href="tel:{{ $phone->code }}{{ $phone->phone }}">{{ $phone->code }}{{ $phone->phone }}</a>
                            </div>
                        </li>
                    @endif
                @endforeach
                <li>
                    <i class="icon lnr-icon-envelope1"></i>
                    <span class="title">{{ __('website.email') }}</span>
                    <div class="text"><a
                            href="mailto:{{ config('settings.site_email') }}">{{ config('settings.site_email') }}</a>
                    </div>
                </li>
                @foreach ($site_addresses as $address)
                    <li>
                        <i class="icon lnr-icon-map-marker"></i>
                        <span class="title">{{ $address->title }}</span>
                        <div class="text"><a href="{{ $address->map_link }}"
                                target="_blank">{{ $address->address }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
            <ul class="social-links">
                @foreach ($socialMediaLinks as $platform => $link)
                    <li><a href="{{ $link }}" target="_blank" rel="noopener"><i
                                class="fab fa-{{ $platform }}"></i></a></li>
                @endforeach
            </ul>
        </nav>
    </div>
    <!-- End Mobile Menu -->
    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container">
            <div class="inner-container">
                <!--Logo-->
                <div class="logo">
                    <a href="{{ Path::AppUrl('/') }}" title=""><img src="{{ Path::AppLogo('site_logo') }}"
                            alt="logo" title="logo"></a>
                </div>

                <!--Right Col-->
                <div class="nav-outer">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->

                    <div class="outer-box">
                        <!-- Info Btn -->
                        @php
                            $whatsappPhone2 = $phones->where('type', 'whatsapp')->first();
                        @endphp
                        @if ($whatsappPhone2)
                            <a href="https://wa.me/{{ $whatsappPhone2->code ?? '' }}{{ $whatsappPhone2->phone ?? '' }}"
                                class="info-btn">
                                <h3>{{ __('website.contact_us') }}</h3>
                            </a>
                        @endif
                        <!-- Mobile Navigation Toggler -->
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Sticky Menu -->
</header>
<!--=============== Heder ============= -->
<div class="hidden-bar-back-drop"></div>
<!--=============== Heder ============= -->
<section class="hidden-bar">
    <div class="inner-box">
        <div class="upper-box">
            <div class="nav-logo"><a href="{{ Path::AppUrl('/') }}"><img src="{{ Path::AppLogo('site_logo') }}"
                        alt="AppLogo" title="AppLogo"></a>
            </div>
            <div class="close-btn"><i class="icon fa fa-times"></i></div>
        </div>

        <ul class="contact-list-one">
            @php
                $mainPhone = $phones->where('type', 'phone')->first();
            @endphp
            @if ($mainPhone)
                <li>
                    <i class="icon lnr-icon-phone-handset"></i>
                    <span class="title">{{ __('website.contact_us') }}</span>
                    <div class="text"><a
                            href="tel:{{ $mainPhone->code ?? '' }}{{ $mainPhone->phone ?? '' }}">{{ $mainPhone->code ?? '' }}{{ $mainPhone->phone ?? '' }}</a>
                    </div>
                </li>
            @endif
            <li>
                <i class="icon lnr-icon-envelope1"></i>
                <span class="title">{{ __('website.email') }}</span>
                <div class="text"><a
                        href="mailto:{{ config('settings.site_email') }}">{{ config('settings.site_email') }}</a>
                </div>
            </li>
            @if ($site_addresses && $site_addresses->isNotEmpty())
                <li>
                    <i class="icon lnr-icon-map-marker"></i>
                    <span class="title">{{ __('website.addresses') }}</span>
                    <div class="text"><a href="{{ $site_addresses->first()->map_link ?? '#' }}"
                            target="_blank">{{ $site_addresses->first()->address ?? '' }}</a>
                    </div>
                </li>
            @endif
        </ul>

        <ul class="social-links">
            @foreach ($socialMediaLinks as $platform => $link)
                <li><a href="{{ $link }}" target="_blank" rel="noopener"><i
                            class="fab fa-{{ $platform }}"></i></a></li>
            @endforeach
        </ul>
    </div>
</section>
<!--=============== Heder ============= -->
