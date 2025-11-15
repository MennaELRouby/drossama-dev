{{-- @if (count($projects) > 0)
<!-- Our Portfolio -->
<div class="content-row full text-align-center row_padding_left row_padding_right dark-section" data-bgcolor="#0c0c0c">
    <div id="itemsWrapperLinks">
        <div class="move-thumbs-wrapper">
            <div class="start-thumbs-caption">
                <h2 class="primary-font-title big-title has-mask-fill">
                    {{ trans('home.Our Portfolio') }}
                </h2>
            </div>
        </div>
        <div id="itemsWrapper" class="webgl-fitthumbs fx-one">
            <div class="overlapping-gallery">
                @foreach ($projects as $project)
                <!--StartPortfolio -->
                <div class="overlapping-image">
                    <div class="overlapping-image-inner trigger-item" data-centerLine="OPEN">
                        <div class="img-mask">
                            <a class="slide-link" data-type="page-transition" href="{{LaravelLocalization::LocalizeUrl('project/' .$project->{'link_' .$lang}) }}"></a>
                            <div class="section-image trigger-item-link">
                                <img src="{{ asset('uploads/projects/source/' . $project->image) }}" class="item-image grid__item-img" alt="image" />
                            </div>
                            <img src="{{ asset('uploads/projects/source/' . $project->image) }}" class="grid__item-img grid__item-img--large" alt="image" />
                        </div>
                        
                        <div class="slide-caption trigger-item-link-secondary">
                            <div class="slide-title primary-font-title">
                                <span>{{ $project->{'name_' . $lang} }}</span>
                            </div>
                            <div class="slide-date"><span>{{ $project->year }}</span></div>
                            <div class="slide-cat">
                                <span>{{ $project->{'name_' . $lang} }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--EndPortfolio -->
                @endforeach
            </div>
        </div>               
    </div>
    <hr />
    <p>
        <span class="has-opacity">{{$title->{'projecttitle_' .$lang} }}</span>
        <br class="destroy" />
        <span class="has-opacity">{{$title->{'projecttitle1_' .$lang} }}</span>
    </p>
    <div class="button-box text-align-center has-animation fadeout-element">
        <div class="anonymous-button-wrap parallax-wrap hide-ball">
            <div class="anonymous-button parallax-element">
                <div class="button-border outline rounded parallax-element-second">
                    <a class="ajax-link" href="{{LaravelLocalization::LocalizeUrl('projects')}}" data-type="page-transition">
                        <span data-hover="See All Works">{{ trans('home.See All Works') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Portfolio -->
@endif --}}
<!-- Portfolio Section Start -->
<section class="portfolio-section section-padding pt-0">
    <div class="portfolio-wrapper">
        <div class="cap-shape float-bob-x">
            <img src="{{url('resources/assets/front/img/portfolio/cap.png')}}" alt="img">
        </div>
        <div class="shape-2 float-bob-y">
            <img src="{{url('resources/assets/front/img/portfolio/shape-2.png')}}" alt="img">
        </div>
        <div class="shape-3">
            <img src="{{url('resources/assets/front/img/portfolio/shape-3.png')}}" alt="img">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="portfolio-content">
                        @foreach($galleryTitle as $title)
                        <div class="section-title">
                            <h6 class="wow fadeInUp">{{$title->title}}</h6>
                            <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                {!! $title->text !!}
                            </h2>
                        </div>
                        @endforeach
                        <ul class="list-items mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s">
                            @foreach($careers as $career)
                            <li>
                                <i class="fa-regular fa-check"></i>
                                {{ $career->title }}
                            </li>
                            @endforeach

                        </ul>
                        <a href="{{LaravelLocalization::localizeUrl('contact-us')}}" class="theme-btn wow fadeInUp" data-wow-delay=".3s">{{ trans('home.contact-us') }}</a>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="portfolio-image-items">
                        <div class="row g-0">
                            @foreach ($galleryImages as $index=> $galleryImage)
                            @if($index < 4)
                                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="portfolio-image">
                                        <img src="{{ $galleryImage->img }}"
                                            alt="img">
                                        {{-- <a href="{{ $galleryImage->img }}"
                                            class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a> --}}
                                        <div class="portfolio-content">
                                            <h3><a
                                                    href="{{ LaravelLocalization::LocalizeUrl('project/' . $galleryImage->{'link_' . $lang}) }}">{{ $galleryImage->{'name_' . $lang} }}</a>
                                            </h3>
                                            <h4>{{ $galleryImage->year }}</h4>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
