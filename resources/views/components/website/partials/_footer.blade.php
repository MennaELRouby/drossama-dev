<!--====================Site Footer==============-->
<footer class="main-footer footer-style-one">
    <div class="footer-upper">
        <div class="auto-container">
            <div class="outer-box">
                <div class="upper-left">
                    <div class="logo"><a href="{{ Path::AppUrl('/') }}"><img src="{{ Path::AppLogo('site_logo') }}"
                                alt="Logo" title="Archisky"></a></div>
                </div>
                <div class="upper-right">
                    <ul class="footer-social-icons">
                        <li>{{ __('website.follow_us_on') }}:</li>
                        @foreach ($socialMediaLinks as $platform => $link)
                            <li><a href="{{ $link }}" target="_blank" rel="noopener"><i
                                        class="fab fa-{{ $platform }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="widgets-section">
        <div class="auto-container">
            <div class="row">
                <!-- Footer Column -->
                <div class="footer-column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget about-widget">
                        <h4 class="widget-title">{{ __('website.about_us') }}</h4>
                        <div class="widget-content">
                            <div class="text">
                                <p>{{ config('settings.site_description') }}</p>
                            </div>
                            <!-- Search -->
                        </div>
                    </div>
                </div>
                <!-- Footer Column -->
                <div class="footer-column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget services-widget">
                        <h4 class="widget-title">{{ __('website.quick_links') }}</h4>
                        <div class="widgets-content">
                            <ul class="user-links style-two light">
                                @foreach ($footerMenus as $menu)
                                    <li><a href="{{ $menu['link'] }}"><span>{{ $menu['name'] }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Footer Column -->
                <div class="footer-column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget links-widget">
                        <h4 class="widget-title">{{ __('website.services') }}</h4>
                        <div class="widgets-content">
                            <ul class="user-links light">
                                @foreach ($services as $service)
                                    <li><i class="fa fa-angle-right"></i> <a
                                            href="{{ $service->link }}">{{ $service->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Footer Column -->
                <div class="footer-column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget contact-widget">
                        <h4 class="widget-title">{{ __('website.contact_info') }}</h4>
                        <div class="widgets-content">

                            <ul class="contact-list-two">
                                @php
                                    $footerPhone = $phones->where('type', 'phone')->first();
                                @endphp
                                @if ($footerPhone)
                                    <li>
                                        <i class="icon fas fa-phone-square-alt"></i>
                                        <span class="title">{{ __('website.contact_us') }}</span>
                                        <div class="text"><a
                                                href="tel:{{ $footerPhone->code ?? '' }}{{ $footerPhone->phone ?? '' }}">{{ $footerPhone->code ?? '' }}{{ $footerPhone->phone ?? '' }}</a>
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    <i class="icon fas fa-envelope"></i>
                                    <span class="title">{{ __('website.email') }}</span>
                                    <div class="text"><a
                                            href="mailto:{{ config('settings.site_email') }}">{{ config('settings.site_email') }}</a>
                                    </div>
                                </li>
                                @if ($site_addresses && $site_addresses->isNotEmpty())
                                    <li>
                                        <i class="icon fas fa-map-marker"></i>
                                        <span class="title">{{ __('website.addresses') }}</span>
                                        <div class="text"><a href="{{ $site_addresses->first()->map_link ?? '#' }}"
                                                target="_blank">{{ $site_addresses->first()->address ?? '' }}</a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="auto-container">
            <div class="inner-container">
                <div class="copyright-text">© {{ config('settings.site_name') }} {{ date('Y') }} |
                    {{ __('website.all_rights_reserved') }}</div>

            </div>
        </div>
    </div>
</footer>
<!--====================Footer==============-->
@php
    $stickyPhone = $phones->where('type', 'phone')->first();
    $stickyWhatsapp = $phones->where('type', 'whatsapp')->first();
@endphp
<ul id=" " class="social-sec " style="transform: translate(15%, 100%); ">
    @if ($stickyPhone)
        <li class="Icon call ">
            <!--<span class="tooltip ">Call</span>-->
            <a href="tel:{{ $stickyPhone->code ?? '' }}{{ $stickyPhone->phone ?? '' }}" target="_blank "><i
                    class="fa fa-phone "></i></a>
        </li>
    @endif
    @if ($stickyWhatsapp)
        <li class="Icon whatsapp ">
            <!--<span class="tooltip ">Whatsapp</span>-->
            <a href="https://wa.me/{{ $stickyWhatsapp->code ?? '' }}{{ $stickyWhatsapp->phone ?? '' }}"
                target="_blank "><i class="fab fa-whatsapp"></i></a>
        </li>
    @endif
</ul>
<!--====================Footer==============-->
