
<div class="services-section-two pull-up pt-5 pb-5">
    <div class="container">
        <div class="row">
            @foreach ($gallery_photos as $key => $album)
                <div class="col-md-4">
                    <div class="service-block-two">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ $album->image_path }}" class="lightbox-image"
                                        data-fancybox="gallery-{{ $key }}"><img src="{{ $album->image_path }}"
                                            alt="Image">
                                    </a>

                                    <div style="display:none">
                                        @foreach ($album->images as $image)
                                            <a data-fancybox="gallery-{{ $key }}"
                                                href="{{ $image->image_url }}">
                                                <img src="{{ $image->image_url }}" />
                                            </a>
                                        @endforeach

                                    </div>
                                    <h1><a href="{{ $album->image_path }}" class="lightbox-image"
                                            data-fancybox="gallery-{{ $key }}">{{ $album->name }}</a> </h1>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
