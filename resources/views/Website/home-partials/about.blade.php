<!--==========================About==========================-->
<section class="about-section-nine">
    <div class="auto-container">
        <div class="row">
            <!-- Content-Column -->
            @if ($about)
                <div class="content-column col-lg-6 col-md-12 col-sm-12 wow fadeInLeft">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">{{ __('website.about_us') }}</span>
                            <h2>{{ $about->title ?? '' }}</h2>
                            <div class="text">
                                {!! $about->short_desc ?? '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="btn-box wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                        <a href="{{ Path::AppUrl('about-us') }}" class="theme-btn btn-style-one"><span
                                class="btn-title">{{ __('website.read_more') }} <i
                                    class="icon fa fa-arrow-right"></i></span></a>
                    </div>
                </div>

                <!-- images column -->
                @if ($about->video_link)
                    <div class="image-column col-lg-6 wow fadeInRight" data-wow-delay="300ms">
                        <div class="inner-column">
                            <div class="image-box" style="text-align:center;">
                                <iframe width="100%" height="500" src="{{ $about->video_link }}"
                                    title="YouTube video player" frameborder="0" style="border-radius:12px;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>

<!--==========================About==========================-->
