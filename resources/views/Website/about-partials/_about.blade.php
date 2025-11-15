<!--#############About Us############-->
@if ($about && $about->exists)
    <section class="about-section-nine">
        <div class="auto-container">
            <div class="row">
                <!-- Content-Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12 wow fadeInLeft">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">{{ $about->title ?? '' }}</span>
                            <h2>{{ $about->title2 ?? '' }}</h2>
                            <div class="text">
                                {!! $about->short_desc ?? '' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- images column -->
                @if ($about->image_path)
                    <div class="image-column col-lg-6 wow fadeInRight" data-wow-delay="300ms">
                        <div class="inner-column">
                            <div class="image-box" style="text-align:center;">
                                <img src="{{ $about->image_path }}" alt="{{ $about->alt_image ?? '' }}"
                                    style="width:100%;height:500px;object-fit:cover;border-radius:12px;">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
<!--#############About Us############-->
@if ($teams->count() > 0)
    <section class="team-section-two">
        <div class="auto-container">
            <div class="sec-title">
                <h2>{{ __('website.certifcate') }}</h2>
            </div>

            <div class="team-carousel owl-carousel owl-theme default-navs">
                @foreach ($teams as $team)
                    <div class="team-block-two wow fadeInUp">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="{{ $team->image_path }}" data-fancybox="certificates" data-caption="">
                                    <figure class="image">
                                        <img src="{{ $team->image_path }}" alt="{{ $team->alt_image }}">
                                    </figure>
                                </a>
                            </div>
                            <div class="info-box">
                                <h4 class="name">{{ $team->name }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
