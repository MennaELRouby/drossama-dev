<!-- gallery-page-section end -->

<section class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="sec-title">
                    <span class="">HEAR FROM OUR PATIENTS</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/a1L75o9HeTo"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/Mk0sgwxJVfM"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/TzRQYksE3JE"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/L1b2jhU698U"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/9B5ZgFPLNmo"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/pLBy6rZNB2Y"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- gallery-page-section Start -->
<section class="gallery-page-section ">
    <div class="container">
        <div class="row">
            @foreach ($albums as $album)
                <div class="col-sm-12 col-md-12 col-lg-12 text-center mb-4">
                    <h3>{{ $album->name }}</h3>
                </div>

                @if ($album->images && count($album->images) > 0)
                    @foreach ($album->images as $image)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                            <figure class="image-box">
                                <a href="{{ $image->image_url }}" class="lightbox-image"
                                    data-fancybox="gallery-{{ $album->id }}">
                                    <img src="{{ $image->image_url }}" alt="{{ $album->name }}" class="img-fluid">
                                </a>
                            </figure>
                        </div>
                    @endforeach
                @else
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <figure class="image-box">
                            <a href="{{ asset('storage/albums/' . $album->image) }}" class="lightbox-image"
                                data-fancybox="gallery-{{ $album->id }}">
                                <img src="{{ asset('storage/albums/' . $album->image) }}" alt="{{ $album->name }}"
                                    class="img-fluid">
                            </a>
                        </figure>
                    </div>
                @endif
            @endforeach


        </div>

    </div>
</section>
