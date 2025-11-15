    <!--==========================Services==========================-->
            <section class="project-section">
            <div class="large-container">
                <div class="sec-title text-center light">
                    <h2>{{ __('website.services') }}</h2>
                </div>

                <div class="carousel-outer">
                    <div class="project-carousel owl-carousel owl-theme disable-navs default-dots-two">
                        @foreach ($services as $service)
                            <!-- project-block -->
                            <div class="project-block">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><a href="{{ $service->link }}"><img
                                                    src="{{ $service->image_path }}" alt="{{ $service->name }}"></a></figure>
                                        <div class="info-box">
                                            <h4 class="title"><a href="{{ $service->link }}">{{ $service->name }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="btn-box wow fadeInUp animated  text-center pt-5"
                        style="visibility: visible; animation-name: fadeInUp;">
                        <a href="{{ Path::AppUrl('services') }}" class="theme-btn btn-style-one"><span class="btn-title">{{ __('website.read_more') }}
                                <i class="icon fa fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </section>
    <!--==========================Services==========================-->
