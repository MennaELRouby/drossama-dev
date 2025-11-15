{{-- @if(count($brands) > 0)
<!-- brand area start -->
<section class="brand  brand__bottom-space">
    <div class="container">

        <div class="slider-brand">
            <div class="container">
                <div class="rr-scroller" data-speed="slow">
                    <ul class="text-anim rr-scroller__inner">
                        @foreach ($brands as $key => $brand)
                            <li>
                                <a href="{{ url('uploads/brands/source/' . $brand->logo) }}" data-fancybox="gallery"
                                    data-caption="{{ $brand->{'name_' . $lang} }}">
                                    <img src="{{ url('uploads/brands/source/' . $brand->logo) }}" alt="image not found">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- brand area end -->
@endif --}}