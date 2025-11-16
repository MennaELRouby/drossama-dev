<!-- <================================================================= StartContactForm =======================================================> -->
{{-- <section class="subscribe-section">
            <div class="bg bg-image" style="background-image: url(uploads/titles/source/68715da79a5f6.png);"></div>
            <div class="auto-container">
                <div class="outer-box">
                    <div class="row">
                        @foreach ($sections as $section)
                            @if ($section->key == 'contact')
                                <div class="title-column col-lg-4 col-md-12">
                                    <div class="inner-column">
                                        <h2 class="title">{{ $section->title }}</h2>
                                        <div class="text">{!! $section->short_desc !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <!-- Form Column -->
                        <div class="form-column col-lg-8 col-md-12 col-sm-12">
                            <div class="subscribe-form">
                               <x-website.partials.contact-form />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
<section class="contact-details">
    <div class="container ">
        <div class="row">
            <div class="col-xl-7 col-lg-6">
                <div class="sec-title">
                    <span class="sub-title">Send us email</span>
                    <h2>Feel free to write</h2>
                </div>
                <!-- Contact Form -->
               @include('components.website.partials.form')
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="contact-details__right">
                    <div class="sec-title">
                        <h2>Get in touch</h2>
                    </div>
                    <ul class="list-unstyled contact-details__info">
                        <li>
                            <div class="icon">
                                <span class="fas fa-phone-alt"></span>
                            </div>
                            <div class="text">
                                <h6>Call Us</h6>
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
                                <h6>E.mail</h6>
                                <a href="mailto:{{ config('settings.site_email') }}">{{ config('settings.site_email') }}</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fas fa-map-marker"></span>
                            </div>
                            <div class="text">
                                <h6>Addresses</h6>
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
