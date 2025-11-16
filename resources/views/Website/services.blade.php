<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'services')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->

    <!--==========================Services==========================-->
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
                                        <div class="info-box">
                                            {{-- <img src="https://www.drossamahakim.com/drossama/public/resources/assets/front/images/shape/decor.png"
                                                alt="shape"> --}}
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
