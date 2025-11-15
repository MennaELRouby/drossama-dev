@if ($products->isNotEmpty())
    <!--==========================Services==========================-->
    <section class="products-section py-5 bg-light-subtle wow fadeInUp" data-wow-delay="0.25s">
        <div class="container py-5 wow fadeInUp" data-wow-delay="0.3s">
            @foreach ($sections as $section)
                @if ($section->key == 'products')
                    <div class="section-title d-flex justify-content-between align-items-center flex-wrap gap-4 wow fadeIn"
                        data-wow-delay="0.35s">
                        <h2 class="text-uppercase">{{ $section->title }}</h2>

                        <a href="{{ Path::AppUrl('products') }}" class="btn-send p-3 d-inline-block">
                            {{ trans('website.read_more') }} <span class="btn-arrow ms-2"><i
                                    class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    </div>
                @endif
            @endforeach
            <div class="project-wrapper mt-5 wow fadeInUp" data-wow-delay="0.4s">
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="product-card wow fadeInUp shadow h-100" data-wow-duration="1.5s"
                                data-wow-delay="0.1s">
                                <div class="product-item position-relative">
                                    <a href="{{ $product->link }}">
                                        <img src="{{ $product->image_path }}" alt="{{ $product->name }}"
                                            class="product-img img-fluid" />

                                        <div class="product-overlay">
                                            <h4 class="product-title">{{ $product->name }}</h4>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--==========================Services==========================-->
@endif
