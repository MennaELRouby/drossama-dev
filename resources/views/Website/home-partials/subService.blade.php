<section class="projects section-padding">
    <div class="container">
        <div class="row">
            @foreach ($subServices as $index => $subService)
            @if ($subService->parent_id && $subService->home)
            <div class="col-md-4">
                <div class="items mb-4">
                    <div class="con">
                        <div class="img">
                            <img src="{{ Helper::uploadedImagesPath('services', $subService->img) }}" alt="">
                        </div>
                        <div class="info">
                            <span class="category mb-0">{{ $subService->{'name_' . $lang} }}</span>
                            <h6><a href="{{ LaravelLocalization::localizeUrl('service/' . $subService->{'link_' . $lang}) }}">{{ $subService->{'name_' . $lang} }}</a></h6>
                            {{-- <p>5500EG <del>6000EG</del></p> --}}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{LaravelLocalization::LocalizeUrl('services')}}" class="button-dark">{{ trans('home.View All Product') }}</a>
        </div>
    </div>
</section>
