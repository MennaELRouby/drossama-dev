<!-- <================================================================= StartContactForm =======================================================> -->

<section class="contact-details">
    <div class="container ">
        <div class="row">
            <div class="col-xl-7 col-lg-6">
                <div class="sec-title">
                    <span class="sub-title">{{ __('website.Send us email') }}</span>
                    <h2>{{ __('website.Feel free to write') }}</h2>
                </div>
                <!-- Contact Form -->
               @include('components.website.partials.form')
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="contact-details__right">
                    <div class="sec-title">
                        <h2>{{__('website.Get in touch with us')}}</h2>
                    </div>
                    <ul class="list-unstyled contact-details__info">
                        <li>
                            <div class="icon">
                                <span class="fas fa-phone-alt"></span>
                            </div>
                            <div class="text">
                                <h6>{{__('website.call_us')}}</h6>
                                @foreach ($phones as $phone)
                                    <a href="tel:+{{ $phone->code }}{{ $phone->phone }}">{{ $phone->phone }}</a>
                                    <br>
                                @endforeach
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fas fa-envelope"></span>
                            </div>
                            <div class="text">
                                <h6>{{__('website.email')}}</h6>
                                <a href="mailto:{{ config('settings.site_email') }}">{{ config('settings.site_email') }}</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fas fa-map-marker"></span>
                            </div>
                            <div class="text">
                                <h6>{{__('website.address')}}</h6>
                                @foreach ($site_addresses as $address)
                                    <span>
                                        <a href="{{ $address->map_link }}" target="_blank">{{ $address->address }}</a>
                                    </span>
                                    <br>
                                @endforeach
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Details End-->

<!-- Map Section-->
<section class="map-section">
    @include('Website.home-partials.map')
</section>
<!--End Map Section-->
<!-- <======================= EndContactForm =========================> -->
