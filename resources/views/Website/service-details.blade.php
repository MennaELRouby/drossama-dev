<x-website.layout>

    <!-- start banner -->
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'services')
            @include('Website.partials._banner', ['page_title' => $service->name])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start service details -->
    {{-- <section class="services-details">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 col-sm-12 order-lg-1 order-md-2 order-sm-2 sidebar-side">
                    <div class="services-sidebar">
                        <div class="sidebar-widget category-widget">
                            <div class="sec-title">
                                <h4 class="border-bottom">{{ __('website.our_services') }}</h4>
                            </div>
                            <ul class="category-list clearfix">
                                @foreach ($relatedServices as $relatservice)
                                    <li><a href="{{ $relatservice->link }}">{{ $relatservice->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
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
                        <div class="content-one">
                            <div class="image-box"><img src="{{ $service->image_path }}" alt="{{ $service->name }}">
                            </div>
                            <div class="lower-box mt-3">
                                <h1>{{ $service->name }}</h1>
                                <div class="text">
                                    <p>{!! $service->long_desc !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="services-details">
        <div class="container">
            <div class="row">
                <!--Start Services Details Sidebar-->
                <div class="col-xl-4 col-lg-4">
                    <div class="service-sidebar">
                        <!--Start Services Details Sidebar Single-->
                        <div class="sidebar-widget service-sidebar-single">
                            <div class="sidebar-service-list">
                                <ul>
                                    @foreach($services as $sideserivce)
                                    <li><a href="{{ $sideserivce->link }}" class="current"><i
                                                class="fas fa-angle-right"></i><span>{{ $sideserivce->name }}</span></a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                        <!--End Services Details Sidebar-->
                        <div class="subscribe-section" style=" margin-bottom:30px;">
                            <div class="bg bg-image"
                                style="background-image: url(../../assets/front/images/background/page-title-bg.png);">
                            </div>

                            <div class="subscribe-form" style="padding-right:15px; padding-left:15px;">
                                 <x-website.partials.contact-form />
                               
                            </div>
                        </div>
                        <!--End Form-->
                        <div class="map">
                            @include('website.home-partials.map')
                        </div>
                    </div>
                </div>
                <!--Start Services Details Content-->
                <div class="col-xl-8 col-lg-8">
                    <div class="services-details__content">
                        <img src="{{$service->image_path}}" alt="img" />
                        <h3 class="mt-4">{{$service->name}}</h3>

                        <div class="content mt-40">
                            <div class="feature-list mt-4">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="feature-block">
                                            <div class="inner-box">
                                                <div class="text">
                                                    {!! $service->long_desc !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!--End Services Details Content-->
            </div>
        </div>
    </section>
    <!-- end service details -->
</x-website.layout>
