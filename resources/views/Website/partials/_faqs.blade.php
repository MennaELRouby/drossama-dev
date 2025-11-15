<section class="services-details">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12 order-lg-1 order-md-2 order-sm-2 sidebar-side">
                <div class="services-sidebar">
                    <div class="sidebar-widget support-widget">
                        <div class="sec-title">
                            <h4 class="border-bottom">{{ __('website.contact_us') }}</h4>
                        </div>
                        <div class="form-inner">
                            <x-website.partials.contact-form />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 order-lg-2 order-md-1 order-sm-1 content-side order-mob">
                <div class="services-details-content">

                    <!-- The Block -->
                    <div class="content-three">
                        <div class="sec-title">
                            <h3 class="border-bottom">{{ __('website.faqs') }}</h3>
                        </div>
                        <ul class="accordion-box">
                            @foreach ($faqs as $key => $faq)
                                <li class="accordion block {{ $key == 0 ? 'active-block' : '' }}">
                                    <div class="acc-btn {{ $key == 0 ? 'active' : '' }}">
                                        <div class="icon-outer"></div>
                                        <h5>{{ $faq->question }}</h5>
                                    </div>
                                    <div class="acc-content {{ $key == 0 ? 'current' : '' }}">
                                        <div class="text">
                                            <p dir="rtl" style="text-align: right;">{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
