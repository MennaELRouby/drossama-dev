<!--==================Partners Section===============================-->
@if ($brands->count() > 0)
    <section class="py-5 ">
        <div class="container py-5">
            @foreach ($sections as $section)
                @if ($section->key == 'partners')
                    <h2 class="text-center mb-5 fw-bold text-main">{{ $section->title }}</h2>
                @endif
            @endforeach
            <div class="owl-carousel partners-carousel">
                @foreach ($brands as $brand)
                    <div class="partners-img">
                        <img src="{{ $brand->logo_path }}" alt="{{ $brand->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Get the number of partners
                var partnersCount = $('.partners-carousel .partners-img').length;

                // Initialize partners carousel with smart settings
                $('.partners-carousel').owlCarousel({
                    loop: partnersCount > 6, // Only loop if more than 6 partners
                    margin: 30,
                    nav: false,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    rewind: true,
                    responsive: {
                        0: {
                            items: Math.min(2, partnersCount)
                        },
                        600: {
                            items: Math.min(3, partnersCount)
                        },
                        1000: {
                            items: Math.min(6, partnersCount)
                        }
                    }
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .partners-carousel .partners-img {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 80px;
                padding: 10px;
            }

            .partners-carousel .partners-img img {
                max-height: 60px;
                max-width: 100%;
                width: auto;
                height: auto;
                object-fit: contain;
                filter: grayscale(100%);
                opacity: 0.7;
                transition: all 0.3s ease;
            }

            .partners-carousel .partners-img img:hover {
                filter: grayscale(0%);
                opacity: 1;
                transform: scale(1.1);
            }

            @media (max-width: 768px) {
                .partners-carousel .partners-img {
                    height: 60px;
                }

                .partners-carousel .partners-img img {
                    max-height: 45px;
                }
            }
        </style>
    @endpush
@endif
<!--==================Partners Section===============================-->
