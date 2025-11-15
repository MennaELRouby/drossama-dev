    <!--================= Slider ================-->
        <section class="main-swiper-section" style="overflow:hidden;">
            <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <img src="{{ $slider->image_path }}"
                            style="width:100%; height:100vh; object-fit:cover; display:block;" alt="{{ $slider->alt_image }}">
                        <div class="slide-caption animated-caption">
                            <h2 class="slide-title-animated">{{ $slider->title }}</h2>
                            <div class="slide-subtitle slide-subtitle-animated">{!! $slider->text !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
    <!--================= Slider ================-->
