<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'whyus')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->

    <!--------------------------------- Why DHI --------------------------------------->
        <section class="why-section">
            <!--<div class="bg-layer parallax-bg" data-parallax='{"y": 100}' style="background-image: url(https://www.dhiegypt.com/resources/assets/front/images/background/banner.jpg);"></div>-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                        @foreach ($sections as $key => $section)
                            @if ($key == 'whyus')
                                <div class="sec-title">
                                    <span class="sub-title">{{ $section->title }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @foreach ($about_structs as $aboutStruc)
                        <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ $aboutStruc->name }}</h3>
                                </div>
                                <div class="card-body">
                                    {!! $aboutStruc->long_desc !!}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <style>
            .why-section .card {
                border: 1px solid #e0e6ed;
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                min-height: auto;
            }

            .why-section .card-header {
                background: #f8f9fa;
                border-bottom: 1px solid #e0e6ed;
                padding: 15px 20px;
            }

            .why-section .card-header h3 {
                margin: 0;
                font-size: 18px;
                font-weight: 600;
                color: #2c3e50;
            }

            .why-section .card-body {
                padding: 20px;
                line-height: 1.6;
            }

            .why-section .card-body p {
                margin-bottom: 15px;
                color: #555;
            }

            @media (max-width: 768px) {
                .why-section .col-lg-6 {
                    margin-bottom: 20px;
                }
            }
        </style>
        <!--------------------------------- Why DHI --------------------------------------->


</x-website.layout>
