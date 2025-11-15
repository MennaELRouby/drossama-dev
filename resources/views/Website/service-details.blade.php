<x-website.layout>

    <!-- start banner -->
    <!-- start banner -->
    @foreach($sections as $section)
        @if($section->key == 'services')
        @include('Website.partials._banner', ['page_title' => $service->name])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start service details -->
    <section class="services-details">
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
    </section>
    <!-- end service details -->
</x-website.layout>
