@if($progresses->isNotEmpty())
<!-- Counter Section Start -->
<section class="counter-section fix section-padding">
    <div class="container">
        @foreach ($whyusTitle as $title)
        <div class="counter-text text-center">
            <h6 class="wow fadeInUp">{{ $title->title }}</h6>
        </div>
        @endforeach
        <div class="row">
            @foreach ($progresses as $index => $progress)
                @if ($index % 2 == 0)
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="counter-items">
                            <div class="counter-title">
                                <h2><span class="count">{{ $progress->number }}</span>+</h2>
                            </div>
                            <p class="text-center">{{ $progress->title }}</p>
                        </div>
                    </div>
                @else
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                        <div class="counter-items">
                            <div class="counter-title bg-2">
                                <h2><span class="count">{{ $progress->number }}</span>k+</h2>
                            </div>
                            <p class="text-center">{{ $progress->title }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif