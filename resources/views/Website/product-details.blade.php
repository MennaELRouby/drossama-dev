<x-website.layout>
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'products')
            @include('Website.partials._banner', ['page_title' => $product->name])
        @endif
    @endforeach
    <!-- end banner -->

    <section class="py-5">
        <div class="container py-5">
            <div class="row gy-5 mb-5 wow fadeInUp" data-wow-delay="0.1s">

                <div class="col-lg-12 position-relative wow fadeInLeft" data-wow-delay="0.2s">
                    <img id="mainHDFImage" src="{{ $product->image_path }}" alt="{{ $product->name }}"
                        class="w-100 rounded-4 shadow object-fit-cover wow zoomIn" data-wow-delay="0.4s"
                        height="500" />

                    @if ($product->images->count() > 0)
                        <div class="mt-4 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="owl-carousel product-images-carousel">
                                @foreach ($product->images as $key => $image)
                                    <div class="thumbnail-item" data-fullimg="{{ $image->image_url }}"
                                        data-caption="{{ $product->name }}">
                                        <img src="{{ $image->image_url }}" class="w-100 object-fit-cover rounded-4"
                                            alt="{{ $product->name }}" height="200" style="cursor: pointer;" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="project-overview mt-4 wow fadeInUp" data-wow-delay="0.7s">
                        <h3 class="fs-2 mb-3 text-main">{{ $product->name }}</h3>
                        {!! $product->long_desc !!}
                    </div>
                </div>
            </div>
    </section>
    <!--==================Partners Section===============================-->
    @if ($brands->count() > 0)
        <section class="py-5 ">
            <div class="container py-5">
                @foreach ($sections as $section)
                    @if ($section->key == 'partners')
                        <h2 class="text-center mb-5 fw-bold text-main">{{ $section->title }}</h2>
                    @endif
                @endforeach
                <div class="owl-carousel product-partners-carousel">
                    @foreach ($brands as $brand)
                        <div class="partners-img">
                            <img src="{{ $brand->logo_path }}" alt="{{ $brand->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--==================Partners Section===============================-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Get the number of images
                var imagesCount = $('.thumbnail-item').length;

                // Initialize product images carousel
                $('.product-images-carousel').owlCarousel({
                    loop: imagesCount > 4, // Only loop if more than 4 images
                    margin: 15,
                    nav: true,
                    dots: false,
                    rewind: true, // Go back to start when reaching the end
                    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: Math.min(2, imagesCount)
                        },
                        600: {
                            items: Math.min(3, imagesCount)
                        },
                        1000: {
                            items: Math.min(4, imagesCount)
                        }
                    }
                });

                // Change main image when clicking on thumbnail
                $('.thumbnail-item').on('click', function() {
                    var fullImg = $(this).data('fullimg');
                    $('#mainHDFImage').fadeOut(300, function() {
                        $(this).attr('src', fullImg).fadeIn(300);
                    });

                    // Add active state to clicked thumbnail
                    $('.thumbnail-item').removeClass('active-thumbnail');
                    $(this).addClass('active-thumbnail');
                });

                // Initialize product partners carousel
                var partnersCount = $('.product-partners-carousel .partners-img').length;

                if (partnersCount > 0) {
                    $('.product-partners-carousel').owlCarousel({
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
                }
            });
        </script>

        <style>
            .product-images-carousel .owl-nav button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.5) !important;
                color: white !important;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                font-size: 18px;
            }

            .product-images-carousel .owl-nav button.owl-prev {
                left: -20px;
            }

            .product-images-carousel .owl-nav button.owl-next {
                right: -20px;
            }

            .product-images-carousel .owl-nav button:hover {
                background: rgba(0, 0, 0, 0.8) !important;
            }

            .thumbnail-item {
                transition: all 0.3s ease;
                border: 3px solid transparent;
            }

            .thumbnail-item:hover,
            .thumbnail-item.active-thumbnail {
                border-color: var(--main-color, #007bff);
                transform: scale(1.05);
            }

            .thumbnail-item img {
                border-radius: 8px;
            }

            /* Partners carousel styling */
            .product-partners-carousel .partners-img {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 80px;
                padding: 10px;
            }

            .product-partners-carousel .partners-img img {
                max-height: 60px;
                max-width: 100%;
                width: auto;
                height: auto;
                object-fit: contain;
                filter: grayscale(100%);
                opacity: 0.7;
                transition: all 0.3s ease;
            }

            .product-partners-carousel .partners-img img:hover {
                filter: grayscale(0%);
                opacity: 1;
                transform: scale(1.1);
            }

            @media (max-width: 768px) {
                .product-partners-carousel .partners-img {
                    height: 60px;
                }

                .product-partners-carousel .partners-img img {
                    max-height: 45px;
                }
            }
        </style>
    @endpush
</x-website.layout>
