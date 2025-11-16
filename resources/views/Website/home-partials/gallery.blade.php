    <!--===============Gallery==============-->
    <section class="before-after-section" style="background-color: #171717; padding: 80px 0;">
        <div class="auto-container" style="max-width: 1200px; margin: auto;">

            <div class="before-after-slider">
                <div class="swiper before-after-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($albums as $album)
                            <div class="swiper-slide">
                                <div class="four-images-grid"
                                    style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; padding: 20px;">
                                    @foreach ($album->images as $image)
                                        <div class="grid-image-item">
                                            <img src="{{ $image->image_url }}" alt="نتائج العملية"
                                                style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="swiper-button-next"
                style="color: #4b92fe; background: rgba(75, 146, 254, 0.1); border-radius: 50%; width: 50px; height: 50px;">
            </div>
            <div class="swiper-button-prev"
                style="color: #4b92fe; background: rgba(75, 146, 254, 0.1); border-radius: 50%; width: 50px; height: 50px;">
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination" style="margin-top: 30px;"></div>
        </div>

        <!-- Gallery Button -->
        <div class="gallery-button-container" style="text-align: center; margin-top: 40px;">
            <a href="{{ Path::AppUrl('gallery-photos') }}" class="gallery-btn"
                style="display: inline-block; background: linear-gradient(135deg, #4b92fe, #357abd); 
                                  color: white; padding: 15px 30px; border-radius: 50px; 
                                  text-decoration: none; font-size: 1.1rem; font-weight: 600;
                                  box-shadow: 0 8px 25px rgba(75, 146, 254, 0.3);
                                  transition: all 0.3s ease; border: none; cursor: pointer;">
                <i class="fas fa-images" style="margin-left: 8px;"></i>
                عرض جميع الصور
            </a>
        </div>
        </div>
        </div>
    </section>
    {{-- <div class="case-study">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="case-study-content">
                    @foreach ($galleryTitle as $title)
                        <div class="section-title">
                            <h3 class="wow fadeInUp">{{ $title->title }}</h3>
                            <h2 data-cursor="-opaque">{{ $title->title1 }} </h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                                {!! $title->text !!}
                            </p>
                        </div>
                    @endforeach
                    <div class="case-study-btn wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ LaravelLocalization::localizeUrl('galleryImages') }}" class="btn-default">
                            {{ trans('home.more') }} </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gallery-items page-gallery-box">
                    @foreach ($galleryImages as $gallery)
                    <div class="col-lg-4 col-6">
                        <!-- Image Gallery start -->
                        <div class="photo-gallery wow fadeInUp">
                            <a href="{{$gallery->img}}" data-fancybox="gallery" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{$gallery->img}}" alt="img">
                                </figure>
                            </a>
                        </div>
                        <!-- Image Gallery end -->
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <!--===============Gallery==============-->
