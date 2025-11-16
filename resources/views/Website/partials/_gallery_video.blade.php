{{-- <div class="col-12">
    <div class="sec-viedo">
        <h3 class="subtitle wow fadeInUp">{{ __('website.our_people_career') }}</h3>
        <div class="row">
            @foreach ($gallery_videos as $video)
                <div class="col-lg-4 col-12">
                    <iframe width="560" height="315" src="{{ $video->video_url }}" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            @endforeach

        </div>
    </div>
</div> --}}

<section class="project-two">
    <div class="container">
        <div class="row">
            @foreach ($gallery_videos as $video)
                <div class="col-md-4">
                    <div class="project-two__single">
                        <div class="project-two__img">
                            <iframe width="100%" height="315" src="{{ $video->video_url }}" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
