{{-- <div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="index.html">
                            <img src="{{ config('configrations.site_logo') }}" alt="logo-img">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <p class="text d-none d-xl-block">
                    {!! config('configrations.site_description') !!}
                </p>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h4>{{ __('website.contact_us') }}</h4>
                    <ul>
                        @if ($site_addresses && $site_addresses->isNotEmpty())
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a target="_blank" href="#">{{ $site_addresses->first()->address ?? '' }}</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="mailto:{{ $site_addresses->first()->email ?? '' }}"><span>{{ $site_addresses->first()->email ?? '' }}</span></a>
                            </div>
                        </li>

                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="far fa-phone"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="tel:{{ $site_addresses->first()->phone ?? '' }}">{{ $site_addresses->first()->phone ?? '' }}</a>
                            </div>
                        </li>
                        @endif
                    </ul>
                    <div class="social-icon d-flex align-items-center">
                        @if (config('settings.site_facebook'))
                        <a href="{{ config('settings.site_facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if (config('settings.site_twitter'))
                        <a href="config('settings.site_twitter')"><i class="fab fa-twitter"></i></a>
                        @endif

                        @if (config('settings.site_youtube'))
                        <a href="config('settings.site_youtube')"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if (config('settings.site_linkedin'))
                        <a href="config('settings.site_linkedin')"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div> --}}
