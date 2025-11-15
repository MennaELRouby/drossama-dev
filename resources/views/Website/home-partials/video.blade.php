<!--===============Vedioection==============-->
<section class="video-section">
    <div class="bg-layer parallax-bg" data-parallax='{"y": 100}'
        style="background-image: url('{{ asset('assets/website/images/background/banner.webp') }}');"></div>
    <div class="container">
        <div class="inner-box">
            @foreach ($sections as $section)
                @if ($section->key == 'video')
                    <div class="sec-title light">
                        <h2
                            style="font-size: 2.5rem; font-weight: 700; line-height: 1.3; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                            {{ $section->name }}<br>
                            <span style="color: #7fc3c2;">{{ $section->title }}</span>
                        </h2>
                    </div>
                @endif
            @endforeach
            <div class="video-btn">
                <a aria-label="Youtube Link" href="https://www.youtube.com/embed/9B5ZgFPLNmo?si=eSo4T6kbwUs1aPVm"
                    class="lightbox-image" data-caption=""
                    style="background-image: url('{{ asset('assets/website/images/shape/shape-7.png') }}');"><i
                        class="fas fa-play"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- video-section end -->
