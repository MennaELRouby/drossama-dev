{{-- <!-- brand area end -->
<section class="testimonials">
    @foreach ($titles as $skills)
        @if ($skills->type == 'skills')
            <div class="background bg-img bg-fixed section-padding pb-0"
                data-background="{{ url('uploads/titles/source/' . $skills->image) }}" data-overlay-dark="6">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6">
                            <div class="why-choose-us__content">
                                <div class="section__title-wrapper mb-10">
                                    <h5 class="section__subtitle color-theme-primary mb-15 mb-xs-10 title-animation"><img
                                            id="section__subtitle_img"
                                            src="{{ url('resources/assets/front/imgs/ask-quesiton/heart.png') }}"
                                            alt="icon not found" class="img-fluid">{{ $skills->{'title_' . $lang} }}
                                    </h5>
                                    <h3 class="section__title mb-0 text-capitalize title-animation">
                                        {{ $skills->{'title1_' . $lang} }}</h2>
                                </div>
                                <h5 class="section__subtitle color-theme-primary mb-15 mb-xs-10 title-animation"><img
                                        id="section__subtitle_img" class="img-fluid">{{ trans('home.phone') }}</h5>
                                @foreach ($phones as $phoneS)
                                    <a href="tel:{{ $phoneS->code }}{{ $phoneS->phone }}">
                                        <p class="mb-40">
                                            <i class="fa-solid fa-phone"></i> {{ $phoneS->phone }}
                                        </p>
                                    </a>
                                @endforeach
                                <h5 class="section__subtitle color-theme-primary mb-15 mb-xs-10 title-animation"><img
                                        id="section__subtitle_img" class="img-fluid"><Em></Em>{{ trans('home.email') }}
                                </h5>
                                <a href="mailto:{{ $setting->contact_email }}">
                                    <p class="mb-40">
                                        <i class="fa-solid fa-envelope"></i> {{ $setting->contact_email }}
                                    </p>
                                </a>
                                <a href="{{ LaravelLocalization::LocalizeUrl('contact-us') }}"
                                    class="rr-btn position-relative overflow-hidden">
                                    <div class="panel wow"></div>
                                    <span class="btn-wrap">
                                        <span class="text-one"> {{ trans('home.more') }} <i
                                                class="fa-solid fa-plus"></i></span>
                                        <span class="text-two"> {{ trans('home.more') }} <i
                                                class="fa-solid fa-plus"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="why-choose-us__wrapper">
                                <ul class="why-choose-us__wrapper-list">
                                    @foreach ($careers as $key => $career)
                                        @if ($key < 6)
                                            <li><i class="fa-solid fa-check"></i>{{ $career->{'title_' . $lang} }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</section>
{{-- <!-- slider-text start -->
<div class="slider-text">
<div class="container">
<div class="rr-scroller" data-speed="slow">
    <ul class="text-anim rr-scroller__inner">
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li><strong>Health Guard</strong></li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li>Care Wise Medical</li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li><strong>Health Guard</strong></li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li>Care Wise Medical</li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li><strong>Health Guard</strong></li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li>Care Wise Medical</li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li><strong>Health Guard</strong></li>
        <li><img src="./assets/imgs/slider-text/health-guard.png" alt=""></li>
        <li>Care Wise Medical</li>
    </ul>
</div>
</div>
</div>
<!-- slider-text end --> --}} 
