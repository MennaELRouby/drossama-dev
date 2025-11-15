<section class="content-inner-2 bg-light">
    <div class="container">
        <div class="section-head style-3 m-b30 text-center wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.8s">
            <h2 class="title">Treatments Planner</h2>
        </div>
        <div class="dz-flex-wrapper m-b30 swiper dz-flex-swiper wow fadeInUp" data-wow-delay="0.4s"
            data-wow-duration="0.8s">
            <div class="swiper-wrapper">
                @foreach ($projects as $index => $project)
                    <div class="dz-flex-item swiper-slide {{ $index }} {{ $index == 0 ? 'active' : '' }}">
                        <div class="dz-flex-head" style="background-image: url({{ $project->image }});">
                            <a href="service-detail.html"
                                class="btn btn-square btn-lg btn-white btn-shadow btn-rounded">
                                <i class="feather icon-arrow-up-right"></i>
                            </a>
                            <h3 class="title">{{ $project->name }}</h3>
                        </div>
                        <div class="dz-flex-info">
                            <div class="dz-flex-inner">
                                <div class="dz-media">
                                    <img src="{{ $project->image }}" alt="image" />
                                    <a href="{{ LaravelLocalization::localizeUrl('contact-us') }}"
                                        class="btn btn-white">
                                        <i class="feather icon-calendar m-r5 text-primary"></i>
                                        {{ trans('home.appointment') }}
                                    </a>
                                </div>
                                <div class="dz-info">
                                    <div class="dz-info-top">
                                        <h3 class="dz-title">{{ $project->name }}</h3>
                                        <p class="text">{!! $project->text1 !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="dz-separator style-3">
            <a href="{{LaravelLocalization::localizeUrl('services')}}" class="btn separator-badge fw-medium">{{ trans('home.View All Services') }}</a>
        </div>
    </div>
</section>
