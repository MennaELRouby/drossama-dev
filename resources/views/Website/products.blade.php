<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'products')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->

    <section class="products-section py-5  wow fadeInUp" data-wow-delay="0.25s">
        <div class="container py-5 wow fadeInUp" data-wow-delay="0.3s">

            <div class="project-wrapper mt-5 wow fadeInUp" data-wow-delay="0.4s">
                <div class="row g-5 align-items-center wow fadeInUp" data-wow-delay="0.45s">
                    @foreach ($products as $product)
                        <div class="col-md-6 col-lg-4 product-card wow fadeInUp" data-wow-duration="1.5s"
                            data-wow-delay="0.1s">
                            <div class="product-item position-relative">
                                <a href="{{ $product->link }}">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}"
                                        class="product-img img-fluid" />

                                    <div class="product-overlay">
                                        <h4 class="product-title"> {{ $product->name }}</h4>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


</x-website.layout>
