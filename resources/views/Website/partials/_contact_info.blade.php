@if ($site_addresses && $site_addresses->isNotEmpty())
    <div class="sidebar-widget overflow-hidden position-relative wow fadeInUp" data-wow-delay=".6s"
        style="background-image: url('assets/images/shape/serviceShape1_1.png');">
        <h4 class="title">{{ __('website.contact_us') }}</h4>
        <ul class="list-unstyled contact-info">
            <li class="d-flex">
                <div class="icon flex-shrink-0 d-flex justify-content-center align-items-center rounded-pill">
                    <img src="{{ asset('assets/website') }}/images/icon/location.svg" alt="location">
                </div>
                <div class="text">
                    <h4 class="contact-title">{{ $site_addresses->first()->title ?? '' }}</h4>
                    <p>{{ $site_addresses->first()->title ?? '' }}</p>
                </div>
            </li>
            <li class="d-flex">
                <div class="icon flex-shrink-0 d-flex justify-content-center align-items-center rounded-pill">
                    <img src="{{ asset('assets/website') }}/images/icon/mail.svg" alt="mail">
                </div>
                <div class="text">
                    <h4 class="contact-title">{{ __('website.email') }}</h4>
                    <p><a
                            href="mailto:{{ $site_addresses->first()->email ?? '' }}">{{ $site_addresses->first()->email ?? '' }}</a>
                    </p>
                </div>
            </li>
            <li class="d-flex">
                <div class="icon flex-shrink-0 d-flex justify-content-center align-items-center rounded-pill">
                    <img src="{{ asset('assets/website') }}/images/icon/phone.svg" alt="phone">
                </div>
                <div class="text">
                    <h4 class="contact-title">{{ __('website.call_us') }}</h4>
                    <p><a
                            href="tel:{{ $site_addresses->first()->phone ?? '' }}">{{ $site_addresses->first()->phone ?? '' }}</a>
                    </p>
                </div>
            </li>
        </ul>
    </div>

    <div class="sidebar-widget overflow-hidden position-relative wow fadeInUp" data-wow-delay=".6s">
        <div class="map-serv">
            <iframe src="{{ $site_addresses->first()->map_url ?? '' }}" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endif
