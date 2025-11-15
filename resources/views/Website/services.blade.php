<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'services')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->

    <!--==========================Services==========================-->
    {{-- <section class="services py-5">
        <div class="container">
            @foreach ($sections as $section)
                @if ($section->key == 'services')
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6">
                            <img src="{{ $section->image_path }}" alt="After-Sales Service" class="img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <div class="card  border-0 px-4 py-5  position-relative overflow-hidden">

                                <h2 class="fw-bold mb-3 text-second">{{ $section->title }}</h2>
                                <p class="lead text-muted mb-4">
                                <p class="lead text-muted mb-4 wow animate__animated animate__fadeIn animated"
                                    dir="rtl" style="text-align: justify;" data-wow-delay="0.3s">
                                    {!! empty($section->long_desc) ? $section->long_desc : '' !!}</p>
                                </p>

                            </div>
                        </div>
                @endif
            @endforeach
        </div>
        </div>
    </section> --}}
    <section class="service-style2-area">
        <div class="container">
            @foreach ($sections as $section)
            @if ($section->key == 'services')
                <div class="sec-title text-center">
                    <div class="sub-title">
                        <h5>{{ $section->title }}</h5>
                    </div>

                    <div class="decor">
                        <img src="{{ $section->image_path }}" alt="">
                    </div>
                </div>
            @endif
            @endforeach
            <div class="row">
                @foreach ($services as $service)
                    <!--Start Single Service Style1-->
                    <div class="col-xl-4">
                        <div class="single-service-style2">
                            <div class="img-holder">
                                <div class="inner">
                                    <img src="{{ $service->image_path }}" alt="">
                                </div>
                            </div>
                            <div class="title-holder">
                                <div class="top">
                                    <div class="text">
                                        <h3><a href="{{ $service->link }}">{{ $service->name }}</a></h3>
                                        <div class="decor">
                                            <img src="https://www.drossamahakim.com/drossama/public/resources/assets/front/images/shape/decor.png"
                                                alt="shape">
                                        </div>
                                    </div>

                                </div>
                                <div class="bottom">
                                    <p></p>
                                    <div class="btn-box">
                                        <a class="btn-one" href="{{ $service->link }}">
                                            <div class="round"></div>
                                            <span class="txt">More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--End Single Service Style1-->
            </div>
        </div>
    </section>
    <!--==========================Services==========================-->
</x-website.layout>
