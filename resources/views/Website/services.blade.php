<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'services')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->

    <!--==========================Services==========================-->
    <section class="services py-5">
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
    </section>
    <!--==========================Services==========================-->
</x-website.layout>
