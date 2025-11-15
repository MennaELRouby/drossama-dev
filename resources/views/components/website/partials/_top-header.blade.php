{{-- <!--<< Mouse Cursor Start >>-->
<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>

<!-- Offcanvas Area Start -->
<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{ route('website.home') }}">
                            <img src="{{ path::AppLogo('site_logo') }}" alt="logo-img" title="logo-img">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h4>{{ __('website.contact_info') }}</h4>
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                @if ($site_addresses && $site_addresses->isNotEmpty())
                                <a target="_blank"
                                    href="{{ $site_addresses->first()->map_link ?? '#' }}">{{ $site_addresses->first()->address ?? '' }}</a>
                                @endif
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a
                                    href="mailto:{{ config('settings.site_email') ?? 'info@site.com' }}">{{ config('settings.site_email') ?? 'info@site.com' }}</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-clock"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a target="_blank" href="#">Mod-friday, 09am -05pm</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="far fa-phone"></i>
                            </div>
                            @if (isset($headerPhone) && $headerPhone)
                                <div class="offcanvas__contact-text">
                                    <a
                                        href="tel:{{ $headerPhone->code }}{{ $headerPhone->phone }}">{{ $headerPhone->code }}{{ $headerPhone->phone }}</a>
                                </div>
                            @else
                                <div class="offcanvas__contact-text">
                                    <a href="tel:+20123456789">+20123456789</a>
                                </div>
                            @endif
                        </li>
                    </ul>
                    <div class="social-icon d-flex align-items-center">
                        <x-website.partials.social-media :socialMediaLinks="$socialMediaLinks" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div> --}}
