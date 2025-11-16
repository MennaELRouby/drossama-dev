<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'testimonial')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <section class="project-two">
        <div class="container">
            <div class="row">
                @foreach ($testimonials as $testimonial)
                    <div class="col-md-4">
                        <div class="project-two__single">
                            <div class="project-two__img">
                                <iframe width="100%" height="315"
                                    src="{{ $testimonial->video_link }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-website.layout>
